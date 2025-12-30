<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Http\Requests\StoreEstoqueRequest;
use App\Http\Requests\UpdateEstoqueRequest;
use App\Models\Produto;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todos os produtos com seus respectivos estoques ou não.
        return response()->json([
            'status' => true,
            'data' => Estoque::with('produto')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstoqueRequest $request)
    {
        
        $estoque = Estoque::create([
            "current_quantity" => $request->current_quantity, 
            "minimum_quantity" => $request->minimum_quantity, 
            "maximum_quantity" => $request->maximum_quantity,
            "unit_cost_price" => $request->unit_cost_price,
            "total_stock_value" => $request->total_stock_value,
            "stock_date" => $request->stock_date
        ]);

        return response()->json([
            'status' => true,
            'data' => $estoque,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estoque $estoque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstoqueRequest $request, Estoque $estoque)
    {
        // Atualiza um produto na BD.
        $estoque = Estoque::create([
            "current_quantity" => $request->current_quantity, 
            "minimum_quantity" => $request->minimum_quantity, 
            "maximum_quantity" => $request->maximum_quantity,
            "unit_cost_price" => $request->unit_cost_price,
            "total_stock_value" => $request->total_stock_value,
            "stock_date" => $request->stock_date
        ]);

        return response()->json([
            'status' => true,
            'data' => $estoque,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estoque $estoque)
    {
        // Eliminar determinado registro de estoque
        $estoque->delete();

        return response()->json([
            'status' => true,
            'message' => 'Registro eliminado com sucesso!',
        ]);
    }
}
