<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass; // Thư viện dùng để tạo object giả

class ProfileController extends Controller
{
    public function index()
    {
        // 1. TẠO DỮ LIỆU GIẢ CHO USER (Thay vì lấy từ Database)
        $user = new stdClass();
        $user->name = "Nguyễn Quốc Kha";
        $user->email = "kha.frontend@hutech.edu.vn";
        $user->avatar = "https://ui-avatars.com/api/?name=Quoc+Kha&background=0D8ABC&color=fff";

        // 2. TẠO DỮ LIỆU GIẢ CHO TỦ SÁCH
        // (Tự tạo 3 cuốn sách để test giao diện)
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

        // Gom sách vào một mảng
        $myBooks = [$book1, $book2, $book3];

        // 3. TRẢ VỀ VIEW KÈM DỮ LIỆU
        return view('profile', [
            'user' => $user,
            'myBooks' => $myBooks
        ]);
    }
}