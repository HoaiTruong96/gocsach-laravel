<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    // Khai báo tên bảng (dựa theo hình ảnh bạn gửi)
    protected $table = 'comment_likes'; 

    protected $fillable = [
        'user_id',
        'comment_id', //
        'is_like',    //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}