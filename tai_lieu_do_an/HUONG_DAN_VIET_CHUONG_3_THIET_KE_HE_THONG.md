# ĐỀ CƯƠNG & HƯỚNG DẪN VIẾT CHƯƠNG 3: THIẾT KẾ HỆ THỐNG
## HỆ THỐNG QUẢN LÝ VÀ ĐẶT TOUR DU LỊCH TRỰC TUYẾN (WANDERLUST TRAVEL VIETNAM)
### CĂN CỨ VÀO TẬP HỢP 10 SƠ ĐỒ DRAW.IO CHUẨN ĐỒ ÁN TỐT NGHIỆP

---

## 1. TỔNG QUAN VỊ TRÍ VÀ VAI TRÒ CỦA CHƯƠNG 3 TRONG BÁO CÁO
Chương 3 (**Thiết kế hệ thống** - *System Design*) là phần trọng tâm kỹ thuật của đồ án tốt nghiệp ngành Công nghệ thông tin / Kỹ thuật phần mềm. 
Nhiệm vụ của chương là chuyển hóa các yêu cầu bài toán (Chương 1) và nền tảng công nghệ (Chương 2) thành các mô hình kiến trúc, biểu đồ hướng đối tượng UML, cấu trúc cơ sở dữ liệu và thiết kế giao diện cụ thể.

Tất cả các sơ đồ trong chương 3 đã được vẽ sẵn chuẩn xác trong thư mục `tai_lieu_do_an/so_do_drawio/`. Sinh viên chỉ cần xuất ảnh (PNG 300 DPI hoặc SVG) và dán tương ứng vào các mục theo đề cương dưới đây.

---

## 2. KHUNG MỤC LỤC CHUẨN CỦA CHƯƠNG 3

```
CHƯƠNG 3: THIẾT KẾ HỆ THỐNG (SYSTEM DESIGN)
├── 3.1. Thiết kế Kiến trúc tổng thể hệ thống (System Architecture)
│   ├── 3.1.1. Mô hình kiến trúc phân tầng (4-Tier Architecture)
│   └── 3.1.2. Mối liên kết giữa các tầng và cơ chế giao tiếp API
├── 3.2. Thiết kế Mô hình Chức năng và Biểu đồ Use Case (Use Case Design)
│   ├── 3.2.1. Biểu đồ Use Case tổng quan toàn hệ thống
│   ├── 3.2.2. Phân rã Use Case phân hệ Khách hàng & Đặt tour
│   ├── 3.2.3. Phân rã Use Case phân hệ Quản trị hệ thống (Admin)
│   └── 3.2.4. Bảng đặc tả chi tiết các Use Case chính (Use Case Specs)
├── 3.3. Thiết kế Luồng hoạt động nghiệp vụ (Activity Diagram Design)
│   ├── 3.3.1. Sơ đồ hoạt động luồng Đặt tour và Thanh toán trực tuyến
│   ├── 3.3.2. Sơ đồ hoạt động luồng Trợ lý ảo AI Concierge
│   └── 3.3.3. Sơ đồ hoạt động luồng Xác thực tài khoản & Khôi phục mật khẩu
├── 3.4. Thiết kế Tương tác đối tượng và Tuần tự (Sequence Diagram Design)
│   ├── 3.4.1. Sơ đồ tuần tự Quy trình Đặt tour và Thanh toán MoMo / PayPal
│   └── 3.4.2. Sơ đồ tuần tự Luồng Tư vấn du lịch thông minh bằng AI
├── 3.5. Thiết kế Cơ sở dữ liệu (Database Design)
│   ├── 3.5.1. Sơ đồ mối quan hệ thực thể (ERD)
│   ├── 3.5.2. Chuẩn hóa dữ liệu về dạng chuẩn 3NF
│   └── 3.5.3. Từ điển dữ liệu chi tiết các bảng (Data Dictionary)
├── 3.6. Thiết kế Giao diện người dùng và Luồng màn hình (UI/UX Design)
│   ├── 3.6.1. Thiết kế giao diện phân hệ Khách hàng (Client Portal)
│   └── 3.6.2. Thiết kế giao diện phân hệ Quản trị (Admin Dashboard)
└── 3.7. Tóm tắt Chương 3
```

