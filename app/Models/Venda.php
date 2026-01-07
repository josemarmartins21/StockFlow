<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Venda extends Model
{
    protected $fillable = [
        'note', 
        'produto_id', 
        'quantity_sold', 
        'user_id',
        'stock_value',
        'image',
    ];

    protected $casts = [ 
        'created_at' => 'datetime'
    ];


    public static function getTotalVendido()
    {
        return DB::select(
            "SELECT sum(v.quantity_sold * p.price) as total_vendido from vendas
            as v join produtos as p
            on p.id = v.produto_id
            where DAY(v.created_at) = DAY(CURRENT_DATE())")[0]->total_vendido??0;
    }
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }


    
}
