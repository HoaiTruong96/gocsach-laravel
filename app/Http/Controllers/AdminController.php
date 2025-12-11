<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // THÔNG SỐ & BIỂU ĐỒ
        $totalReviews = Post::whereNotNull('book_id')->count();
        $totalViews = Post::sum('view_count') + Book::sum('view_count');
        $pendingReviews = Post::where('status', 'pending')->whereNotNull('book_id')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Biểu đồ xử lý (12 tháng gần đây)
        $labels = [];
        $dataReviews = [];
        $dataViews = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = "Th " . $month->month;
            $dataReviews[] = Post::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->whereNotNull('book_id')->count();
            $dataViews[] = User::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->count();
        }

        // Bảng xử lý
        $tableData = [];
        foreach (array_reverse($labels) as $index => $label) {
            $realIndex = 11 - $index;
            $tableData[] = [
                'month' => $label . '/' . Carbon::now()->subMonths($index)->year,
                'reviews' => $dataReviews[$realIndex],
                'users' => $dataViews[$realIndex]
            ];
        }

        // Lọc theo tháng
        // Ghi chú: Mặc định lấy tháng hiện tại nếu không chọn
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Lấy danh sách Review trong tháng đã chọn
        $monthlyReviewsList = Post::with(['user', 'book'])
            ->whereNotNull('book_id')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->latest()
            ->paginate(5, ['*'], 'reviews_page');

        // Lấy danh sách User đăng ký trong tháng đã chọn
        $monthlyUsersList = User::where('role', 'user')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->latest()
            ->paginate(5, ['*'], 'users_page');

        return view('admin.dashboard', compact(
            'totalReviews',
            'totalViews',
            'pendingReviews',
            'totalUsers',
            'labels',
            'dataReviews',
            'dataViews',
            'tableData',
            'selectedMonth',
            'selectedYear',
            'monthlyReviewsList',
            'monthlyUsersList'
        ));
    }

    /**
     * AJAX endpoint for loading reviews list
     */
    public function dashboardReviews(Request $request)
    {
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        $monthlyReviewsList = Post::with(['user', 'book'])
            ->whereNotNull('book_id')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->latest()
            ->paginate(5);

        return view('admin.partials.dashboard-reviews', compact(
            'monthlyReviewsList',
            'selectedMonth',
            'selectedYear'
        ));
    }

    /**
     * AJAX endpoint for loading users list
     */
    public function dashboardUsers(Request $request)
    {
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        $monthlyUsersList = User::where('role', 'user')
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $selectedMonth)
            ->latest()
            ->paginate(5);

        return view('admin.partials.dashboard-users', compact(
            'monthlyUsersList',
            'selectedMonth',
            'selectedYear'
        ));
    }
}
