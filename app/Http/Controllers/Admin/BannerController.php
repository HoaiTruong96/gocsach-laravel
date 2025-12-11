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
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);

        return redirect()->route('home')->with('success', 'Thêm banner thành công!');
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
            'order' => 'integer',
        ]);

        $data = $request->except(['image']);
        $data['is_active'] = $request->has('is_active'); // Checkbox

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu nó nằm trong storage
            if ($banner->image && !Str::startsWith($banner->image, 'http')) {
                Storage::delete('public/' . $banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('home')->with('success', 'Cập nhật banner thành công!');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image && !Str::startsWith($banner->image, 'http')) {
            Storage::delete('public/' . $banner->image);
        }
        $banner->delete();

        return redirect()->back()->with('success', 'Đã xóa banner.');
    }
}