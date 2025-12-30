<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Produto extends Model
{
    protected $fillable = ['name', "price","categoria_id", "shpping"];
    protected $guarded = [];
    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public static function estoqueMinimo(int $menorEstoque)
    {
        return DB::select("SELECT p.name, e.current_quantity as quantidade FROM estoques AS e JOIN   produtos AS p
        ON p.id = e.produto_id
        WHERE e.current_quantity < ? LIMIT ?", [$menorEstoque, 1]              
        );
    }

    public static function ultimoProdutoMaisVendido()
    {
        return DB::select("SELECT v.quantity_sold as quantidade_vendida, p.name as nome FROM vendas AS v JOIN 
        produtos AS p
        ON v.produto_id = p.id
        ORDER BY v.quantity_sold DESC 
        LIMIT ? ", [1]);
    }
}
