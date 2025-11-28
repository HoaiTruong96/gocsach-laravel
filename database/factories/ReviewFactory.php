<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lấy ngẫu nhiên một cuốn sách, nếu không có thì tạo mới
        $book = Book::query()->inRandomOrder()->first() ?? Book::factory()->create();
        return [
            // Lấy ngẫu nhiên id từ bảng users, nếu không có thì tạo mới
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'book_id' => $book->id,
            // Ngẫu nhiên số điểm đánh giá từ 1 đến 5
            'rating' => fake()->randomFloat(1, 1, 5),
            'content_text' => fake()->paragraph(2),
            // Test tỷ lệ duyệt (70% approved)
            'is_approved' => fake()->boolean(70),
            // Review được tạo sau khi sách được xuất bản
            'created_at' => fake()->dateTimeBetween($book->published_year . '-01-01', 'now'),
        ];
    }
}
