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
        Schema::create('comments', function (Blueprint $table) {
            // Mã định danh bình luận
            $table->id();
            // Mã định danh người dùng (Khóa ngoại)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Mã định danh đánh giá (Khóa ngoại)
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            // Nội dung bình luận
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
