<?php

namespace App\parttens\factory\relatorios\contracts;

interface PeriodoInterface
{
    public function totalVendas(): int;
    public function totalProdutoVendido(): int;
    public function totalVendaProdutoMaisVendido();
    public function produtosMaisVendidos();
    public function vendasPorCategoria();
    public function valorTotalVendido();
}
