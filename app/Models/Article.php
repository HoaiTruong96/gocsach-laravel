<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'tag',
        'excerpt',
        'content',
        'is_featured',
        'user_id'
    ];

    // Quan hệ: Bài viết thuộc về 1 người dùng (Admin/Tác giả)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}