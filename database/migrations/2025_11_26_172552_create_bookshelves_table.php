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
        Schema::create('bookshelves', function (Blueprint $table) {
            // Mã định danh kệ sách
            $table->id();
            // Mã định danh người dùng (Khóa ngoại)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Mã định danh sách (Khóa ngoại)
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            // Trạng thái kệ sách (Mong muốn đọc, Đang đọc, Đã hoàn thành)
            $table->enum('status', ['wishlist', 'reading', 'completed'])->default('wishlist');
            // Ngày bắt đầu
            $table->date('started_at')->nullable();
            // Ngày hoàn thành
            $table->date('finished_at')->nullable();
            $table->timestamps();
            // CỰC KÌ QUAN TRỌNG: Tránh trường hợp 1 user có thể thêm cùng 1 cuốn sách vào kệ nhiều lần
            // Dòng này tạo ràng buộc duy nhất giữa người dùng và cuốn sách đã chọn
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookshelves');
    }
};
