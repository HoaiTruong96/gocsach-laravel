<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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
            'Đồi Gió Hú',
            'Kiêu Hãnh Và Định Kiến',
            'Harry Potter và Hòn Đá Phù Thủy',
            'Chúa Tể Những Chiếc Nhẫn',
            'Sherlock Holmes',
            'Án Mạng Trên Chuyến Tàu Tốc Hành Phương Đông',
            'Sự Im Lặng Của Bầy Cừu',
            'Mật Mã Da Vinci',
            'Kỳ Án Ánh Trăng',
            'Đề Thi Đẫm Máu',
            'Phía Sau Nghi Can X',
            'Bạch Dạ Hành',
            'Hỏa Ngục',
            'Cô Gái Có Hình Xăm Rồng',
            'Đắc Nhân Tâm',
            'Nhà Lãnh Đạo Không Chức Danh',
            'Cà Phê Cùng Tony',
            'Tuổi Trẻ Đáng Giá Bao Nhiêu',
            'Đời Thay Đổi Khi Chúng Ta Thay Đổi',
            'Dạy Con Làm Giàu',
            'Chiến Tranh Tiền Tệ',
            'Tỷ Phú Bán Giày',
            'Khởi Nghiệp Tinh Gọn',
            'Nhà Đầu Tư Thông Minh',
            'Code Dạo Ký Sự',
            'Clean Code',
            'Lập Trình Viên Pragmatic',
            'Tớ Học Lập Trình',
            'Design Patterns',
            'Nhập Môn Trí Tuệ Nhân Tạo'
        ];

        $publishers = [
            'NXB Trẻ',
            'NXB Kim Đồng',
            'NXB Hội Nhà Văn',
            'NXB Lao Động',
            'NXB Phụ Nữ',
            'NXB Thanh Niên',
            'NXB Văn Học',
            'NXB Dân Trí',
            'NXB Thế Giới',
            'NXB Tổng hợp TP.HCM',
            'NXB Chính Trị Quốc Gia Sự Thật',
            'Nhã Nam',
            'Đinh Tị Books',
            'Đông A',
            'Skybooks',
            'Alpha Books',
            'Thái Hà Books'
        ];

        // Tạo tiêu đề sách ngẫu nhiên: xóa dấu chấm ở cuối câu
        $title = fake()->unique()->randomElement($titleBook);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            // Lấy ngẫu nhiên id từ bảng categories, nếu không có thì tạo mới
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            // Lấy ngẫu nhiên id từ bảng authors
            'author_id' => Author::query()->inRandomOrder()->value('id') ?? Author::factory(),
            'publisher' => fake()->randomElement($publishers),
            'published_year' => fake()->year(),
            'description' => fake()->paragraph(3),
            'cover_image' => 'https://placehold.co/400x600?text=' . urlencode(Str::limit($title, 20)),
            'view_count' => fake()->numberBetween(100, 5000),
            'avg_rating' => 0,
        ];
    }
}
