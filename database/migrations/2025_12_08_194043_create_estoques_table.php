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
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            
            // Relacionamentos
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            
            // Quantidade
            $table->integer('current_quantity')->default(0);
            $table->unsignedTinyInteger('minimum_quantity')->default(4);
            $table->integer('maximum_quantity')->default(1000);

            // Custo e Valor
            $table->decimal('unit_cost_price', 10, 2)->default(0);
            $table->decimal('total_stock_value', 10, 2)->default(0);
            
            // Data de aquisição
            $table->date('stock_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
