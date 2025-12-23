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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
           
            // Desempenho actual da categoria. Alta ou baixa 1 - 0
            $table->boolean('status')->nullable()->default(0);
           
            // Files imagem da categoria 
            $table->string('image')->nullable()->default('categoria-imagem');
           
            // Detalhes da categoria
            $table->text('desc');

            // Relacionamentos
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
