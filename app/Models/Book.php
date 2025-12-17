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

    // --- CÁC MỐI QUAN HỆ ---

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    // Thêm hàm này để tránh lỗi nếu Controller có gọi $book->category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    // Quan hệ gốc với bảng posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // [QUAN TRỌNG] Thêm hàm này để sửa lỗi "Call to undefined method reviews"
    // Nó hoạt động y hệt posts(), chỉ là tên khác để Controller gọi được
    public function reviews()
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
        return $this->hasMany(Like::class, 'post_id');
    }

    public function comments()
    {
        // Tham số thứ 2 ('post_id'): Tên cột khóa ngoại trong bảng comments
        // Tham số thứ 3 ('id'): Tên cột khóa chính trong bảng books
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}