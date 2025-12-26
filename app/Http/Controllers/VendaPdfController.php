<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VendaPdfController extends Controller
{
    private $pdf;

    /**
     * Descarregar pdf das vendas
     * @return Response
     */
    public function baixarPdf()
    {
        try {
            // Captura o mês e o ano actual
            $mesAnoActual = Carbon::now()->format('m_Y');

            $this->pdf = Pdf::loadView('pdf.vendas.vendas', ['vendas' => $this->getDados()]); 

            return $this->pdf->download('vendas_' . $mesAnoActual . '.pdf');
    
        } catch (Exception $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        }
    }
    
    /**
     * Retorna página para visualizar o pdf
     * @return Response
     */
    public function visualizarPdf()
    {
        try {
            $this->pdf = Pdf::loadView('pdf.vendas.vendas', ['vendas' => $this->getDados()]);
            return $this->pdf->stream();
            
        } catch (Exception $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        }
        
    }

    /**
     * Busca todas as vendas realizadas neste mês e ano
     * @return array
     */
    public function getDados(): array
    {
        $dados = DB::table('produtos')
       ->join('vendas', 'vendas.produto_id', '=', 'produtos.id')
       ->join('estoques', 'estoques.produto_id', '=', 'produtos.id')
       ->join('users', 'users.id', '=', 'vendas.user_id')
       ->select('produtos.name as nome', 'vendas.quantity_sold as quantidade_vendida', 'vendas.created_at as dia_venda', 'vendas.stock_value as valor_total_do_estoque', 'produtos.price as preco', 'users.name as nome_user')
       ->whereDay('vendas.created_at', Carbon::today()->format('d'))->get();

       if (count($dados) === 0) {
        throw new Exception("Nenhuma venda registrada");
       }

       return $dados->toArray();

    }
}
