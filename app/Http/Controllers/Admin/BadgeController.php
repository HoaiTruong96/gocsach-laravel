<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BadgeController extends Controller
{
    /**
     * Hiển thị danh sách badges
     */
    public function index()
    {
        return redirect()->route('admin.game.index');
    }

    /**
     * Xem chi tiết badge - redirect về trang chính
     */
    public function show(Badge $badge)
    {
        return redirect()->route('admin.game.index');
    }

    /**
     * Form tạo badge mới
     */
    public function create()
    {
        return redirect()->route('admin.game.index');
    }

    /**
     * Lưu badge mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('badges', 'name')->whereNull('deleted_at')],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập tên danh hiệu.',
            'name.unique' => 'Danh hiệu này đã tồn tại. Vui lòng chọn tên khác.',
            'name.max' => 'Tên danh hiệu không được quá 255 ký tự.',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        $validated['is_active'] = $request->has('is_active');

        $badge = Badge::create($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Tạo danh hiệu mới: ' . $badge->name,
            'model_type' => Badge::class,
            'model_id' => $badge->id,
            'new_values' => $badge->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tạo danh hiệu thành công!',
                'badge' => $badge
            ]);
        }

        return redirect()->route('admin.game.index')
            ->with('success', 'Tạo danh hiệu thành công!');
    }

    /**
     * Form chỉnh sửa badge
     */
    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    /**
     * Cập nhật badge
     */
    public function update(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('badges', 'name')->ignore($badge->id)->whereNull('deleted_at')],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $oldValues = $badge->toArray();
        $validated['is_active'] = $request->has('is_active');

        $badge->update($validated);

        // Log activity
        AdminActivityLog::create([
            'admin_id' => auth()->id(),
            'action' => 'update',
            'description' => 'Cập nhật danh hiệu: ' . $badge->name,
            'model_type' => Badge::class,
            'model_id' => $badge->id,
            'old_values' => $oldValues,
            'new_values' => $badge->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.game.index')
            ->with('success', 'Cập nhật danh hiệu thành công!');
    }

    /**
     * Xóa badge
     */
    public function destroy(Request $request, Badge $badge)
    {
        $badgeName = $badge->name;
        $oldValues = $badge->toArray();

        $badge->delete();

        // Log activity
        AdminActivityLog::create([
            'admin_id' => auth()->id(),
            'action' => 'delete',
            'description' => 'Xóa danh hiệu: ' . $badgeName,
            'model_type' => Badge::class,
            'model_id' => $oldValues['id'],
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa danh hiệu thành công!'
            ]);
        }

        return redirect()->route('admin.game.index')
            ->with('success', 'Xóa danh hiệu thành công!');
    }
}
