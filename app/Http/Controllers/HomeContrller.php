<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class HomeContrller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   try {
            // Busca o todos os produtos e as categorias de cada produto registrados BD.
            $produtos = Produto::select('produtos.id','produtos.name','categorias.name', 'categorias.id as categoria_id')->join('categorias', 'produtos.categoria_id', '=', 'categoria_id')->get();
            
            return view('home', ['produtos' => $produtos]);
            
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
        return view('home');
    }
}
