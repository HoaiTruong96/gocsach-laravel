<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        $totalBooks = $user->bookshelves()->count();
        $totalReviews = $user->posts()->whereNotNull('book_id')->count();

        $query = $user->bookshelves()->with('book')->orderByPivot('created_at', 'desc');

        if ($request->has('status') && $request->get('status') != 'all') {
            $status = $request->get('status');
            if ($status == 'favorites') $query->wherePivot('status', 'wishlist');
            else $query->wherePivot('status', $status);
        }

        $myBooks = $query->take(12)->get();

        return view('profile', [
            'user' => $user,
            'myBooks' => $myBooks,
            'totalBooks' => $totalBooks,
            'totalReviews' => $totalReviews,
            'currentFilter' => $request->get('status', 'all')
        ]);
    }
}
