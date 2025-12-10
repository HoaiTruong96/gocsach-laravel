<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use App\Models\User;

class ProfileController extends Controller
{
     public function index(Request $request, $id = null)
    {
        // 1. XÁC ĐỊNH USER
        if ($id) {
            $user = User::find($id);
            if (!$user) return redirect()->route('home')->with('error', 'Người dùng không tồn tại!');
        } else {
            $user = Auth::user();
            if (!$user) return redirect()->route('login');
        }

        // 2. THỐNG KÊ
        $totalBooks = $user->bookshelves()->count();
        $totalReviews = $user->posts()->count();
        $totalFollowing = $user->followings()->count();
        $totalFollowers = $user->followers()->count();

        // 3. LẤY SÁCH YÊU THÍCH (Chỉ lấy status = 'wishlist')
        $myBooks = $user->bookshelves()
                        ->wherePivot('status', 'wishlist') // <--- CHỈ LẤY YÊU THÍCH
                        ->orderByPivot('created_at', 'desc')
                        ->take(6) // Lấy 6 cuốn thôi cho gọn
                        ->get();

        // 4. LẤY DANH SÁCH REVIEW (Giữ nguyên)
        $reviews = $user->posts()
                        ->with('book')
                        ->withCount(['likes', 'comments'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('profile', [
            'user' => $user,
            'reviews' => $reviews,
            'myBooks' => $myBooks, // Biến này giờ chỉ chứa sách yêu thích
            'totalBooks' => $totalBooks,
            'totalReviews' => $totalReviews,
            'totalFollowing' => $totalFollowing,
            'totalFollowers' => $totalFollowers,
        ]);
    }
}
