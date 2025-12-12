<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Http\Requests\StoreVendaRequest;
use App\Http\Requests\UpdateVendaRequest;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendaRequest $request)
    {
        // Salvar registro de uma venda na BD.
        $this->vendas->create([
            "quantity_sold"  =>  $request->quantity_sold,
            "produto_id" => $request->produto_id,
            "note" => $request->note
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registro efectuado com sucesso!',
            'data' => $this->vendas->all() 
        ], 201);
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
}
