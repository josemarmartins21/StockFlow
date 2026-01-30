<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Produto extends Model
{
    protected $fillable = [
        'name', 
        "price",
        "categoria_id", 
        "shpping", 
        "image",
        'user_id',
    ];
    
    protected $guarded = [];
    
    

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
