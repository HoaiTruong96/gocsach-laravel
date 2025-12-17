<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use App\Notifications\PostApprovedNotification;
use Illuminate\Support\Facades\Auth; // <--- Thêm dòng này để check ID Admin

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Post::whereNotNull('book_id')
            ->with(['user', 'book'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('reviews'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $oldStatus = $post->status; // Lưu trạng thái cũ để so sánh

        // 1. Cập nhật trạng thái
        // (status được gửi từ form: 'published' hoặc 'rejected')
        $post->update(['status' => $request->status]);

        // 2. Ghi log hoạt động
        $actionType = $request->status === 'published' ? 'approve' : 'reject';
        $bookTitle = $post->book->title ?? 'Sách đã xóa';
        $actionDesc = $request->status === 'published'
            ? "Duyệt bài review: {$bookTitle}"
            : "Từ chối bài review: {$bookTitle}";

        AdminActivityLog::log(
            $actionType,
            $actionDesc,
            Post::class,
            $post->id,
            ['status' => $oldStatus],
            ['status' => $request->status]
        );

        // 3. [QUAN TRỌNG] Gửi thông báo NẾU trạng thái chuyển sang 'published'
        // Và đảm bảo không gửi lại nếu nó đã published từ trước (tránh spam khi nhấn cập nhật nhiều lần)
        if ($request->status === 'published' && $oldStatus !== 'published') {
            
            // Kiểm tra: Có tác giả & Admin không tự duyệt bài của mình
            if ($post->user && $post->user->id !== Auth::id()) {
                try {
                    $post->user->notify(new PostApprovedNotification($post));
                } catch (\Exception $e) {
                    // Nếu lỗi gửi mail/noti thì log lại, không làm crash trang web
                    \Log::error("Lỗi gửi thông báo duyệt bài: " . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Cập nhật trạng thái bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::with('book')->findOrFail($id);
        $postData = $post->toArray();
        $bookTitle = $post->book->title ?? 'Sách đã xóa';

        $post->delete();

        // Ghi log
        AdminActivityLog::log(
            'delete',
            "Xóa bài review về sách: {$bookTitle}",
            Post::class,
            $id,
            $postData,
            null
        );

        return back()->with('success', 'Đã xóa bài viết');
    }

    // ĐÃ XÓA HÀM approve() ĐỂ TRÁNH XUNG ĐỘT LOGIC
}