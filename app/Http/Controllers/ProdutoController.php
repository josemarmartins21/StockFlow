<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        try {
            // Busca o todos os produtos e as categorias de cada produto registrados BD.
            $produtos = Produto::select('produtos.id','produtos.name','categorias.name', 'categorias.id as categoria_id')->join('categorias', 'produtos.categoria_id', '=', 'categoria_id')->get();
            
            return response()->json([
                'status' => true,
                'data' => $produtos
            ]);
            
        } catch(ModelNotFoundException $e) {
            // Retorna uma mensagem explicativa de erro caso a o model soclicitado não exista.
            dd($e->getMessage());

        } catch (BadMethodCallException $e) {
            // Retorna uma mensagem explicativa de erro caso a o metódo soclicitado não exista.
            dd($e->getMessage());
            return back()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return response()->json([
                'status' => true,
                'message' => 'Produto atualido com sucesso!',
            ]);
        }
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
    public function store(StoreProdutoRequest $request)
    {
        // Válida os dados enviados pelo utilizador.
        $request->validated();

        // Registrar um produto na BD.
        $produto = Produto::create([
            "name" => $request->name,
            "price" => $request->price,
            "shpping" => $request->shipping,
            "categoria_id" => $request->categoria_id
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Salvo com suscesso',
            'dados' => $produto,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        try {
            return response()->json([
                'status' => true,
                'data' => collect($produto),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $data = [
            "name" => $request->name,
            "price" => $request->price,
            "shpping" => $request->shipping,
        ];

        
        try {
            // Atualiza os dados de um restigro por model biding.
            $produto->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Produto atualido com sucesso!',
            ]);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 404);

        } catch (BadMethodCallException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        try {
            
            $produto->delete();

            return response()->json([
                'status' => true,
                'message' => 'Registro eliminado com sucesso!',
            ]);

        } catch (ModelNotFoundException $e) {
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
}
