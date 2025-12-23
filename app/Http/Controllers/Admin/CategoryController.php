<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('books')->latest()->paginate(10);
        // Lưu ý: Bạn cần tạo view 'admin.categories.index' sau này
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);

        AdminActivityLog::log(
            'create',
            "Thêm danh mục mới: {$category->name}",
            Category::class,
            $category->id,
            null,
            $category->toArray()
        );

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'category' => $category]);
        }
        return back()->with('success', 'Thêm danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $categoryData = $category->toArray();
        $categoryName = $category->name;

        $category->delete();

        AdminActivityLog::log(
            'delete',
            "Xóa danh mục: {$categoryName}",
            Category::class,
            $categoryData['id'],
            $categoryData,
            null
        );

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Đã xóa danh mục!');
    }
}
