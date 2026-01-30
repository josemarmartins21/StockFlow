<?php

namespace App\services;

use App\services\contracts\PeriodoInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UltimoMesPeriodo implements PeriodoInterface
{
    private $inicioMesPassado; 
    private $fimMesPassado; 
    private $base;


    public function __construct()
    {
        $this->base = Carbon::now()->subMonth();
        $this->inicioMesPassado = $this->base->copy()->startOfMonth(); 
        $this->fimMesPassado = $this->base->copy()->endOfMonth();

    }
	public function totalVendas(): int
	{
        return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioMesPassado, $this->fimMesPassado])
        ->count('*');
    }

	public function totalProdutoVendido(): int
	{
		return DB::table('vendas')
        ->whereBetween('created_at', [$this->inicioMesPassado, $this->fimMesPassado])
        ->sum('quantity_sold');
	}

	public function totalVendaProdutoMaisVendido()
	{
		return DB::table('produtos')
        ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
        ->join('users', 'produtos.user_id', '=', 'users.id')
        ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida')
        ->whereBetween('vendas.created_at', [$this->inicioMesPassado, $this->fimMesPassado])
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
            ->whereBetween('vendas.created_at', [$this->inicioMesPassado, $this->fimMesPassado])
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
               ->whereBetween('vendas.created_at', [$this->inicioMesPassado, $this->fimMesPassado])
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
            ->whereBetween('vendas.created_at', [$this->inicioMesPassado, $this->fimMesPassado])
            ->where('users.id', Auth::user()->id)
            ->get()
            ->toArray();
    }
    
}

