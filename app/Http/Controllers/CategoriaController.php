<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // Busca todas as categorias.
        $categorias = Categoria::select('id','name', 'image')->get();

        return response()->json([
            'status' => true,
            'data' => $categorias
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        
        try {
            // Válida os dados enviados pelo utilizador.
            $request->validated();

            // Salvar um categoria na BD.
            Categoria::create([
                "name" => $request->name,
                "status" => $request->status ? $request->status : 0,
                "image" => $request->image ? $request->image : 'categoria-imagem', 
                "desc" => $request->desc ? $request->desc : '',
                //'user_id' => Auth::user()->id ? Auth::user()->id : $request->user_id
            ]);
           
        } catch (BadMethodCallException $e) {
            // Retorna uma mensagem explicativa de erro caso a o metódo soclicitado não exista.
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (ModelNotFoundException $e) {
             // Retorna uma mensagem explicativa de erro caso a o model soclicitado não exista.
             return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
             return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        // Retorna uma categoria pelo model biding
        return response()->json([
            'status' => true,
            'data' => $categoria,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        // Atualizar os dados de uma cetegoria
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'image' => $request->image ? $request->image : 'categoria-imagem',
            'desc' => $request->desc
        ];

        $categoria->update($data);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
    }
}
