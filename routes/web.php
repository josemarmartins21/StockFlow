<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\HomeContrller;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdutoPdfController;
use App\Http\Controllers\VendaPdfController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rotas autenticadas
Route::group(['middleware' => 'auth'], function() {
    Route::post('vendas/registrar', [VendaController::class, 'registrarVenda'])->name('vendas.registrar');
    
    Route::get('vendas/registrar', [VendaController::class, 'limparVendas'])->name('vendas.limpar');

    // Home invokable 
    Route::get('/', HomeContrller::class)->name('home');
    
    // Produtos resources
    Route::resource('produtos', ProdutoController::class);

    Route::post('/produtos/atualizar-estoque/{produto}', [EstoqueController::class, 'atualizarEstoque'])->name('estoques.atualizar-estoque');

    Route::post('/produtos/decrement-estoque/{produto}', [EstoqueController::class, 'decrementarEstoque'])->name('estoques.decrementar-estoque');

    Route::post('/produtos/icrement-estoque/{produto}', [EstoqueController::class, 'incrementarEstoque'])->name('estoques.incrementar-estoque');

    // Categorias resources
    Route::resource('categorias', CategoriaController::class);
    
    // Vendas resources
    Route::resource('vendas', VendaController::class)->except(['index', 'edit', 'update',]);
    
    // Estoque
    Route::resource('estoques', EstoqueController::class)->except(['show', 'create', 'index', 'update', 'delete']);

    // Deslogar
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');       

    // Baixar PDF dos produtos
    Route::get('/baixar-pdf-produto', [ProdutoPdfController::class, 'baixarPdf'])->name('produto.pdf.downlod');

    //  Baixar PDF das vendas
    Route::get('/baixar-pdf-venda', [VendaPdfController::class, 'baixarPdf'])->name('venda.pdf.download');
    Route::get('/stream-pdf-venda', [VendaPdfController::class, 'visualizarPdf'])->name('venda.pdf.stream');

    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('pages.dashboard');

});     

// Rotas desautenticadas
Route::group(['middleware' => 'guest'], function() {
    // Página de login 
    Route::view('/login', 'login')->name('login');
    
    // Logar 
    Route::post('/login',[AuthController::class, 'logar'])->name('auth.login');
});






