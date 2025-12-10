<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */


// Produtos resources
Route::resource('produtos', ProdutoController::class);

// Categorias resources
Route::resource('categorias', CategoriaController::class);
