# TÀI LIỆU DỰ ÁN & HƯỚNG DẪN DEPLOY TIDB CLOUD + RENDER

---

## PHẦN 1: TỔNG QUAN HỆ THỐNG & TECH STACK

- **Tên dự án:** Hệ thống Quản lý và Đặt Tour Du Lịch (Wanderlust Travel System).
- **Backend:** Laravel 9 (PHP 8.1).
- **Frontend:** Laravel Blade, Tailwind CSS, Font Awesome, JavaScript.
- **Database:** MySQL 8.0 / TiDB Cloud Serverless (tương thích giao thức MySQL).
- **Web Server & Container:** Docker, Apache 2.4, `mod_rewrite`.
- **Hosting:** Render Web Service (Docker Runtime).

---

## PHẦN 2: CẤU TRÚC THƯ MỤC & GIẢI THÍCH SOURCE CODE

```
he_thong_du_lich/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                  # Controller quản trị
│   │   │   │   ├── AdminController.php         # Thống kê doanh thu, đơn hàng, view
│   │   │   │   ├── AttrController.php          # Thuộc tính tour (tiện ích, dịch vụ)
│   │   │   │   ├── BannerController.php        # Banner quảng cáo trang chủ
│   │   │   │   ├── BlogsController.php         # Bài viết tin tức, cẩm nang
│   │   │   │   ├── CategoryController.php      # Danh mục tour (trong nước, quốc tế)
│   │   │   │   ├── ChatmessageController.php   # Hỗ trợ trực tuyến admin - khách
│   │   │   │   ├── OrderController.php         # Đơn đặt tour, duyệt / hủy
│   │   │   │   ├── PaymentController.php       # Quản lý giao dịch thanh toán
│   │   │   │   ├── TourController.php          # CRUD Tour, tải ảnh, giá, lịch trình
│   │   │   │   ├── TourScheduleController.php  # Lịch khởi hành, số chỗ còn lại
│   │   │   │   ├── UsersController.php         # Quản trị tài khoản, phân quyền
│   │   │   │   ├── UserVoucherController.php   # Cấp phát voucher cho người dùng
│   │   │   │   └── VoucherController.php       # Quản lý mã giảm giá toàn sàn
│   │   │   └── User/                   # Controller phía khách hàng
│   │   │       ├── CartController.php          # Giỏ hàng đặt tour
│   │   │       ├── HomeController.php          # Trang chủ, tour hot, banner, view count
│   │   │       ├── LoginController.php         # Đăng nhập, đăng ký, đăng xuất
│   │   │       └── TourDetailController.php    # Chi tiết tour, lịch trình, đặt tour
│   │   └── Middleware/
│   │       ├── CheckAdmin.php                  # Chặn truy cập trái phép vào /admin/*
│   │       └── CheckUser.php                   # Kiểm tra phiên đăng nhập của khách
│   └── Models/                                 # Eloquent ORM Models
│       ├── Tour.php                            # Tour du lịch: giá, điểm đi/đến, trạng thái
│       ├── Category.php                        # Danh mục tour (1-N với Tour)
│       ├── TourSchedule.php                    # Lịch khởi hành, ngày đi/về, số chỗ
│       ├── Order.php                           # Hóa đơn đặt tour, trạng thái đơn
│       ├── Payment.php                         # Cổng thanh toán, mã giao dịch
│       ├── User.php                            # Tài khoản (admin / user)
│       ├── Voucher.php & UserVoucher.php       # Mã giảm giá, hạn dùng
│       ├── Review.php                          # Đánh giá rating sao, bình luận
│       ├── ChatMessage.php & ChatSession.php   # Tin nhắn chatbox trực tiếp
│       └── View.php & Statistic.php            # Thống kê lượt xem hệ thống
├── config/
│   ├── database.php            # Cấu hình kết nối MySQL / TiDB (bật SSL CA cert)
│   ├── logging.php             # Kênh log mặc định stderr cho Render Console
│   └── app.php                 # Cấu hình APP_KEY, timezone
├── database/
│   ├── migrations/             # Schema tạo bảng hệ thống
│   └── seeders/DatabaseSeeder.php # Tạo admin mặc định: voc@gmail.com / c
├── routes/web.php              # Định tuyến toàn bộ web app
├── Dockerfile                  # Đóng gói PHP 8.1 Apache + pdo_mysql
└── entrypoint.sh               # Phân quyền storage, auto key, auto migrate
```


