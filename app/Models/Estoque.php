<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Estoque extends Model
{
    protected $fillable = [
        "produto_id",
        "current_quantity", 
        "minimum_quantity", 
        "maximum_quantity",
        "unit_cost_price",
        "total_stock_value",
        "stock_date",
    ];

    protected $guarded = [];

     public static function totValEstoque()
    {
        return DB::select("SELECT SUM((p.price * e.current_quantity)) AS valor
                        FROM produtos AS p JOIN estoques
                        AS e
                        ON p.id = e.produto_id")[0];
    }

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
        return DB::select("SELECT p.name AS nome, MAX(p.price * e.current_quantity) AS maximo_valor_estoque
        FROM produtos AS p
        JOIN estoques AS e
        ON e.produto_id = p.id
        GROUP BY p.name, 
        e.current_quantity, 
        p.price
        ORDER BY MAX(p.price * e.current_quantity) 
        DESC LIMIT ?", [1])[0];
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
