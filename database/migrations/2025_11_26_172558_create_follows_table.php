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
        Schema::create('follows', function (Blueprint $table) {
            // Mã định danh theo dõi
            $table->id();
            // Mã định danh người theo dõi (Khóa ngoại)
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            // Mã định danh người được theo dõi (Khóa ngoại)
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            // CỰC KÌ QUAN TRỌNG:
            // Ghi chú: Tránh trường hợp 1 user có thể theo dõi 1 user khác nhiều lần
            // Dòng này tạo ràng buộc duy nhất giữa nguời theo dõi và người được theo dõi
            $table->unique(['follower_id', 'following_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
