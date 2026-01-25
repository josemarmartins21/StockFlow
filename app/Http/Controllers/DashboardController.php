<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\services\PeriodoFactory;
use App\TextoFormatacaoTrait;

class DashboardController extends Controller
{
    use TextoFormatacaoTrait;
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        
        try {
            
            $periodo = new PeriodoFactory();
            $concretPeriodo = $periodo->create($request->periodo??'hoje');

            $periodoEscolhido = $this->eliminarCaracteres("_", $request->periodo??'hoje');

            $querys = [
                'produtos_mais_vendidos' => $concretPeriodo->produtosMaisVendidos(),
                'categorias_mais_vendidas' => $concretPeriodo->vendasPorCategoria(),
                'totalVendasDia' => $concretPeriodo->totalVendas(),
                'totalProdutoVendido' => $concretPeriodo->totalProdutoVendido(),
                'totalVendaProdutoMaisVendido' => $concretPeriodo->totalVendaProdutoMaisVendido(),
                'valorTotalVendido' => $concretPeriodo->valorTotalVendido()[0]->valor_total_vendido,
            ];

            return view('pages.dashboard', compact('querys', 'periodoEscolhido'));
            
        } catch (\Exception $e) {
           return redirect()->back()->with('erro', $e->getMessage());
           
        }
    }
}