---

## 3. CHI TIẾT CÁCH TRIỂN KHAI TỪNG MỤC VÀ GẮN KẾT VỚI CÁC FILE DRAW.IO

### 3.1. Thiết kế Kiến trúc tổng thể hệ thống (System Architecture)
- **Tập tin Draw.io tích hợp:** `09_kien_truc_he_thong_architecture.drawio`
- **Nội dung cần viết:**
  - Giới thiệu mô hình 4 tầng kiến trúc của Wanderlust Travel:
    1. *Tầng Trình diễn (Client Layer):* Trình duyệt web máy tính và thiết bị di động, render giao diện Blade, Tailwind CSS Universal Theme, bản đồ Leaflet.js và JavaScript tương tác.
    2. *Tầng Cổng & Máy chủ Web (Gateway / Web Server Layer):* Apache 2.4 đặt trong Docker Container trên nền tảng Render PaaS, xử lý mã hóa SSL/TLS, định tuyến mod_rewrite.
    3. *Tầng Nghiệp vụ ứng dụng (Application / Business Logic Layer):* Laravel 9 Framework gồm hệ thống Routing, Middleware bảo vệ (CheckAdmin, CheckUser, VerifyCsrfToken), tầng Controllers, Services và Eloquent ORM.
    4. *Tầng Dữ liệu & Dịch vụ bên thứ ba (Data & External Services Layer):* Hệ quản trị CSDL phân tán TiDB Cloud Serverless (MySQL Protocol), cổng thanh toán MoMo (HMAC SHA-256), cổng quốc tế PayPal (REST API), ngân hàng VietQR, OpenWeatherMap API, Google Gemini AI / Groq LLM API.
  - Phân tích cơ chế bảo mật trên đường truyền giữa các tầng.

---

### 3.2. Thiết kế Mô hình Chức năng và Biểu đồ Use Case (Use Case Design)

#### 3.2.1. Biểu đồ Use Case tổng quan toàn hệ thống
- **Tập tin Draw.io tích hợp:** `01_use_case_tong_quan.drawio`
- **Nội dung cần viết:**
  - Định nghĩa các Tác nhân (Actors) tham gia vào hệ thống:
    - *Khách vãng lai (Guest):* Xem danh sách tour, tìm kiếm địa danh, xem thời tiết, tương tác hỏi đáp với Trợ lý AI Concierge, đăng ký/đăng nhập tài khoản.
    - *Khách hàng thành viên (Member/User):* Đặt tour, tùy chọn dịch vụ phụ trợ, áp dụng voucher, thanh toán MoMo/PayPal/VietQR, theo dõi trạng thái đơn hàng, viết đánh giá tour.
    - *Quản trị viên (Admin):* Quản lý kho tour và lịch trình GPS, quản lý danh mục cây phân cấp, duyệt/hủy đơn hàng, quản lý mã voucher, thống kê doanh thu và báo cáo lượt xem.
    - *Hệ thống bên ngoài (External Systems):* Máy chủ MoMo (xác thực IPN), PayPal Server (capture thanh toán), VietQR Bank Gateway, OpenWeather API, Google Gemini / Groq API.
  - Chèn ảnh xuất từ file `01_use_case_tong_quan.drawio`.

#### 3.2.2. Phân rã Use Case phân hệ Khách hàng & Đặt tour
- **Tập tin Draw.io tích hợp:** `02_use_case_dat_tour_va_thanh_toan.drawio`
- **Nội dung cần viết:**
  - Phân tích sâu quy trình đặt tour phía khách hàng.
  - Các mối quan hệ `<<include>>` (Bắt buộc): Chọn tour phải *<<include>>* Kiểm tra số chỗ còn nhận (`TourSchedule`), Đặt hàng phải *<<include>>* Cung cấp thông tin liên hệ.
  - Các mối quan hệ `<<extend>>` (Mở rộng tùy chọn): Áp dụng mã giảm giá Voucher (*<<extend>>*), Chọn phương tiện đưa đón và hạng khách sạn (*<<extend>>*), Chọn phương thức đặt cọc 30% thay vì trả 100% (*<<extend>>*).

