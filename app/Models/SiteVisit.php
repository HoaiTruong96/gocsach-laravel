<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = ['session_id', 'ip_address', 'last_activity'];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    /**
     * Lấy số người đang online (active trong 5 phút gần đây)
     */
    public static function getOnlineCount(): int
    {
        return self::where('last_activity', '>=', now()->subMinutes(5))->count();
    }

    /**
     * Cập nhật hoặc tạo mới visit
     */
    public static function trackVisit(string $sessionId, ?string $ip = null): void
    {
        self::updateOrCreate(
            ['session_id' => $sessionId],
            ['ip_address' => $ip, 'last_activity' => now()]
        );
    }

    /**
     * Xóa visits cũ (quá 10 phút)
     */
    public static function cleanOldVisits(): int
    {
        return self::where('last_activity', '<', now()->subMinutes(10))->delete();
    }
}
