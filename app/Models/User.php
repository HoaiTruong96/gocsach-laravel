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

    // --- CÁC MỐI QUAN HỆ (RELATIONSHIPS) ---

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

    // Những người TÔI đang theo dõi (Following)
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    // Những người đang theo dõi TÔI (Followers)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    // Hàm kiểm tra: Tôi có đang follow người này không?
    public function isFollowing($userId)
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }

    public function isAdmin()
    {
        return $this->role === 'admin'; 
    }

    // --- [PHẦN MỚI THÊM ĐỂ SỬA LỖI] ---

    // 1. Quan hệ với Badge (Huy hiệu)
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at', 'expires_at')
            ->withTimestamps();
    }

    // 2. [QUAN TRỌNG] Lấy danh hiệu còn hiệu lực (Hàm gây lỗi ActiveBadges)
    public function activeBadges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at', 'expires_at')
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                      ->orWhereNull('expires_at');
            })
            ->withTimestamps();
    }

    // 3. Quan hệ với Thử thách (Chuẩn bị cho tính năng Challenges)
    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'user_challenges')
            ->withPivot('current_progress', 'status', 'joined_at', 'completed_at')
            ->withTimestamps();
    }
}