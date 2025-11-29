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
        Schema::create('authors', function (Blueprint $table) {
            // Mã định danh tác giả
            $table->id();
            // Tên tác giả
            $table->string('name');
            // Đường dẫn cho tác giả
            $table->string('slug')->unique();
            // Ảnh đại diện tác giả
            $table->string('avatar')->nullable();
            // Tiểu sử tác giả
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
