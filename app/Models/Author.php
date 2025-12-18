<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // Tắt timestamps vì bảng không có created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'bio',
        'birth_year',
        'death_year',
        'nationality',
    ];

    /**
     * Lấy tất cả sách của tác giả này
     * Liên kết qua trường author_name trong bảng books
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'author_name', 'name');
    }

    /**
     * Đếm số lượng sách của tác giả
     */
    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }

    /**
     * Tạo slug tự động từ tên
     */
    public static function generateSlug($name)
    {
        return \Str::slug($name);
    }
}
