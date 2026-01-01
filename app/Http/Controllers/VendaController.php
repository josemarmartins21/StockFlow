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
    public function create()
    {
        try {

            // Buscar todas as vendas já realizadas
            $vendas = DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
            ->join('estoques', 'estoques.produto_id', '=', 'produtos.id')
            ->join('users', 'users.id', '=', 'vendas.user_id')
            ->select('vendas.id as venda_id', 'produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida', 'vendas.created_at as dia_venda', 'vendas.stock_value as valor_total_do_estoque', 'produtos.price as preco', 'users.name as nome_funcionario', 'produtos.id as id')
            ->whereDay('vendas.created_at', Carbon::today()->format('d'))->paginate(5);
            
            // Formulário de vendas 
            return view('vendas.create', ['produtos' => Produto::select('id','name')->get(), 'vendas' => $vendas]);
        } catch (ModelNotFoundException $e) {
           return redirect()->back()->withInput()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendaRequest $request)
    {
        try {
            $request->validated();
            
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
            ]);
            
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

    public function destroy(Venda $venda, Request $request)
    {
        // Pegar produto
        // Pegar estoque
        // pegar qtd vendida
        // incrementar no estoque

        $produto = Produto::where('id', $venda->produto_id)->first();

        //$venda->with('produto')->where('id', $request->venda_id)->get();
        dd($this->estoque->where('produto_id', $produto->id)->get());
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
}
