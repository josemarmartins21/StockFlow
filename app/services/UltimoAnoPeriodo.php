<?php

namespace App\services;

use App\services\contracts\PeriodoInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UltimoAnoPeriodo implements PeriodoInterface
{
    private $inicioAnoPassado; 
    private $fimAnoPassado; 
    private $base;


    public function __construct()
    {
        $this->base = Carbon::now()->subYear();
        $this->inicioAnoPassado = $this->base->copy()->startOfYear(); 
        $this->fimAnoPassado = $this->base->copy()->endOfYear();

    }
	public function totalVendas(): int
	{
        return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
        ->count('*');
    }

	public function totalProdutoVendido(): int
	{
		return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
        ->sum('quantity_sold');
	}

	public function totalVendaProdutoMaisVendido()
	{
		return DB::table('produtos')
        ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
        ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida')
        ->whereBetween('vendas.created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
        ->orderByDesc('quantidade_vendida')
        ->limit(1)
        ->first();
	}

	public function produtosMaisVendidos()
	{
		return DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
            ->select('produtos.name as nome', 
            DB::raw('SUM(vendas.quantity_sold) as quantidade_vendida'))
            ->whereBetween('vendas.created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
            ->groupBy('produtos.name')
            ->orderByDesc('quantidade_vendida')
            ->limit(5)
            ->get()
            ->toArray();
	}

	public function vendasPorCategoria()
	{
		return DB::table('vendas')
               ->join('produtos', 'produtos.id', '=', 'vendas.produto_id')
               ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
               ->select('categorias.name as nome', DB::raw('SUM(vendas.quantity_sold * produtos.price) as valor_total'))
               ->whereBetween('vendas.created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
               ->groupBy('categorias.name')
               ->orderByDesc('valor_total')
               ->limit(5)
               ->get()
               ->toArray();
	}

    public function valorTotalVendido()
    {
        return DB::table('vendas')
            ->join('produtos', 'produtos.id', '=', 'vendas.produto_id')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
            ->select(DB::raw('SUM(produtos.price * vendas.quantity_sold) as valor_total_vendido'))
            ->whereBetween('vendas.created_at', [$this->inicioAnoPassado, $this->fimAnoPassado])
            ->get()
            ->toArray();
    }
    
}

