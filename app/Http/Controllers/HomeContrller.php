<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\User;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeContrller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   try {
            // Busca o todos os produtos e as categorias de cada produto registrados BD.
            $produtos = DB::table('estoques')
            ->join('produtos', 'produtos.id','=', 'estoques.produto_id')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
            ->select('produtos.name as nome_produto', 'estoques.current_quantity', 'categorias.name', 'produtos.price', 'produtos.id')
            ->paginate(5);
            
            $user = User::where('id', Auth::user()->id)->select('name')->get();
            
            return view('home', ['produtos' => $produtos, 'user' => $user]);
            
        } catch(ModelNotFoundException $e) {
            // Retorna uma mensagem explicativa de erro caso a o model soclicitado não exista.
            dd($e->getMessage());

        } catch (BadMethodCallException $e) {
            // Retorna uma mensagem explicativa de erro caso a o metódo soclicitado não exista.
            dd($e->getMessage());
            return back()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    
    }
}
