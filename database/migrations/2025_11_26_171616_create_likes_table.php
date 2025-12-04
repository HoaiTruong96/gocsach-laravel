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
        Schema::create('likes', function (Blueprint $table) {
            // Mã định danh thích
            $table->id();
            // Mã định danh người dùng (Khóa ngoại)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Mã định danh đánh giá (Khóa ngoại)
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            // CỰC KÌ QUAN TRỌNG:
            // Ghi chú: Tránh trường hợp 1 user có thể thích 1 bài review nhiều lần
            // Dòng này tạo ràng buộc duy nhất giữa người dùng và bài review
            $table->unique(['user_id', 'review_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
