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
        $table->id();
        $table->string('title'); // Tên sách
        $table->string('author')->nullable(); // Tác giả
        $table->string('category')->nullable(); // Thể loại
        $table->date('publish_date')->nullable(); // Ngày xuất bản
        $table->string('image_url', 500)->nullable(); // Ảnh bìa
        $table->text('description')->nullable(); // Mô tả
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
