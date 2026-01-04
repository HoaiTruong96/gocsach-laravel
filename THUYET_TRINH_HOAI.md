# 🎤 BÀI THUYẾT TRÌNH CỦA HOÀI
## Nhóm trưởng - Project Manager

> **Dự án**: Góc Sách - Website Review Sách Cộng Đồng  
> **Vai trò**: PM (Project Manager)  
> **Thời lượng**: 5-7 phút (Mở đầu) + 3-5 phút (Kết thúc)

---

# 📌 PHẦN 1: MỞ ĐẦU (5-7 phút)

---

## 🎯 Slide 1: Giới thiệu đề tài

### Nội dung slide:
- **Tên dự án**: Góc Sách
- **Tagline**: "Nơi kết nối những tâm hồn yêu sách"
- **Loại**: Website Review Sách Cộng Đồng
- Screenshot trang chủ

### Kịch bản nói:
> "Xin chào thầy/cô và các bạn. Hôm nay nhóm chúng em sẽ trình bày đề tài **'Góc Sách - Website Review Sách Cộng Đồng'**.
>
> Đây là một nền tảng web cho phép người dùng tìm kiếm sách, đọc và viết review, đánh giá sách, cũng như tương tác với cộng đồng những người yêu sách."

---

## 🎯 Slide 2: Mục tiêu dự án

### Nội dung slide:

| # | Mục tiêu | Mô tả |
|---|----------|-------|
| 1 | **Nền tảng review** | Xây dựng nền tảng chia sẻ review sách dành cho cộng đồng Việt Nam |
| 2 | **Tìm kiếm sách** | Giúp người đọc dễ dàng tìm kiếm và lựa chọn sách phù hợp |
| 3 | **Tương tác xã hội** | Tạo không gian like, comment, follow giữa các thành viên |
| 4 | **Gamification** | Huy hiệu, thử thách để khuyến khích đóng góp |

### Kịch bản nói:
> "Mục tiêu chính của dự án là tạo ra một cộng đồng sôi động, nơi mọi người có thể chia sẻ cảm nhận về sách, giúp nhau tìm được những cuốn sách hay, và cùng nhau lan tỏa văn hóa đọc Việt Nam."

---

## 🎯 Slide 3: Đối tượng người dùng

### Nội dung slide:

| Đối tượng | Nhu cầu |
|-----------|---------|
| 👤 **Người yêu sách** | Tìm sách hay, đọc review trước khi mua |
| ✍️ **Người muốn chia sẻ** | Viết review, đánh giá sách đã đọc |
| 👥 **Cộng đồng đọc sách** | Kết nối, follow, tương tác với người cùng sở thích |
| 🛡️ **Admin/Quản trị** | Quản lý nội dung, duyệt sách, xử lý báo cáo |

### Kịch bản nói:
> "Đối tượng sử dụng bao gồm những người yêu sách muốn tìm sách hay, những độc giả muốn chia sẻ cảm nhận, cộng đồng muốn kết nối với những người cùng sở thích, và admin để quản lý toàn bộ hệ thống."

---

## 🎯 Slide 4: Kiến trúc hệ thống MVC

### Nội dung slide (sơ đồ):

```
         ┌─────────────┐
         │   CLIENT    │
         │  (Browser)  │
         └──────┬──────┘
                │ HTTP Request
                ▼
         ┌─────────────┐
         │   ROUTES    │
         │  (web.php)  │
         └──────┬──────┘
                │
                ▼
        ┌──────────────┐
        │  CONTROLLERS │
        │ (Xử lý logic)│
        └──────┬───────┘
               │
       ┌───────┴───────┐
       ▼               ▼
┌────────────┐  ┌────────────┐
│   MODELS   │  │   VIEWS    │
│  (Database)│  │  (Blade)   │
└─────┬──────┘  └────────────┘
      │
      ▼
┌────────────┐
│   MySQL    │
│ (20+ bảng) │
└────────────┘
```

### Kịch bản nói:
> "Hệ thống được xây dựng theo kiến trúc MVC của Laravel.
>
> Khi user truy cập, request đi qua **Route** để định tuyến đến **Controller** phù hợp.
>
> Controller xử lý logic, lấy dữ liệu từ **Model** tức database MySQL, sau đó render **View** bằng Blade template trả về cho người dùng."

---

## 🎯 Slide 5: Cấu trúc Routing - 4 nhóm

