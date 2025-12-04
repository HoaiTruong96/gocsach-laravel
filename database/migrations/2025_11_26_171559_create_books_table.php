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
        Schema::create('books', function (Blueprint $table) {
            // Mã định danh sách
            $table->id();
            // Tiêu đề sách
            $table->string('title');
            // Đường dẫn sách
            $table->string('slug')->unique();
            // Mã định danh thể loại (Khóa ngoại)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // Mã định danh tác giả (Khóa ngoại)
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            // Nhà xuất bản
            $table->string('publisher')->nullable();
            // Năm xuất bản
            $table->integer('published_year')->nullable();
            // Mô tả sách
            $table->text('description')->nullable();
            // Ảnh bìa sách
            $table->string('cover_image')->nullable();
            // Số lượt xem
            $table->integer('view_count')->default(0);
            // Đánh giá trung bình
            $table->decimal('avg_rating', 3, 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
