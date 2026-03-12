<?php
namespace App\parttens\observer\vendas;

use App\Models\Venda;
use App\parttens\factory\FileFactory;
use App\parttens\observer\vendas\contracts\VendaFaturaInterface;
  use Barryvdh\DomPDF\Facade\Pdf;

class VendaFaturaObserver implements VendaFaturaInterface {
    public function __construct(
        private $vendasId = [],
        private FileFactory $factory,
    )
    {
    }
    public function update(): void
    {
        $pdf = $this->factory->create('pdf');
        $pdf->salvar($this->vendasId);
    }
}