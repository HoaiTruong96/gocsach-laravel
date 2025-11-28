<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\Bookshelf;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "Khởi tạo dữ liệu mẫu:\n";

        // 1. Tạo người dùng (Admin và User)
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $users = User::factory(50)->create();
        echo "Tạo thành công Users!\n";

        // 2. Tạo danh mục
        Category::factory(20)->create();

        // 3. Tạo tác giả
        Author::factory(20)->create();
        echo "Tạo thành công Categories và Authors!\n";

        // 4. Tạo sách
        $books = Book::factory(50)->create();
        echo "Tạo thành công Books!\n";

        // 5. Tạo đánh giá
        $reviews = Review::factory(200)->create();
        echo "Tạo thành công Reviews!\n";

        // 6. Tạo theo dõi
        // Ghi chú: Mỗi người dùng sẽ theo dõi 3 người dùng ngẫu nhiên khác
        foreach ($users as $user) {
            // Ghi chú: Ngẫu nhiên 3 người dùng khác
            $randomUsers = $users->where('id', '!=', $user->id)->random(3);
            foreach ($randomUsers as $targetUser) {
                // Ghi chú: Kiểm tra unique để tránh lỗi
                if (!Follow::where('follower_id', $user->id)->where('following_id', $targetUser->id)->exists()) {
                    Follow::create([
                        'follower_id' => $user->id,
                        'following_id' => $targetUser->id,
                    ]);
                }
            }
        }
        echo "Tạo thành công Follows!\n";

        // 7. Tạo bình luận và lượt thích
        foreach ($reviews as $review) {
            // Ghi chú: Ngẫu nhiên 0-3 bình luận cho mỗi đánh giá
            $randomCommentCount = rand(0, 3);
            for ($i = 0; $i < $randomCommentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'review_id' => $review->id,
                    'content' => fake()->sentence(),
                ]);
            }

            // Ghi chú: Ngẫu nhiên 0-20 lượt thích cho mỗi đánh giá, không thể vượt quá số người dùng hiện có
            $randomLikeCount = rand(0, min(20, $users->count() - 1));
            // Ghi chú: Ngẫu nhiên người dùng thích đánh giá
            $randomLikers = $users->random($randomLikeCount);

            foreach ($randomLikers as $liker) {
                // Ghi chú: Kiểm tra unique trước khi tạo lượt thích
                if (!Like::where('user_id', $liker->id)->where('review_id', $review->id)->exists()) {
                    Like::create([
                        'user_id' => $liker->id,
                        'review_id' => $review->id,
                    ]);
                }
            }
        }
        echo "Tạo thành công Comments và Likes!\n";

        // 8. Tạo điểm trung bình cho sách
        echo "Đang tính toán lại điểm trung bình cho từng cuốn sách...\n";
        foreach ($books as $book) {
            // Ghi chú: Tính điểm trung bình
            $avg = $book->reviews()->avg('rating');

            // Cập nhật vào sách (nếu không có review thì để 0)
            $book->update([
                'avg_rating' => $avg ?? 0,
            ]);
        }
        echo "Tạo thành công Avg Ratings!\n";

        // 9. Tạo giá sách cho mỗi người dùng
        // Ghi chú: Mỗi người dùng sẽ có từ 0 đến 10 cuốn sách trên kệ
        foreach ($users as $user) {
            $randomBooks = $books->random(rand(0, 10));

            foreach ($randomBooks as $book) {
                // Ghi chú: Kiểm tra unique trước khi thêm vào kệ
                if (!Bookshelf::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
                    Bookshelf::create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'status' => fake()->randomElement(['wishlist', 'reading', 'completed']),
                        // Ghi chú: 50% có ngày bắt đầu
                        'started_at' => fake()->boolean(50) ? fake()->date() : null,
                        // QUAN TRỌNG: ĐỂ TẠM THỜI
                        'finished_at' => null,
                    ]);
                }
            }
        }
        echo "Tạo thành công Bookshelves!\n";

        echo "Tạo thành công toàn bộ dữ liệu mẫu!\n";
    }
}
