<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('numero')->unique();
            $table->timestamps();
            
      /*       $table->string('forma_pagamento'); */
            /* // Número visível da fatura (ex: FAT-001)

            // Valor total
            $table->decimal('total', 10, 2)->nullable(); */

            // dinheiro | multicaixa | transferencia

            /* $table->string('status')->default('pago'); */
            // pago | pendente | cancelado

            // caminho do pdf salvo no storage

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas');
    }
};
