<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = ['name', 'status', 'image', 'desc', 'user_id'];

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
