<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // Busca todas as categorias.
        $categorias = Categoria::select('id','name', 'image', 'desc')->get();
  
        return view('categorias.index', ['categorias' => $categorias,/* 'total_categoria' => $categorias->produtos->count() */]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
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
                "image" => $request->image ? $request->image : 'categoria-imagem', 
                "desc" => $request->desc,
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->route('categorias.index')->with('sucesso', 'Categoria criada com sucesso!');
           
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

        $produtos = DB::table('categorias')
        ->join('produtos', 'categorias.id', '=', 'produtos.categoria_id')
        ->join('estoques', 'estoques.produto_id', '=', 'produtos.id')
        ->select('produtos.name as nome', 'estoques.current_quantity as quantidade', 'produtos.price as preco', 'produtos.id as produto_id', 'produtos.image as imagem')->get();
        // Retorna uma categoria pelo model biding
        return view('categorias.show', [
            'categoria' => $categoria,
            'produtos' => /* $categoria->with('produtos')
            ->where('id', $categoria->id)
            ->first()['produtos']->join('estoques', 'produtos.id', '=', 'estqoues.produto_id') */ $produtos, 
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
