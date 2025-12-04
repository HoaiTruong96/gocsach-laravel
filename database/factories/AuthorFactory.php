<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ghi chú: Tạo tên đầy đủ
        $name = fake()->lastName() . ' ' . fake()->middleName() . ' ' . fake()->firstName();
        $bios = [
            "Tác giả $name là một trong những cây bút xuất sắc của văn học đương đại. Với giọng văn nhẹ nhàng nhưng sâu lắng, các tác phẩm của $name luôn chạm đến những góc khuất sâu kín nhất trong tâm hồn người đọc.",
            "$name nổi tiếng với tư duy logic sắc bén và phong cách kể chuyện đầy kịch tính. Những cuốn sách của $name thường dẫn dắt độc giả đi từ bất ngờ này đến bất ngờ khác, với những cái kết không thể đoán trước.",
            "Không chỉ là một tác giả, $name còn là một diễn giả truyền cảm hứng được yêu thích. Những cuốn sách của $name mang đậm tính thực tiễn, giúp hàng ngàn độc giả thay đổi tư duy và làm chủ cuộc sống.",
            "Sinh ra và lớn lên trong thời kỳ đổi mới, văn chương của $name mang đậm hơi thở của cuộc sống đời thường. $name viết về những điều giản dị bằng một trái tim đa cảm và giàu lòng trắc ẩn.",
            "$name là một nhà nghiên cứu tâm huyết với nhiều năm kinh nghiệm. Các tác phẩm của $name là sự kết hợp hoàn hảo giữa kiến thức chuyên sâu và lối diễn giải gãy gọn, dễ hiểu.",
            "Một cây bút trẻ đầy triển vọng của làng văn. $name được biết đến với phong cách viết phóng khoáng, hiện đại và không ngại thử thách với những đề tài gai góc.",
            "Tác giả $name đã dành cả cuộc đời để cống hiến cho sự nghiệp văn học. Các tác phẩm của ông/bà đã được dịch ra nhiều thứ tiếng và nhận được nhiều giải thưởng danh giá trong và ngoài nước.",
            "Chưa thiết lập tiểu sử cho tác giả này.",
        ];
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=fff',
            'bio' => fake()->randomElement($bios),
        ];
    }
}
