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
     * Lấy số người đang online (active trong 5 phút gần đây) - đếm theo IP
     */
    public static function getOnlineCount(): int
    {
        return self::where('last_activity', '>=', now()->subMinutes(5))
            ->distinct('ip_address')
            ->count('ip_address');
    }

    /**
     * Cập nhật hoặc tạo mới visit - dựa theo IP
     */
    public static function trackVisit(string $ip): void
    {
        // Tạo session_id unique dựa theo IP để tránh lỗi duplicate key
        $sessionId = md5($ip);

        self::updateOrCreate(
            ['ip_address' => $ip],
            ['session_id' => $sessionId, 'last_activity' => now()]
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
