<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;

class ProfileController extends Controller
{
    public function index(Request $request, $id = null)
    {
        // 1. XÁC ĐỊNH USER VÀ LẤY KÈM HUY HIỆU (BADGES)
        if ($id) {
            // [QUAN TRỌNG] Thêm with('activeBadges') để lấy danh hiệu còn hạn
            $user = User::with('activeBadges')->find($id);
            
            if (!$user) return redirect()->route('home')->with('error', 'Người dùng không tồn tại!');
        } else {
            $user = Auth::user();
            if (!$user) return redirect()->route('login');
            
            // Nếu là chính mình, nạp thêm quan hệ badges vào
            $user->load('activeBadges');
        }

        // 2. THỐNG KÊ
        $totalBooks = $user->bookshelves()->count();
        $totalReviews = $user->posts()->count();
        $totalFollowing = $user->followings()->count();
        $totalFollowers = $user->followers()->count();

        // 3. Lấy danh sách bài Review (CÓ PHÂN QUYỀN)
        $reviewsQuery = $user->posts()
                        ->with('book') // Lấy kèm thông tin sách
                        ->withCount(['likes', 'comments'])
                        ->orderBy('created_at', 'desc');

        // Kiểm tra quyền xem:
        // Nếu người xem KHÔNG PHẢI là chủ profile (Khách) -> Chỉ lấy bài đã duyệt (published)
        if (Auth::id() != $user->id) {
            $reviewsQuery->where('status', 'published');
        }
        // Nếu là chủ nhà -> Xem hết (pending, published, rejected)

        $reviews = $reviewsQuery->paginate(10);

        // 4. Lấy sách trong tủ
        $query = $user->bookshelves()->orderByPivot('created_at', 'desc');

        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status == 'favorites') $query->wherePivot('status', 'wishlist');
            elseif ($status == 'reading') $query->wherePivot('status', 'reading');
            elseif ($status == 'completed') $query->wherePivot('status', 'completed');
        }

        $myBooks = $query->take(12)->get();

        // 5. Lấy danh sách sách đề xuất (do user tạo)
        // Chỉ hiển thị cho chính chủ profile
        $suggestedBooks = collect();
        if (Auth::id() == $user->id) {
            $suggestedBooks = Book::where('created_by_user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(12)
                                ->get();
        }

        return view('profile', [
            'user' => $user,
            'reviews' => $reviews,
            'myBooks' => $myBooks,
            'suggestedBooks' => $suggestedBooks,
            'totalBooks' => $totalBooks,
            'totalReviews' => $totalReviews,
            'totalFollowing' => $totalFollowing,
            'totalFollowers' => $totalFollowers,
        ]);
    }
}