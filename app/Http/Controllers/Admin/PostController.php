<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use App\Notifications\NewPostFromFollowingNotification;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::whereNotNull('book_id')
            ->with(['user', 'book']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reviews = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 WHEN status = 'pending_delete' THEN 2 ELSE 3 END")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Return partial view for AJAX requests
        if ($request->ajax()) {
            return view('admin.posts.index', compact('reviews'));
        }

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

            // 4. [FIX BUG] Cập nhật tiến độ Thử Thách cho người viết bài
            // Khi bài viết được duyệt, tính lại số bài review hợp lệ của user
            if ($post->user) {
                try {
                    $post->user->updateChallengeProgress();
                } catch (\Exception $e) {
                    \Log::error("Lỗi cập nhật tiến độ thử thách: " . $e->getMessage());
                }
            }

            // 5. [MỚI] Gửi thông báo đến tất cả FOLLOWERS của tác giả
            if ($post->user) {
                try {
                    $followers = $post->user->followers;
                    foreach ($followers as $follower) {
                        // Không gửi cho admin đang duyệt
                        if ($follower->id !== Auth::id()) {
                            $follower->notify(new NewPostFromFollowingNotification($post, $post->user));
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("Lỗi gửi thông báo đến followers: " . $e->getMessage());
                }
            }
        }

        // 5. Gửi thông báo NẾU trạng thái chuyển sang 'rejected'
        if ($request->status === 'rejected' && $oldStatus !== 'rejected') {
            if ($post->user && $post->user->id !== Auth::id()) {
                try {
                    // Xử lý lý do từ chối: nếu chọn "other" thì lấy từ custom_reason
                    $reason = $request->rejection_reason;
                    if ($reason === 'other' && $request->custom_reason) {
                        $reason = $request->custom_reason;
                    }

                    $post->user->notify(new PostRejectedNotification($post, $reason));
                } catch (\Exception $e) {
                    \Log::error("Lỗi gửi thông báo từ chối bài: " . $e->getMessage());
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

        return back()->with('success', 'Đã xóa bài viết!');
    }

    /**
     * Duyệt yêu cầu xóa bài viết từ user
     */
    public function approveDelete($id)
    {
        $post = Post::with('book')->findOrFail($id);

        // Chỉ cho phép duyệt xóa bài có status = pending_delete
        if ($post->status !== 'pending_delete') {
            return back()->with('error', 'Bài viết này không ở trạng thái chờ xóa!');
        }

        $postData = $post->toArray();
        $bookTitle = $post->book->title ?? 'Sách đã xóa';
        $userName = $post->user->name ?? 'Người dùng';

        $post->delete();

        // Ghi log
        AdminActivityLog::log(
            'delete',
            "Duyệt xóa bài review của {$userName} về sách: {$bookTitle}",
            Post::class,
            $id,
            $postData,
            null
        );

        return back()->with('success', 'Đã duyệt xóa bài viết!');
    }

    /**
     * Từ chối yêu cầu xóa, đưa bài về trạng thái published
     */
    public function rejectDelete($id)
    {
        $post = Post::with('book')->findOrFail($id);

        if ($post->status !== 'pending_delete') {
            return back()->with('error', 'Bài viết này không ở trạng thái chờ xóa!');
        }

        $oldStatus = $post->status;
        $post->update(['status' => 'published']);

        $bookTitle = $post->book->title ?? 'Sách đã xóa';

        // Ghi log
        AdminActivityLog::log(
            'reject',
            "Từ chối xóa bài review về sách: {$bookTitle}",
            Post::class,
            $post->id,
            ['status' => $oldStatus],
            ['status' => 'published']
        );

        return back()->with('success', 'Đã từ chối yêu cầu xóa, bài viết được giữ lại!');
    }
}