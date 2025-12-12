<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['note', 'produto_id', 'quantity_sold', 'user_id'];
}