---

## PHẦN 3: GIẢI THÍCH LUỒNG HOẠT ĐỘNG CHÍNH

1. **Khách hàng (User Workflow):**
   - Truy cập `/`: `HomeController@index` tải banner, danh mục, tour hot, tự động ghi nhận lượt truy cập vào bảng `views`.
   - Xem chi tiết tour `/tour-detail/{id}`: `TourDetailController@index` tải lịch trình, album ảnh, tiện ích và đánh giá.
   - Đặt tour: Chọn lịch khởi hành (`TourSchedule`), áp dụng voucher giảm giá (`Voucher`), tạo đơn (`Order`) và thanh toán (`Payment`).

2. **Quản trị viên (Admin Workflow):**
   - Đăng nhập tại `/login-admin`: `AdminController@login` xác thực thông qua middleware `CheckAdmin`.
   - Bảng điều khiển `/admin`: Thống kê doanh thu theo tháng, đơn mới cần duyệt, lượt xem.
   - Quản lý Tour: Thêm mới tour, upload album ảnh, tạo lịch trình ngày 1, ngày 2, gán tiện ích đi kèm.

---

## PHẦN 4: HƯỚNG DẪN SETUP DATABASE TRÊN TIDB CLOUD

TiDB Cloud là hệ quản trị cơ sở dữ liệu phân tán tương thích MySQL, gói Serverless miễn phí vĩnh viễn.

### Bước 1: Tạo cụm Database TiDB
1. Truy cập `https://tidbcloud.com` và đăng nhập (Google/GitHub).
2. Nhấn **Create Cluster** -> Chọn **Serverless** (Free $0/month).
3. Chọn vùng gần: `Singapore (ap-southeast-1)` hoặc `Tokyo (ap-northeast-1)`.
4. Đặt tên cụm (ví dụ: `tour-system-db`) -> Nhấn **Create**.

### Bước 2: Lấy thông tin kết nối
1. Trong trang tổng quan của cụm vừa tạo, nhấn nút **Connect**.
2. Chọn loại kết nối: **General** hoặc **MySQL CLI**.
3. Lưu lại các giá trị:
   - **Host:** Dạng `gateway01.ap-southeast-1.prod.aws.tidbcloud.com`
   - **Port:** `4000`
   - **User:** Dạng `xxxxxx.root`
   - **Password:** Mật khẩu đã tạo (nhấn Reset Password nếu chưa lưu).
   - **Database:** Mặc định là `test`.
4. TiDB Serverless bắt buộc kết nối có mã hóa TLS/SSL. Trong `Dockerfile` và `config/database.php` của dự án đã cấu hình sẵn đường dẫn chứng chỉ mặc định của Linux: `/etc/ssl/certs/ca-certificates.crt`.

---

## PHẦN 5: HƯỚNG DẪN DEPLOY CODE LÊN RENDER

### Bước 1: Đẩy mã nguồn lên GitHub
Đảm bảo toàn bộ mã nguồn của dự án (kèm file `Dockerfile` và `entrypoint.sh`) đã được commit và push lên nhánh `main` trên GitHub.

```bash
git add .
git commit -m "Update deployment configs"
git push origin main
```

### Bước 2: Tạo Web Service trên Render
1. Truy cập `https://dashboard.render.com` và đăng nhập.
2. Nhấn nút **New +** ở góc phải trên -> Chọn **Web Service**.
3. Chọn mục **Build and deploy from a Git repository** -> Nhấn **Next**.
4. Kết nối tài khoản GitHub và chọn repo `he_thong_du_lich` (hoặc dán URL repository vào ô Public Git repository).

### Bước 3: Cấu hình Web Service
- **Name:** `dulichvoc` (hoặc tên bạn muốn đặt).
- **Region:** `Singapore (Southeast Asia)`.
- **Branch:** `main`.
- **Runtime:** Chọn **Docker**.
- **Instance Type:** Chọn **Free**.

