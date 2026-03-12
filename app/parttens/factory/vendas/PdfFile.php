<?php
namespace App\parttens\factory\vendas;

use App\Models\Fatura;
use App\Models\Venda;
use App\parttens\factory\vendas\contracts\FileInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PdfFile implements FileInterface {
    //private int $totalVendido;
    private $Dados = [];

    public function __construct ()
    {   
        //$this->totalVendido = Venda::getTotalVendido();
    }
   /*  public function baixar()
    {
        
        $pdf = Pdf::loadView('pdf.vendas.vendas', [
            'vendas' => $this->dados, 
            'total_vendido' => $this->totalVendido,
        ]); 

        return $pdf->download('vendas_' . date('d_m_Y') . '.pdf');
    } */

  /*   public function visualizar()
    {

        $pdf = Pdf::loadView('pdf.vendas.vendas', [
            'vendas' => $this->dados, 
            'total_vendido' => $this->totalVendido,
        ]);

        return $pdf->stream();
    } */

    public function salvar($Dados = []): void
    {
        $this->setDados($Dados);
        $pdf = Pdf::LoadView('pdf.faturas.invoice', ['faturas' => $this->getDados()]);

        $conteudo = $pdf->output();

        $caminho = Carbon::now()->format('d_m_Y_H_i_s') . '.pdf';

        $ultimaFatura = Fatura::latest()->first();

        $numero = 'FAT-' . date('Y') . '-' . str_pad($ultimaFatura->id??0, 5, '0', STR_PAD_LEFT);

        Fatura::create([
            'path' => $caminho,
            'numero' => $numero, 
            'user_id' => Auth::user()->id,
        ]);

        Storage::disk('public')->put($caminho, $conteudo);
    }

    public function setDados($Dados = []): void
    {
        $this->Dados = $Dados;
    }

    private function getDados(): array
    {
       $Dados = DB::table('vendas')->join('produtos', 'vendas.produto_id', '=', 'produtos.id')
       ->select('vendas.*', 'produtos.name as nome', 'produtos.price as preco')
       ->whereIn('vendas.id', $this->Dados)
       ->get();

       return $Dados->toArray();
    }
}