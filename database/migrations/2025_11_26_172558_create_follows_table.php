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
