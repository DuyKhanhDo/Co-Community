# Comovie - Hệ thống quản lý phim trực tuyến

Comovie là một hệ thống quản lý phim trực tuyến được xây dựng bằng PHP theo mô hình MVC. Hệ thống cho phép người dùng xem phim, đánh giá và bình luận, đồng thời cung cấp giao diện quản trị cho admin.

## Tính năng chính

- Xem danh sách phim
- Tìm kiếm phim theo tên, thể loại
- Đánh giá và bình luận phim
- Quản lý người dùng
- Quản lý phim và thể loại
- Thống kê và báo cáo

## Yêu cầu hệ thống

- PHP >= 7.4
- MongoDB >= 4.4
- Composer
- Web server (Apache/Nginx)

## Cài đặt

1. Clone repository:

```bash
git clone https://github.com/your-username/comovie.git
cd comovie
```

2. Cài đặt dependencies:

```bash
composer install
```

3. Cấu hình database:

- Copy file `.env.example` thành `.env`
- Cập nhật thông tin kết nối MongoDB trong file `.env`

4. Khởi động web server:

```bash
php -S localhost:8000
```

5. Truy cập website:

```
http://localhost:8000
```

## Cấu trúc thư mục

```
comovie/
├── admin/             # Thư mục quản trị
│   ├── config/       # Cấu hình
│   ├── controllers/  # Controllers
│   ├── models/       # Models
│   └── views/        # Views
├── assets/           # CSS, JS, images
├── includes/         # Các file PHP được include
├── uploads/          # Thư mục upload file
└── vendor/           # Dependencies
```

## Đóng góp

Mọi đóng góp đều được chào đón. Vui lòng:

1. Fork repository
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit các thay đổi (`git commit -m 'Add some AmazingFeature'`)
4. Push lên branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## License

Dự án được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.
