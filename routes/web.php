<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\HomeContrller;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoPdfController;
use Illuminate\Support\Facades\Route;

// Rotas autenticadas
Route::group(['middleware' => 'auth'], function() {
    // Home invokable 
    Route::get('/', HomeContrller::class)->name('home');
    
    // Produtos resources
    Route::resource('produtos', ProdutoController::class);

    // Categorias resources
    Route::resource('categorias', CategoriaController::class);
    
    // Vendas resources
    Route::resource('vendas', VendaController::class);
    
    // Estoque
    Route::resource('estoques', EstoqueController::class)->except(['show', 'create']);

    // Deslogar
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');       

    // Baixar PDF
    Route::get('/baixar-pdf-produto', [ProdutoPdfController::class, 'baixarPdf'])->name('produto.pdf.downlod');

});     

// Rotas desautenticadas
Route::group(['middleware' => 'guest'], function() {
    // Página de login 
    Route::view('/login', 'login')->name('login');
    
    // Logar 
    Route::post('/login',[AuthController::class, 'logar'])->name('auth.login');

  
});






