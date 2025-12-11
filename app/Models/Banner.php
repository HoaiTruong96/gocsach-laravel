<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'tag', 'description', 'image', 'rating', 'link', 'is_active', 'order'];
}
