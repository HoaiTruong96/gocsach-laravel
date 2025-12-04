<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'author_id',
        'publisher',
        'published_year',
        'description',
        'cover_image',
        'view_count',
        'avg_rating',
    ];

    protected $casts = [
        'avg_rating' => 'float',
    ];

    // Quan hệ

   public function author()
    {
        // Một cuốn sách thuộc về 1 tác giả
        return $this->belongsTo(Author::class, 'author_id');
    }
    public function category()
    {
        // Một cuốn sách thuộc về 1 thể loại
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Sách nằm trong kệ sách của người dùng
    public function inBookshelves()
    {
        return $this->hasMany(Bookshelf::class);
    }

}
