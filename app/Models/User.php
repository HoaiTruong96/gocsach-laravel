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

    // --- CÁC MỐI QUAN HỆ (RELATIONSHIPS) ---

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function posts() { return $this->hasMany(Post::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function likes() { return $this->hasMany(Like::class); }
    
    public function bookshelves() {
        return $this->belongsToMany(Book::class, 'bookshelves', 'user_id', 'book_id')
            ->withPivot('status')->withTimestamps();
    }

    public function contributedBooks() { return $this->hasMany(Book::class, 'created_by_user_id'); }

    // Follows
    public function followings() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }
    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }
    public function isFollowing($userId) {
        return $this->followings()->where('following_id', $userId)->exists();
    }
    public function isAdmin() { return $this->role === 'admin'; }

    // --- [PHẦN QUAN TRỌNG ĐÃ SỬA] ---

    // 1. Quan hệ với Badge
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at', 'expires_at')
            ->withTimestamps();
    }

    // Những người TÔI đang theo dõi (Following)
    public function followings()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at', 'expires_at')
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                      ->orWhereNull('expires_at');
            })
            ->withTimestamps();
    }

    // Những người đang theo dõi TÔI (Followers)
    public function followers()
    {
        // Database dùng: current_count, is_completed (Không phải current_progress, status)
        return $this->belongsToMany(Challenge::class, 'user_challenges')
            ->withPivot('current_count', 'is_completed', 'completed_at')
            ->withTimestamps();
    }

    // Hàm kiểm tra: Tôi có đang follow người này không?
    public function isFollowing($userId)
    {
        // Lấy tất cả thử thách user đã tham gia
        $joinedChallenges = $this->challenges; 

        foreach ($joinedChallenges as $challenge) {
            
            // A. Đếm số lượng bài review HỢP LỆ
            // - Status phải là 'published'
            // - Ngày tạo phải nằm trong khoảng thời gian của thử thách
            $validPostsCount = $this->posts()
                ->where('status', 'published')
                ->where('created_at', '>=', $challenge->start_date)
                // Lấy đến cuối ngày kết thúc (23:59:59)
                ->where('created_at', '<=', Carbon::parse($challenge->end_date)->endOfDay())
                ->count();

            // B. Kiểm tra đã hoàn thành chưa
            $isCompleted = $validPostsCount >= $challenge->target_count;
            
            // C. Chuẩn bị dữ liệu cập nhật
            $pivotData = [
                'current_count' => $validPostsCount, // Cập nhật con số thực tế
                'is_completed'  => $isCompleted
            ];

            // Nếu hoàn thành mà chưa có ngày ghi nhận thì thêm vào
            if ($isCompleted && !$challenge->pivot->completed_at) {
                $pivotData['completed_at'] = now();
            }

            // D. Lưu vào bảng user_challenges
            $this->challenges()->updateExistingPivot($challenge->id, $pivotData);

            // E. Trao Huy Hiệu (Badge) nếu xong
            if ($isCompleted) {
                // Kiểm tra để tránh trao trùng lặp
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