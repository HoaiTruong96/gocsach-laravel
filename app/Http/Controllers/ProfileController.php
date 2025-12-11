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
        // LOGIC XÁC ĐỊNH USER CẦN XEM
        if ($id) {
            // Nếu có ID trên URL (VD: /profile/5) -> Xem người khác
            $user = User::find($id);
            if (!$user) return redirect('/')->with('error', 'Người dùng không tồn tại!');
        } else {
            // Nếu không có ID -> Xem chính mình
            $user = Auth::user();
            if (!$user) return redirect()->route('login');
        }

        // 1. Thống kê
        $totalBooks = $user->bookshelves()->count();
        $totalReviews = $user->posts()->count();
        $totalFollowing = $user->followings()->count();
        $totalFollowers = $user->followers()->count();

        // 2. Lấy danh sách bài Review (CÓ PHÂN QUYỀN)
        // [SỬA ĐOẠN NÀY] Khởi tạo query
        $reviewsQuery = $user->posts()
                        ->with('book') // Lấy kèm thông tin sách
                        ->withCount(['likes', 'comments'])
                        ->orderBy('created_at', 'desc');

        // Kiểm tra quyền xem:
        // Nếu người xem KHÔNG PHẢI là chủ profile (Khách) -> Chỉ lấy bài đã duyệt (published)
        if (Auth::id() != $user->id) {
            $reviewsQuery->where('status', 'published');
        }
        // Nếu là chủ nhà (Auth::id() == $user->id) -> Không lọc, xem hết (pending, published, rejected)

        $reviews = $reviewsQuery->paginate(10);

        // 3. Lấy sách trong tủ
        $query = $user->bookshelves()->orderByPivot('created_at', 'desc');

        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status == 'favorites') $query->wherePivot('status', 'wishlist');
            elseif ($status == 'reading') $query->wherePivot('status', 'reading');
            elseif ($status == 'completed') $query->wherePivot('status', 'completed');
        }

        $myBooks = $query->take(12)->get();

        return view('profile', [
            'user' => $user,
            'reviews' => $reviews,
            'myBooks' => $myBooks,
            'totalBooks' => $totalBooks,
            'totalReviews' => $totalReviews,
            'totalFollowing' => $totalFollowing,
            'totalFollowers' => $totalFollowers,
            'currentFilter' => $request->get('status', 'all')
        ]);
    }
}