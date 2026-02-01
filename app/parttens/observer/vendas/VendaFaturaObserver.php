<?php
namespace App\parttens\observer\vendas;

use App\Models\Venda;
use App\parttens\observer\vendas\contracts\VendaFaturaInterface;
  use Barryvdh\DomPDF\Facade\Pdf;

class VendaFaturaObserver implements VendaFaturaInterface {
    private readonly Venda $venda;
    public function __construct(
        private $vendasId = [],
    )
    {
    }
    public function update(): void
    {
        dd(Venda::find($this->vendasId));
       //Pdf::loadView('pdf.faturas.invoice', ['vendasId' => $this->vendasId]);
    }
}