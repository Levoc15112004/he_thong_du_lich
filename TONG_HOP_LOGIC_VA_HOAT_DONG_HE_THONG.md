# TÀI LIỆU KỸ THUẬT: TỔNG HỢP LOGIC, CÁCH THỨC HOẠT ĐỘNG CÁC COMPONENT VÀ HỆ THỐNG API

**Dự án:** Hệ Thống Lữ Hành & Đặt Tour Du Lịch Toàn Quốc (Wanderlust Travel Vietnam)  
**Công nghệ:** Laravel 9 (PHP 8.1), MySQL / TiDB Cloud, Apache 2.4, Docker, Tailwind CSS, Leaflet Maps, MoMo, PayPal SDK, Gemini & Groq AI Engine.  
**Cập nhật:** Tháng 11 / 2026  

---

## PHẦN 1: TỔNG QUAN KIẾN TRÚC HỆ THỐNG (ARCHITECTURE & TECH STACK)

Dự án được xây dựng theo kiến trúc **Monolith MVC (Model - View - Controller)** mở rộng, tối ưu cho khả năng chịu tải trên nền tảng Docker & Cloud Serverless:

- **Backend Core:** Laravel 9 Framework trên nền PHP 8.1, sử dụng Eloquent ORM, Session Driver, Event & Listener, Queue/Jobs và Middleware phân quyền nghiêm ngặt.
- **Database Layer:** Cơ sở dữ liệu MySQL 8.0 tương thích hoàn toàn với TiDB Cloud Serverless (phục vụ môi trường Cloud Production không độ trễ).
- **Frontend Layer:** Laravel Blade kết hợp Tailwind CSS (Universal Dark/Light Theme System), Icon Font Awesome 6, bản đồ tương tác Leaflet.js và JavaScript ES6+.
- **AI Concierge:** Module tư vấn lữ hành tự động kết hợp Google Gemini 2.0 Flash / Groq LLM API và Rule Engine tra cứu trực tiếp Database.
- **Payment Gateways:** Tích hợp cổng thanh toán MoMo QR Code (xác thực HMAC SHA256) và PayPal REST API Client SDK quốc tế.

---

## PHẦN 2: LOGIC & CƠ CHẾ HOẠT ĐỘNG CỦA TOÀN BỘ COMPONENT FRONTEND (CLIENT)

### 1. Khung Giao Diện Chính (`resources/views/users/master.blade.php`)
- **Hệ thống Universal Dark / Light Theme:**
  - Kiểm tra `localStorage.getItem('theme')` ngay tại thẻ `<head>` trước khi render DOM. Nếu là `dark`, gắn class `dark` vào thẻ `<html>`.
  - Hệ thống biến màu CSS Token (`--color-canvas`, `--color-paper`, `--color-ink`, `--color-border`) tự động thay đổi, không gây chớp nháy (FOUC).
- **Header Navigation:**
  - Tự động nhận diện trang chủ: Tại Hero Banner thanh trong suốt (`bg-transparent`), khi người dùng cuộn trang quá 60px tự động chuyển sang nền trắng mờ (`bg-white dark:bg-slate-900 shadow-md`) và chữ tự đổi màu tương phản.
  - Tích hợp Dropdown danh mục đa cấp từ Database (`App\Models\Category`), giỏ hàng hiển thị badge số lượng realtime, nút chuyển theme và menu người dùng đã đăng nhập.
- **Widget Tư Vấn Lữ Hành (Travel Concierge Widget):**
  - Biểu tượng tai nghe tư vấn bản địa cố định góc dưới bên phải.
  - Khi mở popup, tự động kết nối API `/api/chat`, hiển thị tin nhắn chào mừng lịch sự và tự động parse các link Markdown trong câu trả lời của AI thành nút bấm dẫn thẳng tới trang chi tiết tour tương ứng.
- **Hero Banner Auto-Slide Engine:**
  - Tự động xoay tua cảnh sau mỗi 4.5 giây giữa 4 điểm đến biểu tượng: Hà Giang &rarr; Phú Quốc &rarr; Đà Lạt &rarr; Hạ Long.
  - Tự động thay đổi đồng bộ: Video MP4 nền, ảnh poster, tiêu đề tương phản cao, mô tả, nút active và nút CTA hành động trực tiếp. Rê chuột vào tự dừng để khách đọc thoải mái.

### 2. Trang Chủ (`resources/views/users/home.blade.php`)
- **Thanh Tìm Kiếm (Search Bar với Debounce & AbortController):**
  - Ô tìm kiếm tích hợp Debounce 350ms. Khi người dùng nhập liên tục, `AbortController` tự động hủy bỏ request cũ để chống spam server, chỉ gửi 1 request cuối cùng để lấy kết quả gợi ý vào dropdown auto-suggest.
  - Phía dưới là danh sách thẻ điểm đến nhanh (Hà Giang, Đà Lạt, Phú Quốc, Hạ Long...). Bấm vào tự điền và kích hoạt tìm kiếm.
