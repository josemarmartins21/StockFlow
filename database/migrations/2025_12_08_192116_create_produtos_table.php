<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();

            // Nome
            $table->string('name', 50);
            
            // Valor de aquisição do produto
            $table->decimal('price', 10, 2);
            $table->decimal('shpping', 10, 2)->nullable();
            
            // Chaves entrangeiras
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->restrictOnDelete()->cascadeOnUpdate();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
