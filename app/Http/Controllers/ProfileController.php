<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Thêm dòng này để xử lý file
use stdClass;

class ProfileController extends Controller
{
    public function index()
    {
        // 1. LẤY THÔNG TIN NGƯỜI DÙNG TỪ DATABASE
        $user = Auth::user();

        // 2. TẠO DỮ LIỆU GIẢ CHO TỦ SÁCH (Giữ nguyên như code của bạn)
        $book1 = new stdClass();
        $book1->title = "Đắc Nhân Tâm";
        $book1->author = "Dale Carnegie";
        $book1->image_url = "https://images-na.ssl-images-amazon.com/images/I/51pX7aKTmAL._SX307_BO1,204,203,200_.jpg";
        $book1->category = "Kỹ năng";

        $book2 = new stdClass();
        $book2->title = "Nhà Giả Kim";
        $book2->author = "Paulo Coelho";
        $book2->image_url = "https://images-na.ssl-images-amazon.com/images/I/51Z0nLAfLmL._SX324_BO1,204,203,200_.jpg";
        $book2->category = "Văn học";

        $book3 = new stdClass();
        $book3->title = "Tuổi Trẻ Đáng Giá Bao Nhiêu";
        $book3->author = "Rosie Nguyễn";
        $book3->image_url = "https://salt.tikicdn.com/cache/w1200/ts/product/c6/eb/aa/3f4e15779c6563456c1d052601710972.jpg";
        $book3->category = "Đời sống";

        $myBooks = [$book1, $book2, $book3];

        // 3. TRẢ VỀ VIEW
        return view('profile', [
            'user' => $user,
            'myBooks' => $myBooks
        ]);
    }

    // --- THÊM MỚI: Hàm xử lý cập nhật thông tin và Avatar ---
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // Avatar không bắt buộc
        ]);

        // Xử lý Upload Avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Lưu avatar mới
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Cập nhật tên
        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Cập nhật hồ sơ thành công!');
    }
}
