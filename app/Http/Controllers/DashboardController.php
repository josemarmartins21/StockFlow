<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $querys = [
            'produtos_mais_vendidos' => $this->produtosMaisVendidos(),
            'categorias_mais_vendidas' => $this->vendasPorCategoria(),
            'totalVendasDia' => $this->totalVendasDia(),
            'totalProdutoVendido' => $this->totalProdutoVendido(),
            'totalVendaProdutoMaisVendido' => $this->totalVendaProdutoMaisVendido(),
        ];

        return view('pages.dashboard', compact('querys'));
    }

    private function totalVendasDia(): int {
        return DB::table('vendas')
        ->whereDay('created_at', Carbon::today()->format('d'))
        ->count('*');
    }

    private function totalProdutoVendido() : int {
        return DB::table('vendas')->
        whereDay('created_at', Carbon::today()->format('d'))
        ->sum('quantity_sold');
    }

    private function totalVendaProdutoMaisVendido() {
        return DB::table('produtos')
        ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
        ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida')
        ->whereDay('vendas.created_at', Carbon::today()->format('d'))
        ->orderByDesc('quantidade_vendida')
        ->limit(1)
        ->first();
    }

    private function produtosMaisVendidos() {
        return DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
            ->select('produtos.name as nome', 
            DB::raw('SUM(vendas.quantity_sold) as quantidade_vendida'))
            ->groupBy('produtos.name')
            ->orderByDesc('quantidade_vendida')
            ->limit(5)
            ->get()
            ->toArray();
    }

    private function vendasPorCategoria() {
        return DB::table('vendas')
               ->join('produtos', 'produtos.id', '=', 'vendas.produto_id')
               ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
               ->select('categorias.name as nome', DB::raw('SUM(vendas.quantity_sold * produtos.price) as valor_total'))
               ->groupBy('categorias.name')
               ->orderByDesc('valor_total')
               ->limit(5)
               ->get()
               ->toArray();

    }
}
