<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // Ghi chú: Chưa có Factory cho Follow
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'following_id'
    ];

    // Quan hệ
    // Ghi chú: Đã định nghĩa quan hệ bên User
}
