<?php

namespace App\parttens\factory\relatorios;

use App\parttens\factory\relatorios\contracts\PeriodoInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        ->where('user_id', Auth::user()->id)
        ->count('*');
    }

	public function totalProdutoVendido(): int
	{
		return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
        ->where('user_id', Auth::user()->id)
        ->sum('quantity_sold');
	}

	public function totalVendaProdutoMaisVendido()
	{
		return DB::table('produtos')
        ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
         ->join('users', 'produtos.user_id', '=', 'users.id')
        ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida')
        ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
        ->where('users.id', Auth::user()->id)
        ->orderByDesc('quantidade_vendida')
        ->limit(1)
        ->first();
	}

	public function produtosMaisVendidos()
	{
		return DB::table('produtos')
            ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
             ->join('users', 'produtos.user_id', '=', 'users.id')
            ->select('produtos.name as nome', 
            DB::raw('SUM(vendas.quantity_sold) as quantidade_vendida'))
            ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
            ->where('users.id', Auth::user()->id)
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
                ->join('users', 'produtos.user_id', '=', 'users.id')
               ->select('categorias.name as nome', DB::raw('SUM(vendas.quantity_sold * produtos.price) as valor_total'))
               ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
               ->where('users.id', Auth::user()->id)
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
            ->join('users', 'produtos.user_id', '=', 'users.id')
            ->select(DB::raw('SUM(produtos.price * vendas.quantity_sold) as valor_total_vendido'))
            ->where('users.id', Auth::user()->id)
            ->whereBetween('vendas.created_at', [$this->inicioSemanaRetrasada, $this->fimSemanaRetrasada])
            ->get()
            ->toArray();
    }
    
}

