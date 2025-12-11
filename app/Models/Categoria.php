<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['name', 'status', 'image', 'desc', 'user_id'];
}
