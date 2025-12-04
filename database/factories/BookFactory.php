<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        // Giữ lại danh sách sách hay của bạn
        $titleBook = [
            'Dế Mèn Phiêu Lưu Ký',
            'Đất Rừng Phương Nam',
            'Số Đỏ',
            'Tắt Đèn',
            'Chí Phèo',
            'Lão Hạc',
            'Vợ Nhặt',
            'Rừng Xà Nu',
            'Mắt Biếc',
            'Tôi Thấy Hoa Vàng Trên Cỏ Xanh',
            'Cho Tôi Xin Một Vé Đi Tuổi Thơ',
            'Cánh Đồng Bất Tận',
            'Nỗi Buồn Chiến Tranh',
            'Tuổi Thơ Dữ Dội',
            'Nhà Giả Kim',
            'Hoàng Tử Bé',
            'Ông Già Và Biển Cả',
            'Rừng Na Uy',
            'Trăm Năm Cô Đơn',
            'Giết Con Chim Nhại',
            'Bắt Trẻ Đồng Xanh',
            'Không Gia Đình',
            'Những Người Khốn Khổ',
            'Thép Đã Tôi Thế Đấy',
            'Tiếng Chim Hót Trong Bụi Mận Gai',
            'Đắc Nhân Tâm',
            'Hạt Giống Tâm Hồn',
            'Cà Phê Cùng Tony',
            'Trên Đường Băng',
            'Nhà Lãnh Đạo Không Chức Danh',
            'Đời Thay Đổi Khi Chúng Ta Thay Đổi',
            'Tư Duy Nhanh Và Chậm',
            'Lược Sử Loài Người',
            'Sapiens',
            'Clean Code',
            'Design Patterns'
        ];

        $publishers = ['NXB Trẻ', 'NXB Kim Đồng', 'Nhã Nam', 'Skybooks', 'Alpha Books', 'NXB Văn Học'];

        $title = fake()->unique()->randomElement($titleBook) ?? fake()->sentence(3);

        return [
            // Người đóng góp sách (Random 1 user hoặc null)
            'created_by_user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),

            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(4),

            // THAY ĐỔI: Tên tác giả dạng text (không cần bảng Author nữa)
            'author_name' => fake()->name(),

            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),

            'publisher' => fake()->randomElement($publishers),
            'published_year' => fake()->year(),
            'description' => fake()->paragraph(3),
            'cover_image' => 'https://placehold.co/400x600?text=' . urlencode(Str::limit($title, 20)),

            'view_count' => fake()->numberBetween(100, 10000),
            'avg_rating' => fake()->randomFloat(1, 3, 5), // Fake trước điểm số
            'is_approved' => true, // Mặc định sách mẫu thì duyệt luôn
        ];
    }
}
