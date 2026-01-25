<?php

namespace App\services;

use App\services\contracts\PeriodoInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UltimaSemanaPeriodo implements PeriodoInterface
{
    private $inicioSemanaRetrasada; 
    private $fimSemanaRetrasada; 
    public function __construct()
    {
        $this->inicioSemanaRetrasada = Carbon::now()
        ->subWeeks()->startOfWeek();
        $this->fimSemanaRetrasada = Carbon::now()->subWeeks()->endOfWeek();

    }
	public function totalVendas(): int
	{
        return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
        ->count('*');
    }

	public function totalProdutoVendido(): int
	{
		return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
        ->sum('quantity_sold');
	}

	public function totalVendaProdutoMaisVendido()
	{
		return DB::table('produtos')
        ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
        ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida')
        ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
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
            ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
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
               ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
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
            ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
            ->get()
            ->toArray();
    }
    
}

