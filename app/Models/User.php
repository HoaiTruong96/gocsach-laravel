<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'secret_code', 
        'avatar', 'bio', 'role', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // =========================================================================
    // 1. CÁC MỐI QUAN HỆ CƠ BẢN
    // =========================================================================

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
            ->withPivot('status')->withTimestamps();
    }

    public function contributedBooks() 
    { 
        return $this->hasMany(Book::class, 'created_by_user_id'); 
    }

    // =========================================================================
    // 2. TÍNH NĂNG MẠNG XÃ HỘI (Follow)
    // =========================================================================

    public function followings() 
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    public function followers() 
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    // [ĐÃ SỬA] Hàm này chỉ trả về True/False xem có follow chưa
    public function isFollowing($userId) 
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }

    // =========================================================================
    // 3. HỆ THỐNG THỬ THÁCH & DANH HIỆU
    // =========================================================================

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at', 'expires_at')
            ->withTimestamps();
    }

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

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'user_challenges')
            ->withPivot('current_count', 'is_completed', 'completed_at')
            ->withTimestamps();
    }

    // --- HÀM TÍNH ĐIỂM CHUẨN XÁC ---
    public function updateChallengeProgress()
    {
        $joinedChallenges = $this->challenges; 

        foreach ($joinedChallenges as $challenge) {
            
            $startDate = Carbon::parse($challenge->start_date)->startOfDay();
            $endDate   = Carbon::parse($challenge->end_date)->endOfDay();

            $validPostsCount = $this->posts()
                ->where('status', 'published')
                ->whereBetween('created_at', [$startDate, $endDate]) 
                ->count();

            $isCompleted = $validPostsCount >= $challenge->target_count;
            
            $pivotData = [
                'current_count' => $validPostsCount,
                'is_completed'  => $isCompleted
            ];

            if ($isCompleted && !$challenge->pivot->completed_at) {
                $pivotData['completed_at'] = now();
            }

            $this->challenges()->updateExistingPivot($challenge->id, $pivotData);

            if ($isCompleted) {
                if (!$this->badges()->where('badge_id', $challenge->badge_id)->exists()) {
                    $this->badges()->attach($challenge->badge_id, [
                        'earned_at' => now()
                    ]);
                }
            }
        }
    }

    public function isAdmin() 
    { 
        return $this->role === 'admin'; 
    }
}