#### 3.2.3. Phân rã Use Case phân hệ Quản trị hệ thống (Admin)
- **Tập tin Draw.io tích hợp:** `03_use_case_quan_tri_admin.drawio`
- **Nội dung cần viết:**
  - Phân tích các phân hệ nghiệp vụ của người điều hành:
    - Quản lý Tour & Lộ trình chi tiết: Thêm mới, upload nhiều ảnh, gán tiện ích, nhập tọa độ GPS cho Leaflet map.
    - Quản lý Cây danh mục (Nested Set Model): Kéo thả thay đổi thứ tự và cấp độ cha-con.
    - Quản lý Đơn hàng: Kiểm tra thông tin thanh toán, chuyển trạng thái đơn (Chờ xử lý, Đã cọc 30%, Đã thanh toán 100%, Hoàn tất, Hủy đơn).
    - Quản lý Khuyến mãi: Thiết lập mã voucher (giảm %, giảm tiền mặt, số lượng, hạn dùng).
    - Báo cáo thống kê: Thống kê doanh thu theo kỳ, biểu đồ xu hướng Chart.js.

#### 3.2.4. Bảng đặc tả chi tiết các Use Case chính
Sinh viên kẻ các bảng đặc tả chuẩn công nghệ phần mềm:
- **Bảng đặc tả UC-01: Đặt tour du lịch và Tùy biến dịch vụ** (Actor, Điều kiện tiên quyết, Luồng sự kiện chính từ lúc bấm "Đặt tour" tới khi vào giỏ hàng, Luồng ngoại lệ: Hết chỗ, ngày khởi hành đã qua).
- **Bảng đặc tả UC-02: Thanh toán trực tuyến qua MoMo QR** (Actor, Điều kiện tiên quyết, Luồng sự kiện chính: Chọn MoMo -> Sinh chữ ký HMAC -> Hiển thị QR -> Khách quét mã -> MoMo gọi IPN Webhook -> Cập nhật CSDL, Luồng ngoại lệ: Chữ ký không hợp lệ, hết hạn thanh toán).
- **Bảng đặc tả UC-03: Tư vấn lữ hành tự động qua AI Concierge** (Actor, Điều kiện tiên quyết, Luồng sự kiện: Mở widget -> Gõ câu hỏi -> API gọi Gemini với System Prompt & 12 tour mẫu -> Nhận phản hồi kèm link Markdown -> Render nút bấm chi tiết).

---

### 3.3. Thiết kế Luồng hoạt động nghiệp vụ (Activity Diagram Design)

#### 3.3.1. Sơ đồ hoạt động luồng Đặt tour và Thanh toán trực tuyến
- **Tập tin Draw.io tích hợp:** `04_activity_luong_dat_tour_va_thanh_toan.drawio`
- **Nội dung cần viết:**
  - Mô tả chuỗi hành động có rẽ nhánh điều kiện: Khách chọn tour -> Hệ thống kiểm tra số lượng chỗ trống -> Khách chọn ngày/dịch vụ phụ trợ -> Tính live price -> Nhập voucher (hợp lệ thì trừ tiền, không hợp lệ báo lỗi) -> Chọn cổng thanh toán (MoMo/PayPal/VietQR) -> Xử lý giao dịch -> Kiểm tra kết quả giao dịch (Thành công: Cập nhật CSDL, trừ số lượng, gửi email vé; Thất bại: Giữ nguyên đơn, thông báo lỗi cho khách).

