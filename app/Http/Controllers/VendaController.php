<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Http\Requests\StoreVendaRequest;
use App\Http\Requests\UpdateVendaRequest;
use App\Models\Produto;
use App\Models\Estoque;     
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\ImagemVenda;

class VendaController extends Controller
{
   
    private readonly Venda $vendas;
    private readonly Produto $produto;
    private readonly Estoque $estoque;

    public function __construct()
    {
        $this->vendas = new Venda();
        $this->produto = new Produto();
        $this->estoque = new Estoque();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HttpRequest $request)
    {
    
        try {

        $houvePesquisa = false;

        if (! $request->busca) {
            // Buscar todas as vendas já realizadas
            $vendas = DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
            ->join('estoques', 'estoques.produto_id', '=', 'produtos.id')
            ->join('users', 'users.id', '=', 'vendas.user_id')
            ->select('vendas.id as venda_id', 'produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida', 'vendas.created_at as dia_venda', 'vendas.stock_value as valor_total_do_estoque', 'produtos.price as preco', 'users.name as nome_funcionario', 'produtos.id as produto_id')
            ->whereMonth('vendas.created_at', Carbon::now()->format('m'))
            ->orderBy('vendas.created_at', 'desc')
            ->paginate(3);

        } else {
            // Buscar todas as vendas já realizadas
            $vendas = DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
            ->join('estoques', 'estoques.produto_id', '=', 'produtos.id')
            ->join('users', 'users.id', '=', 'vendas.user_id')
            ->select('vendas.id as venda_id', 'produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida', 'vendas.created_at as dia_venda', 'vendas.stock_value as valor_total_do_estoque', 'produtos.price as preco', 'users.name as nome_funcionario', 'produtos.id as produto_id')
            ->where('produtos.name', 'like', '%' . $request->busca .'%')
            ->orderBy('vendas.created_at', 'desc')
            ->get();

            $houvePesquisa = true;
        }

        $somatorioVendas = $this->somatorioVendas($vendas);

        $produtos = Produto::select('id','name')->orderBy('name')->get();
            
            // Formulário de vendas 
            return view('vendas.create', compact('vendas', 'produtos', 'houvePesquisa', 'somatorioVendas'));
        } catch (ModelNotFoundException $e) {
           return redirect()->back()->withInput()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    public function show(Venda $venda)
    {
        $produto = $venda->produto;
        return view('vendas.show', compact('venda', 'produto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendaRequest $request)
    {
        try {
            $request->validated();
            define('IMAGE', 'image');
            $imagem = new ImagemVenda($request, IMAGE);
            
            $produto = Produto::findOrFail($request->produto_id); // Buscar produto o vendido 
            $estoque = $produto->estoque->toArray();

            // Verificar se a quantidade de produto vendida é maior que a quantidade do estoque.
            $this->validarQuantidadeVendida($request, $estoque["current_quantity"]);
           
           // Salva o registro da venda na BD.
            $venda = $this->vendas->create([
                "quantity_sold"  =>  $estoque["current_quantity"] - $request->quanto_sobrou,
                "note" => $request->note,
                'produto_id' => $request->produto_id,
                'stock_value' => $request->quanto_sobrou * $produto->price,
                'user_id' => Auth::user()->id,
                'image' => $imagem->getName(),
            ]);

            if (!empty($imagem->getName())) {
                // Salvar a imagem
                $request->file(IMAGE)->move(public_path('/assets/imagens/estoques'), $imagem->getName());
            }
            
            // Decrementa a quantidade de produto vendida no estoque
            Produto::findOrFail($request->produto_id)->estoque->decrement('current_quantity', $venda->quantity_sold);
            Produto::findOrFail($request->produto_id)->estoque->decrement('total_stock_value', ($venda->quantity_sold * $produto->price));

            return redirect()->route('vendas.create')->with('sucesso', 'Venda registrada com sucesso! O PDF é válido até amanhã');
            
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /* 
        // Pegar produto
        // Pegar estoque 
    */
    // pegar qtd que sobrou
    // incrementar no estoque
    public function destroy(Venda $venda, Request $request)
    {

        $estoque = $this->estoque->where('produto_id', $request->produto_id)->first();
        $quantidadeVendida = $venda->quantity_sold;

        $venda->delete();

        $estoque->increment('current_quantity', $quantidadeVendida); /** Incrementar o que havia sido vendido*/
        
        return redirect()->route('vendas.create')->with('sucesso', 'Produto eliminado com sucesso!');
    }

    /**
     * Valida a se quantidade vendida é maior que 
     * a quantidade que se tem no estoque.
     * 
     * @param StoreVendaRequest $request
     * @param int $estoque_actual
     * 
     * @return void
     */
    private function validarQuantidadeVendida(StoreVendaRequest $request, int $estoque_actual): void {
        if ($request->quanto_sobrou > $estoque_actual) {
            throw new Exception("A quantidade de produto que sobrou tem que ser menor ou igual a quantidade que há no estoque actual");
        }
       
    }

    private function somatorioVendas($vendas = []): int {
        $somatorioVendas = 0;
        foreach ($vendas as $venda) {
            $somatorioVendas += $venda->quantidade_vendida * $venda->preco;
        }

        return $somatorioVendas;
    }
}
