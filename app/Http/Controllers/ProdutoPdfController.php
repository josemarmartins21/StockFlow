<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoPdfController extends Controller
{
    // Gerar baixar pdf da tabela produtos
    public function baixarPdf()
    {
        // Busca o todos os produtos e as categorias de cada produto registrados BD.
        $produtos = DB::table('estoques')
        ->join('produtos', 'produtos.id','=', 'estoques.produto_id')
        ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
        ->select('produtos.name as nome_produto', 'estoques.current_quantity', 'categorias.name', 'produtos.price')
        ->get();
            
        $pdf = Pdf::loadView('pdf.produtos.produtos', ['produtos' => $produtos->toArray()]);
        
        return $pdf->download("produtos_" . Carbon::now()->format('d_m_Y') . ".pdf");
    }

    public function gerarPdf()
    {
        
    }
}