### Nội dung slide:

| Nhóm | Middleware | Mô tả | Ví dụ |
|------|------------|-------|-------|
| 🌐 **PUBLIC** | (không có) | Ai cũng xem được | `/`, `/chi-tiet/{slug}` |
| 👤 **GUEST** | `guest` | Chỉ người chưa đăng nhập | `/login`, `/register` |
| 🔐 **AUTH** | `auth`, `verified` | Đã đăng nhập + xác thực | `/profile`, `/reviews/viet-bai` |
| 🛡️ **ADMIN** | `auth`, `admin` | Chỉ admin | `/admin/dashboard` |

### Kịch bản nói:
> "Chúng em chia routes thành 4 nhóm rõ ràng dựa trên quyền truy cập:
>
> - **PUBLIC**: ai cũng xem được như trang chủ, chi tiết sách
> - **GUEST**: dành cho người chưa đăng nhập như form login, register
> - **AUTH**: dành cho thành viên đã xác thực email như viết review, profile
> - **ADMIN**: chỉ admin mới vào được như dashboard, quản lý sách"

**(Tùy chọn demo)**: Mở file `routes/web.php` chỉ 4 nhóm được comment rõ ràng.

---

## 🎯 Slide 6: Công nghệ sử dụng

### Nội dung slide:

| Công nghệ | Vai trò |
|-----------|---------|
| **Laravel 11** | PHP Framework chính (MVC, ORM, Auth) |
| **MySQL 8** | Cơ sở dữ liệu quan hệ |
| **Blade** | Template Engine |
| **Tailwind CSS** | CSS Framework |
| **JavaScript (ES6+)** | AJAX, DOM manipulation |
| **Font Awesome** | Icon library |
| **Gemini AI** | Chatbot trợ lý thông minh |

### Kịch bản nói:
> "Về công nghệ, chúng em sử dụng Laravel phiên bản 11 làm framework chính, MySQL 8 lưu trữ dữ liệu, Blade template để render giao diện, Tailwind CSS để styling, và JavaScript cho các tương tác AJAX.
>
> Đặc biệt, chúng em còn tích hợp Gemini AI để làm chatbot trợ lý thông minh gợi ý sách cho người dùng."

---

## 🎯 Slide 7: Giới thiệu thành viên

### Nội dung slide:

| Thành viên | Phần demo |
|------------|-----------|
| **Thông** | Database & Admin Panel |
| **Tú** | Frontend (Trang chủ, Danh sách, Chi tiết) |
| **Đạo** | Backend (Auth, Search, Upload) |
| **Kha** | Profile, Review, Testing |

### Kịch bản nói:
> "Và bây giờ, em xin giới thiệu các thành viên trong nhóm sẽ demo từng phần:
>
> - **Thông** sẽ trình bày về Database và trang Admin
> - **Tú** sẽ demo giao diện Frontend
> - **Đạo** sẽ demo phần Backend như Auth, Search, Upload
> - **Kha** sẽ demo Profile, Review và kết quả Testing
>
> **Xin mời Thông bắt đầu phần tiếp theo.**"

---

# 📌 PHẦN 2: KẾT THÚC (3-5 phút)

*(Sau khi tất cả thành viên đã demo xong)*

---

## 🎯 Slide 8: Tổng kết chức năng

### Nội dung slide:

| Module | Chức năng | Trạng thái |
|--------|-----------|------------|
| **Xác thực** | Đăng ký, Login, OTP, Quên MK | ✅ |
| **Sách** | Danh sách, Chi tiết, Tìm kiếm | ✅ |
| **Review** | Viết, Sửa, Like, Comment | ✅ |
| **Profile** | Xem, Sửa, Avatar, Follow | ✅ |
| **Admin** | Dashboard, CRUD, Logs | ✅ |
| **Gamification** | Badges, Challenges, Frames | ✅ |
| **Extras** | Chatbot AI, Themes, Newsletter | ✅ |

### Kịch bản nói:
> "Như vậy, nhóm chúng em đã hoàn thành đầy đủ các chức năng chính của một website review sách cộng đồng:
>
> Từ hệ thống xác thực với OTP, quản lý sách và review, hệ thống tương tác xã hội, trang admin quản trị, cho đến các tính năng gamification như huy hiệu, thử thách, và chatbot AI hỗ trợ người dùng."

---

## 🎯 Slide 9: Thống kê dự án

