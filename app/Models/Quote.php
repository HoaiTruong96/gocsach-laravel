<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['content', 'author', 'source', 'is_active', 'order'];
}