- **Huy Hiệu & Tín Nhiệm (Credentials & Trust Signals):**
  - Hiển thị 4 cam kết lữ hành: *Bảo Hiểm Lữ Hành 100M*, *Chuẩn Mực 5 Sao*, *Hướng Dẫn Bản Địa*, *Minh Bạch Chi Phí*.
- **Trạm Thời Tiết Khí Hậu Điểm Đến (Weather Section):**
  - Tích hợp OpenWeatherMap API, hỗ trợ chuyển đổi nhanh 4 trạm khí tượng: Đà Lạt, Sa Pa, Phú Quốc, Đà Nẵng.
  - Hiển thị nhiệt độ (ngăn ngừa bẻ gãy dòng với `whitespace-nowrap`), độ ẩm, tốc độ gió, chỉ số UV, khuyến nghị lịch trình và dự báo nhiệt độ 5 ngày tới.
- **Lưới Tour Nổi Bật (Hot Tours Grid):**
  - Hiển thị các tour có lượt xem và số lượt đặt chỗ cao nhất. Thẻ tour thiết kế chuẩn `.travel-card`, hiển thị ảnh, số ngày đêm, điểm đến, đánh giá sao và đơn giá khởi điểm kèm chú thích rõ ràng: *"Giá từ • Gói xe du lịch"*.
- **Form Nhận Tư Vấn Nhanh (Consultation Form):**
  - Khách nhập tên, SĐT/Zalo, điểm đến và yêu cầu. Gửi AJAX POST lên `/tu-van`, tự động lưu thành Notification gửi tới ban quản trị.

### 3. Trang Chi Tiết Tour (`resources/views/users/tourDetail.blade.php`)
- **Carousel Trượt Ảnh Tự Động:**
  - Tự động trượt ảnh sau mỗi 3.5 giây, rê chuột vào tự dừng. Có nút tiến/lùi, bộ đếm số ảnh và thanh thumbnail đồng bộ bên dưới.
- **Trình Phát Video Thực Tế 4K (Native HTML5 Video Player Modal):**
  - Nút *"Video Review"* mở cửa sổ popup phát video 4K chất lượng cao của từng điểm đến bằng thẻ `<video controls playsinline>`. Triệt tiêu hoàn toàn lỗi chặn bản quyền trên web bên thứ 3 của YouTube.
- **Timeline Lịch Trình Chi Tiết:**
  - Tự động bóc tách mô tả từng ngày thành các block khung giờ: Buổi Sáng (07:30 - 11:30), Buổi Trưa (12:00 - 13:30), Buổi Chiều (14:00 - 17:30) và Buổi Tối (18:30 - 21:30).
  - Không còn ảnh lọ dầu gội lặp lại, hiển thị dạng dòng thời gian full-width chuyên nghiệp.
- **Bản Đồ Lộ Trình Tương Tác (Leaflet.js):**
  - Đọc tọa độ GPS từ API `/tour/schedule/{id}/json`. Vẽ đường đa tuyến Polyline nối liền các chặng dừng và cắm mốc đánh số từng ngày, kèm nút mở Google Maps dẫn đường.
- **Bộ Chọn Đợt Khởi Hành Định Kỳ:**
  - Cung cấp danh sách các đợt khởi hành cố định sắp tới (Đợt 1 gần nhất, Đợt 2 tuần sau, Đợt 3, Đợt 4 đặt trước) kèm số lượng chỗ còn nhận.
- **Cơ Chế Dynamic Live Pricing (Tính Giá Động):**
  - Xe ô tô du lịch: +0đ (Đã bao gồm trong giá vé).
  - Máy bay khứ hồi (20kg ký gửi) & Đón tiễn: Phụ thu +1.800.000đ/khách.
  - Khách sạn 3 sao: +0đ (Tiêu chuẩn trọn gói).
  - Khách sạn 4-5 sao (Deluxe): Phụ thu +800.000đ/khách.
  - Công thức tính: `Unit_Price = Base_Price + Transport_Surcharge + Hotel_Surcharge`, `Total_Price = Unit_Price * Quantity`.

### 4. Giỏ Hàng & Đặt Hàng (users/cart.blade.php, users/order.blade.php)
- Helper Cart: Quản lý giỏ hàng trong Session với Unique Key: `$key = $tour->id . $transport . $tour_type . $start_date;`.
- Voucher: Giảm theo phần trăm (kèm trần max_discount) hoặc tiền mặt, kiểm tra đơn hàng tối thiểu.
- Checkout Stepper: 3 bước (Thông tin -> Thanh toán MoMo/PayPal/Tiền mặt -> Xác nhận vé).

---

