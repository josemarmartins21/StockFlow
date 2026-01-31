<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
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
            if (!$request->busca) {
                // Busca o todos os produtos e as categorias de cada produto registrados BD.
                $produtos = DB::table('estoques')
                ->join('produtos', 'produtos.id','=', 'estoques.produto_id')
                ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
                ->select('produtos.name as nome_produto', 'estoques.current_quantity', 'estoques.total_stock_value', 'produtos.price', 'produtos.id')
                ->where('produtos.user_id', Auth::user()->id)
                ->orderBy('produtos.name')
                ->paginate(5);

            } else {
                $produtos = DB::table('estoques')
                ->join('produtos', 'produtos.id','=', 'estoques.produto_id')
                ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
                ->select('produtos.name as nome_produto', 'estoques.current_quantity', 'estoques.total_stock_value', 'produtos.price', 'produtos.id')
                ->where('produtos.user_id', Auth::user()->id)
                ->where('produtos.name', 'like', "%" . $request->busca . "%")
                ->orderBy('produtos.name')
                ->paginate(5);
                
            }

            $user = User::select('name')->where('id', Auth::user()->id)->first();

            session()->put('usuario', $user->name);

            $total_em_estoque = DB::table('estoques')
                                ->join('produtos', 'produtos.id', '=', 'estoques.produto_id')
                                ->join('users', 'users.id', '=', 'produtos.user_id')
                                ->selectRaw('sum(estoques.current_quantity) as total_em_estoque')
                                ->where('users.id', Auth::user()->id)
                                ->get();
            return view('home', [
                'produtos' => $produtos,
                'menor_estoque' => Estoque::menorEstoque(),
                'maior_valor_estoque' => Estoque::maiorValorEstoque(),
                'total_em_estoque' => $total_em_estoque[0]->total_em_estoque??0,
                'total_valor_estoque' => Estoque::totValEstoque(),
            ]);
            
        } catch(ModelNotFoundException $e) {
            dd($e->getMessage());
            // Retorna uma mensagem explicativa de erro caso a o model soclicitado não exista.
            return back()->with('erro', $e->getMessage());

        } catch (BadMethodCallException $e) {
            dd($e->getMessage());
            // Retorna uma mensagem explicativa de erro caso a o metódo soclicitado não exista.
            return back()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            dd($e->getMessage());
            return back()->with('erro', $e->getMessage());
        }
    
    }
}
