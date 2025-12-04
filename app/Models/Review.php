<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'content_text', // <--- Sửa 'content' thành 'content_text' cho đúng với Database
        'is_approved'   // Thêm cột này nếu Database có
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'float',
    ];

    // Quan hệ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Một bài đánh giá có nhiều bình luận và lượt thích
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
