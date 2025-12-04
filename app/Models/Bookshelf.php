<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookshelf extends Model
{
    // Ghi chú: Chưa có Factory cho Bookshelf
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'date',
        'finished_at' => 'date',
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
}
