<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy bài viết là review sách (có book_id), sắp xếp: Chờ duyệt lên đầu
        $reviews = Post::whereNotNull('book_id')
            ->with(['user', 'book'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(10);

        // Bạn cần tạo view 'admin.reviews.index'
        return view('admin.posts.index', compact('reviews'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $oldStatus = $post->status;

        // 1. Chuẩn bị dữ liệu cập nhật
        $updateData = ['status' => $request->status];

        // Nếu chuyển sang 'published' thì cập nhật ngày đăng (nếu chưa có)
        if ($request->status == 'published' && is_null($post->published_at)) {
            $updateData['published_at'] = now();
        }

        // 2. Thực hiện cập nhật
        $post->update($updateData);

        // 3. [QUAN TRỌNG] Cập nhật tiến độ Thử Thách cho User
        // Chỉ chạy khi bài viết được DUYỆT (published)
        if ($request->status == 'published' && $post->user) {
            $post->user->updateChallengeProgress();
        }

        // 4. Ghi log hoạt động Admin
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

        return back()->with('success', 'Cập nhật trạng thái và tính điểm thử thách thành công!');
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
}