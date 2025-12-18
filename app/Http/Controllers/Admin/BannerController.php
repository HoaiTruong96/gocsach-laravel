<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    // Hiển thị danh sách Banner
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->get();
        // Bạn cần tạo view admin.banners.index nếu muốn quản lý danh sách
        return view('admin.banners.index', compact('banners'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('admin.banners.create');
    }

    // Lưu banner mới
    public function store(Request $request)
    {
        // Validate - yêu cầu ảnh hoặc URL ảnh
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'order' => 'integer|min:0',
        ]);

        // Kiểm tra phải có ít nhất 1 nguồn ảnh
        if (!$request->hasFile('image') && !$request->filled('image_url')) {
            return back()->withInput()->with('error', 'Vui lòng tải ảnh từ máy hoặc nhập URL ảnh!');
        }

        $data = $request->except(['image', 'image_url']);
        $data['is_active'] = $request->has('is_active');

        // Xử lý ảnh: ưu tiên file upload, nếu không có thì dùng URL
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Thêm Banner thành công!');
    }

    // Hiển thị form chỉnh sửa (Quan trọng cho nút Sửa ngoài trang chủ)
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        // Bạn cần tạo view: resources/views/admin/banners/edit.blade.php
        return view('admin.banners.edit', compact('banner'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'order' => 'integer|min:0',
        ]);

        $data = $request->except(['image', 'image_url']);
        $data['is_active'] = $request->has('is_active'); // Checkbox

        // Xử lý ảnh: ưu tiên file upload, sau đó URL ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu nó nằm trong storage
            if ($banner->image && !Str::startsWith($banner->image, 'http')) {
                Storage::delete('public/' . $banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        } elseif ($request->filled('image_url')) {
            // Xóa ảnh cũ nếu nó nằm trong storage
            if ($banner->image && !Str::startsWith($banner->image, 'http')) {
                Storage::delete('public/' . $banner->image);
            }
            $data['image'] = $request->input('image_url');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật Banner thành công!');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image && !Str::startsWith($banner->image, 'http')) {
            Storage::delete('public/' . $banner->image);
        }
        $banner->delete();

        return redirect()->back()->with('success', 'Đã xóa Banner.');
    }
}