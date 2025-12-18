<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    // Hiển thị danh sách Quotes
    public function index()
    {
        $quotes = Quote::orderBy('order', 'asc')->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('admin.quotes.create');
    }

    // Lưu quote mới
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'author' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'order' => 'integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Quote::create($data);

        return redirect()->route('admin.quotes.index')->with('success', 'Thêm châm ngôn thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        return view('admin.quotes.edit', compact('quote'));
    }

    // Cập nhật quote
    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $request->validate([
            'content' => 'required|string|max:1000',
            'author' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'order' => 'integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $quote->update($data);

        return redirect()->route('admin.quotes.index')->with('success', 'Cập nhật châm ngôn thành công!');
    }

    // Xóa quote
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()->back()->with('success', 'Đã xóa châm ngôn.');
    }
}
