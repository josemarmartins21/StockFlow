<?php

namespace App\Http\Controllers;

use App\Helpers\ImagemProduto;
use App\Helpers\ImagemVenda;
use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Categoria;
use App\Models\Estoque; 
use BadMethodCallException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    private readonly Categoria $categoria;
    private readonly Estoque $estoque;

    public function __construct()
    {
        $this->categoria = new Categoria();
        $this->estoque = new Estoque();
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categorias = $this->categoria->all('id', 'name');
            
            return view('produtos.create', ['categorias' => $categorias]);
            
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        define('PRODUTO_IMAGEM', 'image');

        $imagemProduto = new ImagemProduto($request);

        // Válida os dados enviados pelo utilizador.
        $request->validated();


        // Registrar o produto na BD.
        $produto = Produto::create([
            "name" => $request->name,
            "price" => $request->price,
            "shpping" => $request->shipping,
            "image" => $imagemProduto->getName(),
            "categoria_id" => $request->categoria_id  
        ]);

        // Registra o estoque do produto e faz o calculo para determinar quanto vale actualmente.
        $this->estoque->create([
            'produto_id' => $produto->id, /** Relaciona o estoque com o produto  */
            'current_quantity' => $request->current_quantity,
            'minimum_quantity' => $request->minimum_quantity,
            'maximum_quantity' => $request->max_quantity,
            'total_stock_value' => $request->current_quantity * $produto->price, /** Valor total */
            'stock_date' => Carbon::now()->format('Y-m-d'), /** data actual */
        ]);

        $imagemProduto->save($request); /** Salva a imagem do produto */

        return redirect()->route('home');     
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        try {
            $artigo = DB::table('produtos')
            ->join('estoques', 'produtos.id', '=', 'estoques.produto_id')
            ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')->select(
                'produtos.name as nome', 
                'produtos.price as preco', 
                'produtos.shpping as envio', 
                'produtos.image as imagem', 
                'categorias.name as categoria',
                'estoques.current_quantity as quantidade', 
                'estoques.minimum_quantity as estoque_minimo', 
                'estoques.maximum_quantity as estoque_maximo', 
                'estoques.total_stock_value as valor_estoque'
            )->where('produtos.id', $produto->id)->first();
            return view('produtos.show', compact('artigo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        try {
    
            $produto = DB::table('produtos')
            ->join('estoques', 'produtos.id', '=', 'estoques.produto_id')
            ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')
            ->where('produtos.id', $produto->id)
            ->first([
                'produtos.name', 
                'produtos.image', 
                'produtos.id', 
                'produtos.price', 
                'produtos.shpping', 
                'produtos.categoria_id', 
                'estoques.produto_id',
                'estoques.current_quantity',
                'estoques.minimum_quantity',
                'estoques.maximum_quantity',
                'estoques.total_stock_value',
            ]);
            
            // Busca as outras categorias disponíveis
            $categorias = Categoria::select('name', 'id')->where('id', '<>', $produto->categoria_id)->get();

            // Busca a categoria do produto a ser actualizado
            $categoria_do_produto = Categoria::where('id', $produto->categoria_id)->first(['name', 'id']);
            
            return view('produtos.edit', 
            compact('produto', 'categorias', 'categoria_do_produto'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        try {
            $request->validated();

            define('PRODUTO_IMAGEM', 'image');
            $imagemProduto = new ImagemProduto($request);

            // Selecção dos campos para serem atualizados na tabela produtos e estoques
            $produto_datas = $request->only('name', 'price', 'shpping', 'categoria_id', 'image');
            $estoque_datas = $request->only('current_quantity', 'minimum_quantity', 'maximum_quantity');
    
            // Calcula o valor do estoque actual para ser actualizado
            $estoque_datas['total_stock_value'] = $estoque_datas['current_quantity'] * $produto_datas['price'];
    
            $produto_datas['image'] = $imagemProduto->getName();

            // Atualiza os dados de um restigro por model biding.
            $updatedProduto = $produto->update($produto_datas);

            $imagemProduto->save($request); 
            
            // Atualiza o estoque do um produto
            $updatedEstoque =  $produto->estoque->update($estoque_datas);

            return redirect()->route('produtos.show', ['produto' => $produto->id])->with('suecesso', 'Produto actualizado com sucesso!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        } catch (BadMethodCallException $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        try {
            $produto->delete();
            return redirect()->route('home')->with('sucesso', 'Produto eliminado com sucesso!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('erro', "Produto associado a uma venda");
        }
    }
}
