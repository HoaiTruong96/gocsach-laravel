<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            // Mã định danh đánh giá
            $table->id();
            // Mã định danh người dùng (Khóa ngoại)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Mã định danh sách (Khóa ngoại)
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            // Số sao đánh giá (1-5)
            $table->decimal('rating', 3, 1);
            // Nội dung đánh giá
            $table->text('content_text');
            // Trạng thái phê duyệt đánh giá
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
