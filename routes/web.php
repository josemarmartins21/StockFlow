<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\HomeContrller;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

// Home invokable 
Route::get('/', HomeContrller::class);

// Produtos resources
Route::resource('produtos', ProdutoController::class);

// Categorias resources
Route::resource('categorias', CategoriaController::class);

// Vendas resources
Route::resource('vendas', VendaController::class);

// Estoque
Route::resource('estoques', EstoqueController::class)->except(['show', 'create']);
