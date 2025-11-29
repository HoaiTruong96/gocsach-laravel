<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Ghi chú: Chưa có Factory cho Comment
    use HasFactory;

    protected $fillable = [
        'user_id',
        'review_id',
        'content'
    ];

    // Quan hệ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()

    {
        return $this->belongsTo(Review::class);
    }
}
