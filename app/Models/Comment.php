<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'post_id', // Giữ nguyên theo database
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: Comment thuộc về 1 Review
    public function review()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}