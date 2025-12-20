<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Http\Requests\StoreVendaRequest;
use App\Http\Requests\UpdateVendaRequest;
use App\Models\Produto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{

    private readonly Venda $vendas;

    public function __construct()
    {
        $this->vendas = new Venda();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todas a vendas da BD com seus respectivos produtos.
        $vendas = $this->vendas->select('produtos.name', 'vendas.quantity_sold', 'produtos.price', 'vendas.created_at')->join('produtos', 'produtos.id', '=', 'vendas.produto_id')->get();

        dd($vendas);
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
            ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida', 'vendas.created_at as dia_venda', 'estoques.total_stock_value as valor_total_do_estoque', 'produtos.price as preco')
            ->paginate(5);
            
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
            
            $produto = Produto::findOrFail($request->produto_id)->estoque; // Buscar produto o vendido e seu estoque actual
            
            // Verificar se a quantidade de produto vendida é maior que a quantidade do estoque.
            $this->validarQuantidadeVendida($request, $produto->current_quantity);
           
           // Salva o registro da venda na BD.
            $venda = $this->vendas->create([
                "quantity_sold"  =>  $request->quantity_sold,
                "note" => $request->note,
                'produto_id' => $request->produto_id,
                'user_id' => Auth::user()->id,
            ]);
            
            // Decrementa a quantidade de produto vendio no estoque
            $produto->decrement('current_quantity', $request->quantity_sold);

            return redirect()->route('vendas.create')->with('sucesso', 'Venda registrada com sucesso!');
            
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venda $venda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venda $venda)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendaRequest $request, Venda $venda)
    {
        // Editar o registro de uma venda.
        $data = [
            'quantity_sold' => $request->quantity_sold,
            'note' => $request->note
        ];

        $updated = $venda->update($data);

        return response()->json([
            'status' => true,
            'message' => $updated,
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venda $venda)
    {
        // Eliminar o registro de uma venda na BD.
        $apagado = $venda->delete();
        return response()->json([
            'status' => true,
            'message' => $apagado,
        ], 201);

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
        if ($request->quantity_sold > $estoque_actual) {
            throw new Exception("A quantidade de produto vendida não pode ser maior que quantidade que tem no estoque.");
        }
       
    }
}