## PHẦN 3: LOGIC & CƠ CHẾ HOẠT ĐỘNG CÁC COMPONENT QUẢN TRỊ (ADMIN PANEL)
- master.blade.php: Bảo vệ bởi Middleware CheckAdmin (role === 'admin'). Cấu hình Tailwind CDN chuẩn.
- home.blade.php: Thống kê KPI tự động, biểu đồ Chart.js đa chỉ số (7 ngày, 30 ngày, cả năm).
- Tour & Lộ trình: CRUD Tour, nạp 190+ tour mẫu (`seedSample`), album ảnh, tiện ích, tọa độ GPS Leaflet.
- Danh mục: Nested Set model (`kalnoy/nestedset`), kéo thả Nestable.js qua route `/admin/categories/reorder`.
- Đơn hàng & Thanh toán: Vòng đời đơn (Chờ xử lý -> Đã cọc 30% -> Đã thanh toán 100% -> Hoàn tất/Hủy), in hóa đơn, xuất PDF.
- Voucher & User Voucher: Tạo mã giảm giá, cấp phát ngẫu nhiên.
- Tư vấn & Chat: Quản lý yêu cầu từ form trang chủ, chat trực tiếp Admin - Khách.

---

## PHẦN 4: HỆ THỐNG API & CƠ CHẾ GIAO TIẾP DỮ LIỆU

| Phương Thức | Endpoint | Handler | Chức Năng |
| :--- | :--- | :--- | :--- |
| **POST/GET** | `/api/chat` | `ChatbotController@chat` | Nhận tin nhắn, chạy AI (Gemini/Groq/Fallback), trả lời kèm link Markdown tour. |
| **GET** | `/api/chat/history` | `ChatbotController@history` | Lấy danh sách tin nhắn trong phiên của khách. |
| **GET** | `/search` | `HomeController@search` | Tìm kiếm nhanh AJAX (Debounce 350ms, AbortController). |
| **GET** | `/weather/ajax` | `WeatherController@searchAjax` | Lấy thời tiết từ trạm vệ tinh, trả về nhiệt độ, độ ẩm, gió, UV, dự báo 5 ngày. |
| **GET** | `/tour/schedule/{id}/json` | `TourDetailController@getScheduleByTour` | Trả về JSON danh sách chặng dừng kèm tọa độ GPS cho Leaflet map. |
| **POST** | `/tu-van` | `HomeController@sendConsultation` | Tiếp nhận form báo giá từ trang chủ, tạo Notification cho admin. |
| **GET** | `/momo/payment/{id}/{type}` | `MomoController@payment` | Khởi tạo thanh toán MoMo QR Code (cọc 30% hoặc 100%). |
| **POST** | `/momo/ipn` | `MomoController@ipn` | Webhook IPN từ MoMo, xác thực chữ ký HMAC SHA256 và cập nhật đơn. |
| **GET** | `/paypal/payment/{id}` | `PayPalController@createPayment` | Tạo thanh toán PayPal Client SDK, quy đổi VNĐ -> USD. |
| **GET** | `/paypal/success` | `PayPalController@paymentSuccess` | Capture tiền từ PayPal, cập nhật đơn hàng thành Đã đặt cọc. |
| **GET** | `/ping`, `/health` | Inline Closure | Endpoint giữ nhịp Cloud (Keep-alive) gọi mỗi 10 phút chống Render ngủ đông. |

---

## PHẦN 5: CÁC LUỒNG DỮ LIỆU ĐẶC THÙ (CORE WORKFLOWS)

### 1. Luồng Tính Giá Động (Dynamic Live Pricing)
```
Khách chọn Tour -> Chọn Đợt Khởi Hành -> Chọn Phương Tiện (Xe/Bay) -> Chọn Lưu Trú (3*/5*)
       |
       v
Sự kiện JS 'change' kích hoạt updateLivePrice()
       |
       v
Tính toán: Unit_Price = Base_Price + Trans_Surcharge + Hotel_Surcharge
           Total_Price = Unit_Price * Quantity
       |
       v
Giao diện nhảy số trực tiếp -> Form POST lên CartController@add -> Lưu Session Giỏ Hàng
```

### 2. Luồng Tư Vấn Lữ Hành Tự Động (AI Concierge)
```
Khách gửi câu hỏi qua Widget Chat -> POST /api/chat
       |
       v
Kiểm tra API Key (Google Gemini 2.0 / Groq LLM)
       |
   +---+-------------------------------+
   | (Có API Key)                      | (Không có / Lỗi mạng)
Gọi LLM kèm Context 12 Tour          Kích hoạt Smart Fallback Engine
& URL trực tiếp                      Bóc tách từ khóa không dấu, tra cứu DB
   |                                   |
   +-------------------+---------------+
                       v
Sinh câu trả lời kèm link Markdown [Xem chi tiết & Đặt vé](URL)
                       |
                       v
JavaScript phía Client tự động parse link thành nút bấm đất nung dẫn thẳng trang tour
```
