<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Danh sách thể loại sách
        $categories = [
            'Sách Giáo Khoa',
            'Văn Học Nước Ngoài',
            'Văn Học Việt Nam',
            'Tâm Lý - Kỹ Năng Sống',
            'Sức Khỏe',
            'Thiếu Nhi',
            'Truyện Tranh',
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
            'Chính Trị',
            'Xã Hội',
            'Tôn Giáo - Tâm Linh',
        ];

        // Dùng unique() để tránh trùng lặp tên thể loại
        $name = fake()->unique()->randomElement($categories);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Tuyển tập những cuốn sách hay nhất về chủ đề ' . $name,
        ];
    }
}
