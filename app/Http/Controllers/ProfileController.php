<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // [QUAN TRỌNG] Gọi thư viện Auth
use stdClass;

class ProfileController extends Controller
{
    public function index()
    {
        // 1. LẤY THÔNG TIN NGƯỜI DÙNG TỪ DATABASE (Đã sửa)
        // Hàm Auth::user() sẽ lấy ra toàn bộ thông tin của người đang đăng nhập
        $user = Auth::user();

        // 2. TẠO DỮ LIỆU GIẢ CHO TỦ SÁCH (Giữ nguyên để test giao diện)
        // Phần này sau này bạn Thông làm xong DB sách thì mình sẽ query thật sau
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

        // 3. TRẢ VỀ VIEW KÈM DỮ LIỆU THẬT CỦA USER
        return view('profile', [
            'user' => $user,      // Biến $user này bây giờ chứa thông tin thật từ DB
            'myBooks' => $myBooks // Biến này vẫn là giả lập
        ]);
    }
}