#### 3.3.2. Sơ đồ hoạt động luồng Trợ lý ảo AI Concierge
- **Tập tin Draw.io tích hợp:** `05_activity_luong_ai_concierge.drawio`
- **Nội dung cần viết:**
  - Mô tả luồng xử lý thông minh: Khách gửi tin nhắn -> ChatbotController tiếp nhận -> Kiểm tra cấu hình API Key (Google Gemini / Groq) -> Nếu có kết nối: Truy vấn 12 tour CSDL, ghép System Context, gửi prompt tới LLM -> Nếu mất kết nối hoặc lỗi: Chuyển sang Smart Fallback Engine (xóa dấu tiếng Việt, tìm từ khóa địa danh trong CSDL) -> Trả lời khách hàng kèm link Markdown dẫn thẳng trang tour.

#### 3.3.3. Sơ đồ hoạt động luồng Xác thực tài khoản & Khôi phục mật khẩu
- **Tập tin Draw.io tích hợp:** `06_activity_luong_xac_thuc_va_quen_mat_khau.drawio`
- **Nội dung cần viết:**
  - Mô tả luồng đăng ký (kiểm tra email trùng lặp, băm mật khẩu Bcrypt), đăng nhập và luồng quên mật khẩu (nhập email -> sinh token ngẫu nhiên lưu bảng `password_resets` -> gửi link qua email -> khách click đặt lại mật khẩu mới).

---

### 3.4. Thiết kế Tương tác đối tượng và Tuần tự (Sequence Diagram Design)

#### 3.4.1. Sơ đồ tuần tự Đặt tour và Xử lý Thanh toán MoMo / PayPal
- **Tập tin Draw.io tích hợp:** `07_sequence_dat_tour_va_thanh_toan.drawio`
- **Nội dung cần viết:**
  - Mô tả các thông điệp trao đổi giữa các đối tượng (Lifelines):
    1. `User`: Tác nhân người dùng.
    2. `TourDetailView`: Giao diện chi tiết tour.
    3. `CartController`: Điều khiển giỏ hàng và tính giá động.
    4. `OrderController`: Tạo hóa đơn đặt tour.
    5. `MomoController` / `PayPalController`: Xử lý giao dịch thanh toán.
    6. `PaymentGateway` (MoMo API / PayPal API): Máy chủ thanh toán đối tác.
    7. `Database` (TiDB / MySQL): Lưu trữ trạng thái đơn hàng.
    8. `MailService`: Gửi email xác nhận vé điện tử.

#### 3.4.2. Sơ đồ tuần tự Luồng Tư vấn du lịch thông minh bằng AI
- **Tập tin Draw.io tích hợp:** `08_sequence_tu_van_ai.drawio`
- **Nội dung cần viết:**
  - Thể hiện tương tác thời gian thực:
    `User` &rarr; `ChatWidget (JS)` &rarr; `POST /api/chat` &rarr; `ChatbotController` &rarr; `Tour Model` (lấy 12 tour mới) &rarr; `Gemini / Groq API` &rarr; Phản hồi chuỗi Markdown &rarr; `ChatMessage Model` (ghi lịch sử) &rarr; Trả về JSON &rarr; JavaScript bóc tách Markdown render nút đặt vé tương tác.

---

### 3.5. Thiết kế Cơ sở dữ liệu (Database Design)

#### 3.5.1. Sơ đồ Mối quan hệ Thực thể liên kết (ERD)
- **Tập tin Draw.io tích hợp:** `10_so_do_thuc_the_erd_database.drawio`
- **Nội dung cần viết:**
  - Giới thiệu tổng thể 15+ bảng thực thể, quan hệ 1-N (Users - Orders, Categories - Tours, Tours - TourSchedules, Orders - Payments) và quan hệ N-N (Tours - AttrTours, Users - Vouchers).

#### 3.5.2. Chuẩn hóa dữ liệu về Dạng chuẩn 3 (3NF)
- Trình bày quá trình chuẩn hóa:
  - Dạng chuẩn 1 (1NF): Mọi thuộc tính đều là nguyên tố (nguyên tử), không chứa mảng lặp lại.
  - Dạng chuẩn 2 (2NF): Đạt 1NF và mọi thuộc tính không khóa đều phụ thuộc hàm toàn bộ vào khóa chính.
  - Dạng chuẩn 3 (3NF): Đạt 2NF và không có thuộc tính không khóa nào phụ thuộc bắc cầu vào khóa chính (Ví dụ tách bảng `tour_schedules`, `payments`, `vouchers` thành các thực thể riêng thay vì gộp chung vào bảng `orders`).

