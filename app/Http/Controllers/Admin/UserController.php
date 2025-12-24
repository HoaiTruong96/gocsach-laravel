<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::withCount('posts');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->appends($request->query());

        // AJAX request - return JSON with rendered HTML
        if ($request->ajax() || $request->has('ajax')) {
            $paginationHtml = '';
            if ($users->hasPages()) {
                $paginationHtml = '<div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700">'
                    . $users->links('vendor.pagination.admin')->toHtml()
                    . '</div>';
            }
            return response()->json([
                'table' => view('admin.users._table', compact('users'))->render(),
                'pagination' => $paginationHtml
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin')
            return back()->with('error', 'Không thể xóa Admin');

        $userData = $user->toArray();
        $userName = $user->name;

        $user->delete();

        // Ghi log
        AdminActivityLog::log(
            'delete',
            "Xóa thành viên: {$userName} ({$userData['email']})",
            User::class,
            $userData['id'],
            $userData,
            null
        );

        return back()->with('success', 'Đã xóa thành viên!');
    }
}
