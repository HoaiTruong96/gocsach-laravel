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
        Schema::create('users', function (Blueprint $table) {
            // Mã định danh người dùng
            $table->id();
            // Tên người dùng
            $table->string('name');
            // Email người dùng
            $table->string('email')->unique();
            // Xác thực email
            $table->timestamp('email_verified_at')->nullable();
            // Mật khẩu người dùng
            $table->string('password');
            // Ảnh đại diện người dùng
            $table->string('avatar')->nullable();
            // Tiểu sử người dùng
            $table->text('bio')->nullable();
            // Vai trò người dùng: 0 = User, 1 = Admin
            $table->string('role')->default('user');
            // Trạng thái kích hoạt người dùng (Admin có thể vô hiệu hóa tài khoản)
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
