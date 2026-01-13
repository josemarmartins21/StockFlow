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
    protected $fillable = [
        'name', 
        "price",
        "categoria_id", 
        "shpping", 
        "image",
    ];
    
    protected $guarded = [];
    
    public static function menorEstoque()
    {
        return DB::select("SELECT  
                    p.name as nome_produto, 
                    MIN(e.current_quantity) as quantidade FROM estoques
                    AS e JOIN produtos AS p
                    ON p.id = e.produto_id
                    GROUP BY p.`name`, e.current_quantity
                    ORDER BY e.current_quantity LIMIT ?", [1])[0];
    }

    public static function maiorValorEstoque()
    {
        return DB::select("SELECT p.name AS nome, MAX(e.total_stock_value) AS maximo_valor_estoque FROM produtos AS p
                    JOIN estoques AS e
                    ON p.id = e.produto_id
                    GROUP BY p.name, e.total_stock_value
                    ORDER BY MAX(e.total_stock_value) 
                    DESC LIMIT ?", [1]);
    }

    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class);
    }
    
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function vendas(): HasMany {
        return $this->hasMany(Venda::class);
    }
}
