<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
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
        // Duyệt bài hoặc Từ chối
        $post->update(['status' => $request->status]);
        return back()->with('success', 'Cập nhật trạng thái bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return back()->with('success', 'Đã xóa bài viết');
    }
}
