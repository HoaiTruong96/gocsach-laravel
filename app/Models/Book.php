<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'author_name',
        'publisher',
        'published_year',
        'description',
        'cover_image',
        'view_count',
        'avg_rating',
        'is_approved',
        'created_by_user_id'
    ];

    protected $casts = [
        'avg_rating' => 'float',
        'is_approved' => 'boolean',
    ];

    // Quan hệ
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function bookshelves()
    {
        return $this->hasMany(Bookshelf::class);
    }
    public function likes()
    {
        // Vì bảng 'likes' của bạn dùng cột 'post_id' để lưu ID bài viết/sách
        // nên ta phải khai báo rõ khóa ngoại là 'post_id'
        return $this->hasMany(Like::class, 'post_id');
    }
    // --- PHẦN ĐÃ SỬA ---
    public function comments()
    {
        // Tham số thứ 2 ('post_id'): Tên cột khóa ngoại trong bảng comments
        // Tham số thứ 3 ('id'): Tên cột khóa chính trong bảng books
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}