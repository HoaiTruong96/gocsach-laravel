# 📚 Góc Sách - Cộng Đồng Yêu Sách

Website cộng đồng đọc sách và review sách, được xây dựng bằng Laravel 12.

---

## 📋 Yêu Cầu Hệ Thống

| Phần mềm | Phiên bản |
|----------|-----------|
| PHP | >= 8.2 |
| Composer | >= 2.0 |
| Node.js | >= 18.0 |
| MySQL | >= 8.0 |

---

## 🚀 Cài Đặt Nhanh

### 1. Clone dự án
```bash
git clone <repository-url>
cd gocsach-laravel
```

### 2. Cài đặt dependencies
```bash
composer install
npm install
```

### 3. Cấu hình môi trường
```bash
# Copy file .env mẫu
cp .env.example .env

# Tạo application key
php artisan key:generate
```

### 4. Cấu hình Database
Mở file `.env` và cập nhật thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gocsach
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Chạy Migration & Seeder
```bash
# Tạo bảng database
php artisan migrate

# (Tùy chọn) Chạy seeder để có dữ liệu mẫu
php artisan db:seed
```

### 6. Tạo Storage Link
```bash
php artisan storage:link
```

### 7. Chạy dự án

**Cách 1: Chạy từng service riêng lẻ**
```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite (frontend)
npm run dev
```

**Cách 2: Chạy tất cả cùng lúc (khuyến nghị)**
```bash
composer dev
```

### 8. Truy cập website
- Frontend: http://127.0.0.1:8000
- Admin: http://127.0.0.1:8000/admin

---

## 🔧 Các Lệnh Artisan Thường Dùng

| Lệnh | Mô tả |
|------|-------|
| `php artisan serve` | Chạy server development |
| `php artisan migrate` | Chạy migrations |
| `php artisan migrate:fresh --seed` | Reset DB + seed data |
| `php artisan cache:clear` | Xóa cache |
| `php artisan config:clear` | Xóa config cache |
| `php artisan route:clear` | Xóa route cache |
| `php artisan view:clear` | Xóa view cache |
| `php artisan storage:link` | Link storage folder |
| `php artisan queue:work` | Chạy queue worker |

---

## 🌐 Deploy Lên Production

### 1. Cập nhật `.env`
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. Optimize cho production
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Đảm bảo permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 📁 Cấu Trúc Thư Mục Chính

```
gocsach-laravel/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent Models
│   └── ...
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Data seeders
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # CSS files
│   └── js/                   # JavaScript files
├── routes/
│   └── web.php               # Web routes
├── storage/                  # User uploads
├── public/                   # Public assets
├── .env                      # Environment config
└── composer.json             # PHP dependencies
```

---

## 👤 Tài Khoản Mặc Định (Dev)

| Vai trò | Email | Mật khẩu |
|---------|-------|----------|
| Admin | admin@gocsach.com | password |
| User | user@gocsach.com | password |

> ⚠️ Thay đổi mật khẩu ngay sau khi deploy lên production!

---

## 🛠️ Xử Lý Lỗi Thường Gặp

### Lỗi 500 - Server Error
```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

### Lỗi "Class not found"
```bash
composer dump-autoload
php artisan optimize:clear
```

### Lỗi hình ảnh không hiển thị
```bash
php artisan storage:link
```

### Lỗi permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📞 Hỗ Trợ