### Bước 4: Thêm Biến môi trường (Environment Variables)
Chuyển xuống mục **Environment Variables** (hoặc tab **Environment**), thêm đầy đủ các cặp Key - Value sau:

| Tên biến (Key) | Giá trị mẫu (Value) | Giải thích |
|---|---|---|
| `APP_NAME` | `Wanderlust` | Tên website |
| `APP_ENV` | `production` | Môi trường production |
| `APP_KEY` | `base64:ExgKJMumzPMTtopt5L+LQ+nEbKNgFDQIefMw/l+Zc0g=` | Khóa bảo mật Laravel |
| `APP_DEBUG` | `true` | Hiển thị chi tiết lỗi (đổi thành `false` sau khi chạy ổn định) |
| `APP_URL` | `https://dulichvoc.onrender.com` | URL chính thức của Render |
| `LOG_CHANNEL` | `stderr` | Đẩy log ra tab Logs trên Render |
| `DB_CONNECTION` | `mysql` | Driver database |
| `DB_HOST` | `<Host_TiDB_Cloud>` | Host lấy từ bước setup TiDB Cloud |
| `DB_PORT` | `4000` | Cổng mặc định của TiDB |
| `DB_DATABASE` | `test` | Tên database trên TiDB |
| `DB_USERNAME` | `<User_TiDB_Cloud>` | Tên tài khoản TiDB |
| `DB_PASSWORD` | `<Password_TiDB_Cloud>` | Mật khẩu tài khoản TiDB |
| `MYSQL_ATTR_SSL_CA` | `/etc/ssl/certs/ca-certificates.crt` | Đường dẫn file CA cert trong Linux container |

Nhấn **Create Web Service** (hoặc **Save Changes**).


---

## PHẦN 6: CƠ CHẾ HOẠT ĐỘNG CỦA DOCKER & ENTRYPOINT

1. **Dockerfile:**
   - Cài đặt gói Debian: `ca-certificates`, `zip`, `unzip`, `git`.
   - Cài đặt PHP extensions: `pdo`, `pdo_mysql`, `zip`.
   - Cấu hình Apache `mod_rewrite` và `AllowOverride All` để điều hướng qua `.htaccess`.
   - Chạy `composer install --no-dev --optimize-autoloader`.
2. **entrypoint.sh:**
   - Tạo các thư mục cache: `storage/framework/sessions`, `storage/framework/views`, `storage/logs`.
   - Cấp quyền `chmod -R 777` và `chown -R www-data:www-data` cho `storage` và `bootstrap/cache` (chống lỗi 500 do Permission Denied).
   - Kiểm tra `APP_KEY`: nếu thiếu, script tự sinh key tạm để web không bị crash 500.
   - Tự động chạy `php artisan migrate --seed --force` tạo bảng và nạp tài khoản admin vào TiDB.
   - Khởi động Apache chạy foreground phục vụ truy cập.

---

## PHẦN 7: TÀI KHOẢN MẶC ĐỊNH & XỬ LÝ LỖI (TROUBLESHOOTING)

### 1. Tài khoản đăng nhập Admin mặc định:
- Đường dẫn: `https://<ten-render>/login-admin`
- Email: `voc@gmail.com`
- Mật khẩu: `c`

### 2. Các lỗi thường gặp và cách xử lý:
- **Lỗi HTTP 500 Server Error:**
  - Kiểm tra tab **Logs** trên Render: Kênh `LOG_CHANNEL=stderr` sẽ in trực tiếp stack trace tại đây.
  - Kiểm tra biến `APP_KEY` trong tab Environment của Render, không được để trống.
- **Lỗi `Access denied for user` hoặc `TLS is required`:**
  - TiDB Serverless yêu cầu username dạng `xxxxxx.root`.
  - Phải có biến `MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt`.
- **Lỗi 404 khi bấm vào các trang con:**
  - Do Apache chưa bật `AllowOverride All` trong cấu hình virtual host. `Dockerfile` đã được sửa để xử lý triệt để lỗi này.

