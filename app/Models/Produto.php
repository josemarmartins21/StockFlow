<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function vendas(): HasMany {
        return $this->hasMany(Venda::class);
    }

    public static function ultimoProdutoMaisVendido()
    {
        return DB::select("SELECT produtos.name as nome, vendas.quantity_sold  
            FROM produtos
            JOIN vendas
            ON vendas.produto_id = produtos.id
            WHERE DAY(vendas.created_at) = ?
            ORDER BY vendas.quantity_sold
            DESC", [Carbon::yesterday()->format('d')]);
    }
}
