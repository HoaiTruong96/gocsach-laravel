<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Bookshelf;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
// Tránh sự kiện model khi seeding
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "BẮT ĐẦU KHỞI TẠO DỮ LIỆU\n";

        // 1. Tạo tài khoản Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'admin',
            'bio' => 'Quản trị viên hệ thống Góc Sách',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        echo "- Đã tạo tài khoản Admin!\n";

        // 2. Tạo tài khoản User mẫu
        User::create([
            'name' => 'Tester',
            'email' => 'tester@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'user',
            'bio' => 'Tester hệ thống Góc Sách',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        echo "- Đã tạo tài khoản User mẫu!\n";

        // 3. Tạo danh mục sách cố định
        $categories = [
            'Văn Học Nước Ngoài',
            'Văn Học Việt Nam',
            'Tâm Lý - Kỹ Năng Sống',
            'Sức Khỏe',
            'Thiếu Nhi',
            'Tiểu Thuyết',
            'Khoa Học Viễn Tưởng',
            'Ngoại Ngữ',
            'Nấu Ăn',
            'Kinh Dị',
            'Trinh Thám',
            'Công Nghệ Thông Tin',
            'Kinh Tế',
            'Kinh Doanh',
            'Lịch Sử',
            'Chính Trị - Xã Hội',
            'Nghệ Thuật',
            'Du Lịch',
            'Người Thành Công Đọc Gì',
            'Gia Đình - Mối Quan Hệ',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Các đầu sách thuộc thể loại $name",
            ]);
        }
        echo "- Đã tạo xong " . count($categories) . " danh mục sách.\n";

        // Tạo ngẫu nhiên danh mục sách
        // Category::factory()->count(20)->create();

        echo "Hoàn tất!\n";
    }
}
