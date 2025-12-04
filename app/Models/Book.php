<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by_user_id',
        'title',
        'slug',
        'author_name',
        'category_id',
        'publisher',
        'published_year',
        'description',
        'cover_image',
        'view_count',
        'avg_rating',
        'is_approved',
    ];

    protected $casts = [
        'avg_rating' => 'float',
        'is_approved' => 'boolean',
    ];

    // Quan hệ
    public function category()
    {
        // Một cuốn sách thuộc về 1 thể loại
        return $this->belongsTo(Category::class, 'category_id');
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
}