#### 3.5.3. Từ điển Dữ liệu chi tiết các bảng (Data Dictionary)
Sinh viên lập bảng chi tiết cho các thực thể quan trọng nhất:
1. **Bảng `users`:** Quản lý tài khoản (id, name, email, password, phone, address, role, status...).
2. **Bảng `tours`:** Quản lý sản phẩm tour (id, name, price, sale_price, category_id, start_location, end_location, time, quantity...).
3. **Bảng `categories`:** Quản lý danh mục cây lồng nhau (id, name, category_id, _lft, _rgt, parent_id, status...).
4. **Bảng `tour_schedules`:** Lịch trình chi tiết từng ngày và tọa độ GPS (id, tour_id, day_number, title, description, location_name, latitude, longitude...).
5. **Bảng `orders`:** Đơn đặt tour (id, tour_id, user_id, name, phone, email, total_price, voucher_id, discount_amount, status...).
6. **Bảng `payments` & `transactions`:** Lịch sử thanh toán và mã giao dịch MoMo/PayPal/VietQR.
7. **Bảng `vouchers` & `user_vouchers`:** Mã giảm giá và cấp phát người dùng.
8. **Bảng `chat_messages` & `chat_sessions`:** Phiên và tin nhắn tư vấn AI.

---

### 3.6. Thiết kế Giao diện người dùng và Luồng màn hình (UI/UX Design)
- **3.6.1. Phân hệ Khách hàng (Client Portal):**
  - Chèn ảnh chụp hoặc wireframe các màn hình chính:
    1. Trang chủ: Hero Banner Video Auto-Slide, Thanh tìm kiếm Debounce 350ms, Trạm khí hậu OpenWeatherMap.
    2. Trang Chi tiết Tour: Thư viện ảnh, Lộ trình ngày 1/2/3 tích hợp bản đồ Leaflet ghim tọa độ GPS, Widget tính giá động Live Pricing.
    3. Trang Giỏ hàng & Thanh toán: Chọn cọc 30% / 100%, nhập mã Voucher, chọn cổng MoMo / PayPal / VietQR.
    4. Widget Trợ lý lữ hành AI Concierge (cố định góc phải màn hình).
- **3.6.2. Phân hệ Quản trị viên (Admin Panel):**
  - Chèn ảnh màn hình:
    1. Bảng điều khiển KPI Dashboard: Biểu đồ Chart.js thống kê doanh thu đa mốc thời gian.
    2. Quản lý danh mục kéo thả Nestable.js.
    3. Thêm mới / Chỉnh sửa Tour và cấu hình tọa độ GPS Leaflet.
    4. Quản lý Đơn hàng và Lịch sử thanh toán.

---

## 4. TỔNG KẾT VÀ LỜI KHUYÊN CHO SINH VIÊN KHI TRÌNH BÀY
- **Tính đồng bộ tuyệt đối:** Tên bảng và tên trường trong mục 3.5 (CSDL) phải khớp 100% với file `10_so_do_thuc_the_erd_database.drawio` và mã nguồn migration của Laravel.
- **Thuyết minh rõ ràng:** Với mỗi hình vẽ xuất từ draw.io, luôn có đoạn văn giới thiệu trước hình và phân tích ý nghĩa sau hình, không bao giờ để "hình ảnh đứng bơ vơ" mà không có lời giải thích.
- **Độ sắc nét hình ảnh:** Trong draw.io chọn Export as PNG với độ phân giải **300 DPI** hoặc chọn Zoom **200%**, ảnh khi in ra khổ A4 sẽ vô cùng sắc nét, được hội đồng đánh giá rất cao.
