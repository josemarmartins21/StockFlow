<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }


    
}
