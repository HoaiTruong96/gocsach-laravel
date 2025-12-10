<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount('posts')->latest()->paginate(15);
        // Bạn cần tạo view 'admin.users.index'
        return view('admin.users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') return back()->with('error', 'Không thể xóa Admin');
        $user->delete();
        return back()->with('success', 'Đã xóa thành viên');
    }
}
