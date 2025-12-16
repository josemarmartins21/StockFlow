<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