### Nội dung slide:

| Metric | Số lượng |
|--------|----------|
| **Routes** | 80+ |
| **Controllers** | 25+ |
| **Models** | 20+ |
| **Migrations** | 41 |
| **Views (Blade)** | 60+ |
| **Lines of Code** | 15,000+ |

### Kịch bản nói:
> "Về mặt kỹ thuật, dự án có hơn 80 routes, 25 controllers, 20 models, 41 migrations, 60 file views, và ước tính khoảng 15.000 dòng code."

---

## 🎯 Slide 10: Hướng phát triển

### Nội dung slide:

| Giai đoạn | Tính năng |
|-----------|-----------|
| **Ngắn hạn** | App mobile, Push notification |
| **Trung hạn** | AI gợi ý sách, Ebook reader |
| **Dài hạn** | Marketplace sách cũ |

### Kịch bản nói:
> "Trong tương lai, chúng em dự định phát triển thêm ứng dụng mobile, tích hợp AI để gợi ý sách cá nhân hóa, và có thể mở rộng thành một marketplace để trao đổi sách cũ giữa các thành viên."

---

## 🎯 Slide 11: Khó khăn & Bài học

### Nội dung slide:

| Khó khăn | Giải pháp |
|----------|-----------|
| Deploy hosting chia sẻ | Config .htaccess, symlinks |
| Responsive đa thiết bị | Tailwind CSS breakpoints |
| AJAX & realtime | Polling + session |
| Làm việc nhóm | Git workflow, PR review |

### Kịch bản nói:
> "Trong quá trình làm dự án, chúng em cũng gặp một số khó khăn như deploy lên shared hosting, làm responsive cho nhiều thiết bị, xử lý AJAX và quản lý code khi làm việc nhóm. Tuy nhiên, đây đều là những bài học quý giá giúp chúng em phát triển kỹ năng."

---

## 🎯 Slide 12: Demo website

### Nội dung slide:

🌐 **URL Demo**: `https://tronghoai.id.vn`

*(Show trang chủ nếu còn thời gian)*

---

## 🎯 Slide 13: Cảm ơn & Q&A

### Nội dung slide:

# 🙏 Cảm ơn thầy/cô và các bạn đã lắng nghe!

**Xin mời đặt câu hỏi**

### Kịch bản nói:
> "Đó là toàn bộ bài thuyết trình của nhóm chúng em về dự án Góc Sách.
>
> Xin cảm ơn thầy/cô và các bạn đã lắng nghe.
>
> Nếu có câu hỏi nào, xin mời thầy/cô và các bạn đặt câu hỏi. Chúng em sẵn sàng giải đáp."

---

# 💡 CÂU HỎI THƯỜNG GẶP

### Q1: "Tại sao chọn Laravel thay vì Node.js?"
> **Trả lời**: Laravel có cộng đồng lớn, dễ học, và hosting PHP rất phổ biến, chi phí thấp. Ngoài ra, Laravel có sẵn nhiều tính năng như Auth, ORM, Blade giúp phát triển nhanh.

### Q2: "Bảo mật được xử lý như thế nào?"
> **Trả lời**: Chúng em sử dụng CSRF token cho mọi form, password được hash bằng bcrypt, middleware kiểm tra quyền truy cập, và validate dữ liệu đầu vào.

### Q3: "Có thể scale hệ thống không?"
> **Trả lời**: Có thể. Khi cần scale, chúng em có thể dùng queue để xử lý job nặng, cache để tăng tốc, CDN cho static files, và database replication.

### Q4: "Tại sao dùng OTP thay vì link xác thực?"
> **Trả lời**: OTP 6 số dễ nhập hơn trên mobile, người dùng không cần chuyển qua lại giữa email và trình duyệt, trải nghiệm tốt hơn.

---

# ✅ CHECKLIST CHUẨN BỊ

- [ ] Slide PowerPoint/Canva (13 slides)
- [ ] Screenshot trang chủ, sơ đồ MVC
- [ ] File `routes/web.php` mở sẵn để demo (tùy chọn)
- [ ] Website chạy sẵn trên hosting
- [ ] Thuộc kịch bản nói từng slide
- [ ] Chuẩn bị câu trả lời cho Q&A

---

*Thời gian ước tính: Mở đầu 5-7 phút + Kết thúc 3-5 phút = Tổng 8-12 phút*
