<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produto extends Model
{
    protected $fillable = ['name', "price","categoria_id", "shpping"];

    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class);
    }
}
