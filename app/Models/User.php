<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'secret_code',
        'avatar',
        'bio',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Quan hệ
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookshelves()
    {
        return $this->belongsToMany(Book::class, 'bookshelves', 'user_id', 'book_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function contributedBooks()
    {
        return $this->hasMany(Book::class, 'created_by_user_id');
    }

    // Quan hệ giữa người dùng và người theo dõi
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    // 5. Những người đang theo dõi tôi (Followers)
    // Bảng trung gian 'follows', khóa ngoại 'following_id' (là tôi), khóa liên kết 'follower_id' (người kia)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    // 6. Hàm kiểm tra: Tôi có đang follow người có ID này không?
    public function isFollowing($userId)
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }
    public function isAdmin()
    {
        // Kiểm tra xem user có phải admin không
        // Ví dụ: nếu cột role là 'admin' hoặc cột type là 1
        return $this->role === 'admin';
    }
}
