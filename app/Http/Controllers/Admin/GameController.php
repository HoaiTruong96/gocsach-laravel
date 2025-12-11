<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Challenge;

class GameController extends Controller
{
    /**
     * Trang tích hợp quản lý Badges và Challenges
     */
    public function index()
    {
        $badges = Badge::withCount(['userBadges', 'challenges'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'badges_page');

        $challenges = Challenge::with('badge')
            ->withCount([
                'userChallenges',
                'userChallenges as completed_count' => function ($query) {
                    $query->where('is_completed', true);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'challenges_page');

        return view('admin.game.index', compact('badges', 'challenges'));
    }
}
