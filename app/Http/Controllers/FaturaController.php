<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\parttens\factory\vendas\PdfFile;
use Illuminate\Http\Request;

class FaturaController extends Controller
{

public function __construct(
    private PdfFile $pdf,
)
{
    
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faturas = Fatura::orderByDesc('created_at')->get();

        return view('faturas.index', compact('faturas'));
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
    public function store(Request $request)
    {
     //
    }
        
        /**
         * Display the specified resource.
        */
    public function show(Fatura $fatura)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
