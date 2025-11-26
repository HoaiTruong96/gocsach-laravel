<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category')->nullable();
        $table->string('author')->nullable();
        $table->date('publish_date')->nullable();
        $table->string('image_url', 500)->nullable();
        $table->text('description')->nullable();
        $table->timestamps(); // Tự động tạo created_at, updated_at
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
