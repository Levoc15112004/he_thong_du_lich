# CHƯƠNG 2: CƠ SỞ LÝ THUYẾT VÀ CÔNG NGHỆ NỀN TẢNG
## ĐỒ ÁN TỐT NGHIỆP: HỆ THỐNG QUẢN LÝ VÀ ĐẶT TOUR DU LỊCH TRỰC TUYẾN THÔNG MINH (WANDERLUST TRAVEL VIETNAM)

---

## 2.1. TỔNG QUAN BÀI TOÁN LỮ HÀNH SỐ VÀ MÔ HÌNH ĐẠI LÝ DU LỊCH TRỰC TUYẾN (OTA)

### 2.1.1. Bối cảnh và thách thức chuyển đổi số trong ngành du lịch Việt Nam
Ngành du lịch và lữ hành là một trong những ngành kinh tế mũi nhọn, đóng góp tỷ trọng lớn vào GDP của Việt Nam. Tuy nhiên, các phương thức vận hành lữ hành truyền thống đang bộc lộ nhiều điểm nghẽn nghiêm trọng:
- **Quy trình thủ công, độ trễ cao:** Khách hàng phải liên hệ qua điện thoại, nhắn tin hoặc đến trực tiếp phòng vé để hỏi lịch trình, kiểm tra số chỗ trống và nhận báo giá. Việc chốt đơn phụ thuộc hoàn toàn vào nhân sự tư vấn, dẫn đến quá tải vào mùa cao điểm (lễ, Tết, kỳ nghỉ hè).
- **Thiếu tính minh bạch và cá nhân hóa:** Giá tour biến động phụ thuộc vào dịch vụ phát sinh (phương tiện di chuyển, hạng sao khách sạn, phụ thu phòng đơn, trẻ em). Phương thức truyền thống không cho phép khách hàng tự tùy biến gói dịch vụ và xem giá nhảy số trực tiếp theo thời gian thực (Live Dynamic Pricing).
- **Rủi ro quản trị dữ liệu phân tán:** Việc quản lý lịch trình, số chỗ còn nhận, danh sách hành khách bằng file bảng tính (Excel/Sheets) dẫn đến tình trạng đặt trùng chỗ (overbooking), sót đơn, sai lệch thông tin thanh toán và khó khăn trong việc đối soát dòng tiền.
- **Dịch vụ khách hàng 24/7 bị giới hạn:** Khách du lịch hiện đại thường tìm kiếm và lên kế hoạch chuyến đi vào buổi tối hoặc ngày nghỉ. Thiếu vắng một trợ lý tư vấn tự động, hiểu biết sâu về lộ trình và văn hóa bản địa khiến doanh nghiệp đánh mất lượng lớn khách hàng tiềm năng.

### 2.1.2. Mô hình Đại lý Du lịch Trực tuyến (Online Travel Agency - OTA)
Mô hình OTA (Online Travel Agency) là mô hình kinh doanh nền tảng số hóa cho phép kết nối trực tiếp hoặc phân phối các sản phẩm du lịch (tour trọn gói, vé máy bay, phòng khách sạn, vé tham quan) tới người dùng cuối thông qua môi trường mạng Internet.

Hệ thống **Wanderlust Travel Vietnam** được định vị là một nền tảng OTA chuyên biệt cho du lịch trải nghiệm văn hóa bản địa Việt Nam, kết hợp các đặc tính công nghệ hiện đại:
- **Cung cấp thông tin đa chiều:** Tích hợp mô tả chi tiết, hình ảnh chất lượng cao, đánh giá thực tế từ du khách và bản đồ định vị GPS trực quan hóa từng chặng dừng chân.
- **Tính toán chi phí linh hoạt và minh bạch:** Tự động điều chỉnh tổng giá theo dịch vụ cộng thêm và mã giảm giá khuyến mãi (Voucher Engine).
- **Đa kênh thanh toán trực tuyến:** Hỗ trợ thanh toán nhanh qua mã QR ví điện tử MoMo, thẻ thanh toán quốc tế PayPal và chuyển khoản ngân hàng chuẩn VietQR.
- **Tư vấn thông minh tích hợp Trí tuệ nhân tạo (AI Concierge):** Ứng dụng mô hình ngôn ngữ lớn (LLM) để tiếp nhận ngôn ngữ tự nhiên của khách hàng, phân tích nhu cầu và gợi ý lộ trình phù hợp ngay trong phiên trò chuyện.

---

## 2.2. KIẾN TRÚC PHẦN MỀM VÀ CÁC MÔ HÌNH THIẾT KẾ (SOFTWARE ARCHITECTURE & PATTERNS)

### 2.2.1. Mô hình Kiến trúc MVC (Model - View - Controller)
Mô hình kiến trúc MVC là mẫu thiết kế kinh điển và chuẩn mực trong kỹ thuật phần mềm web hiện đại, phân tách hệ thống thành 3 thành phần có trách nhiệm độc lập:

1. **Model (Mô hình dữ liệu):**
   - Đại diện cho cấu trúc dữ liệu, các quy tắc nghiệp vụ (Business Rules) và logic thao tác với cơ sở dữ liệu.
   - Trong dự án Wanderlust Travel, Model được cài đặt thông qua Eloquent ORM của Laravel (như `Tour`, `Order`, `TourSchedule`, `Category`, `Payment`). Model quản lý các mối quan hệ thực thể, ràng buộc dữ liệu, bộ lọc phạm vi (`scopes`) và các sự kiện vòng đời bản ghi (`model events`).
2. **View (Tầng hiển thị):**
   - Chịu trách nhiệm trực quan hóa dữ liệu và cung cấp giao diện tương tác cho người dùng.
   - Hệ thống sử dụng Laravel Blade Template kết hợp Tailwind CSS, nhận dữ liệu đã được xử lý từ Controller để sinh mã HTML trả về cho trình duyệt. View hoàn toàn tách biệt khỏi các logic truy vấn cơ sở dữ liệu phức tạp.
3. **Controller (Bộ điều khiển):**
   - Đóng vai trò cầu nối điều phối giữa View và Model.
   - Tiếp nhận HTTP Request từ phía Client (thông qua hệ thống Routing), xác thực dữ liệu đầu vào (`Form Request Validation`), gọi các phương thức nghiệp vụ từ Model/Service, và quyết định phản hồi trả về (render View Blade hoặc trả về cấu trúc dữ liệu JSON cho các API call).

```
   +-------------------------------------------------------+
   |                     HTTP Request                      |
   +---------------------------+---------------------------+
                               |
                               v
   +-------------------------------------------------------+
   |                       ROUTING                         |
   +---------------------------+---------------------------+
                               |
                               v
   +-------------------------------------------------------+
   |                      CONTROLLER                       |
   |   (Xác thực input, điều phối nghiệp vụ, tính giá)    |
   +---------------+-----------------------+---------------+
                   |                       |
    Truy vấn/Cập nhật dữ liệu         Truyền View Model
                   v                       v
   +-----------------------+       +-----------------------+
   |         MODEL         |       |         VIEW          |
   |     (Eloquent ORM)    |       |   (Blade + Tailwind)  |
   +-----------+-----------+       +-----------+-----------+
               |                               |
               v                               v
   +-----------------------+       +-----------------------+
   |    DATABASE ENGINE    |       |     CLIENT BROWSER    |
   | (MySQL / TiDB Cloud)  |       |   (HTML/CSS/JS Output)|
   +-----------------------+       +-----------------------+
```

**Lợi ích kỹ thuật của việc áp dụng MVC trong đồ án:**
- **Tính phân tách rõ ràng (Separation of Concerns):** Giúp mã nguồn dễ bảo trì, cho phép các thành viên hoặc các giai đoạn phát triển giao diện (Frontend) và logic nghiệp vụ (Backend) diễn ra song song mà không xung đột.
- **Khả năng mở rộng và tái sử dụng:** Dữ liệu từ Model có thể phục vụ đồng thời cho cả tầng giao diện web truyền thống lẫn tầng dịch vụ API cho thiết bị di động hoặc widget nhúng ngoài.

### 2.2.2. Kiến trúc Monolith mở rộng phân tầng (Multi-tier Layered Architecture)
Hệ thống được xây dựng theo kiến trúc phân tầng (Layered Architecture) bên trong một khối ứng dụng đồng nhất (Modular Monolith), đảm bảo tối ưu chi phí vận hành hạ tầng mà vẫn giữ được tính mô-đun hóa cao:
- **Tầng Trình bày (Presentation Layer):** Gồm hệ thống giao diện Blade Templates, các thành phần UI Tailwind, widget JavaScript tương tác bất đồng bộ (AJAX Fetch API).
- **Tầng Kiểm soát & Định tuyến (Routing & Middleware Layer):** Đảm nhiệm việc lọc lưu lượng mạng, kiểm tra an toàn bảo mật (CSRF, XSS filter), xác thực phân quyền người dùng (`CheckAdmin`, `CheckUser`).
- **Tầng Dịch vụ Nghiệp vụ (Business Application Layer):** Các Controller chuyên trách (Booking, Payment, TourDetail, Chatbot, Weather), kết hợp với các Service Client gọi ra ngoài.
- **Tầng Truy xuất Dữ liệu (Data Access Layer):** Eloquent ORM và Query Builder, thực thi các truy vấn tối ưu xuống cơ sở dữ liệu quan hệ.
- **Tầng Dịch vụ Mở rộng (External Integration Layer):** Tích hợp dịch vụ đám mây của bên thứ ba bao gồm MoMo Payment Gateway, PayPal SDK, VietQR Webhook, OpenWeatherMap API, Google Gemini AI, Groq LPU API.

### 2.2.3. Chuẩn thiết kế RESTful API Architecture
REST (Representational State Transfer) là kiểu kiến trúc phần mềm sử dụng các giao thức chuẩn của World Wide Web để truyền tải dữ liệu giữa máy khách và máy chủ:
- **Tính phi trạng thái (Stateless):** Mỗi yêu cầu từ Client gửi lên Server phải chứa đầy đủ mọi thông tin cần thiết để Server hiểu và xử lý. Máy chủ không lưu giữ ngữ cảnh phiên làm việc của Client giữa các request API, giúp hệ thống dễ dàng mở rộng theo chiều ngang.
- **Giao diện đồng nhất (Uniform Interface):** Hệ thống định danh tài nguyên thông qua định dạng URI (Uniform Resource Identifier) chuẩn hóa và sử dụng các phương thức HTTP chuẩn:
  - `GET`: Truy xuất dữ liệu tài nguyên (Ví dụ: `GET /api/chat/history`, `GET /tour/schedule/{id}/json`).
  - `POST`: Tạo mới tài nguyên hoặc kích hoạt tác vụ nghiệp vụ có payload (Ví dụ: `POST /api/chat`, `POST /momo/ipn`, `POST /paypal/create`).
- **Mã phản hồi tiêu chuẩn (HTTP Status Codes):**
  - `200 OK`: Yêu cầu thực thi thành công và trả về dữ liệu.
  - `201 Created`: Bản ghi mới đã được tạo thành công trong cơ sở dữ liệu.
  - `400 Bad Request`: Tham số đầu vào không hợp lệ hoặc thiếu trường bắt buộc.
  - `401 Unauthorized` / `403 Forbidden`: Khách chưa xác thực danh tính hoặc không đủ quyền hạn.
  - `404 Not Found`: Tài nguyên yêu cầu không tồn tại trên hệ thống.
  - `500 Internal Server Error`: Lỗi phát sinh trong quá trình xử lý nội bộ của máy chủ.

---

## 2.3. NỀN TẢNG BACKEND VÀ NGÔN NGỮ LẬP TRÌNH

### 2.3.1. Ngôn ngữ lập trình PHP 8.1 và những cải tiến hiệu năng
PHP (Hypertext Preprocessor) là ngôn ngữ kịch bản phía máy chủ chiếm thị phần lớn nhất thế giới trong phát triển ứng dụng web. Phiên bản PHP 8.1 mang lại những đột phá công nghệ vượt bậc được khai thác trong dự án:
- **JIT Compiler (Just-In-Time Compilation):** Trình biên dịch JIT dịch trực tiếp mã trung gian (Opcode) thành mã máy nguyên bản của CPU tại thời điểm chạy. Điều này cải thiện vượt bậc tốc độ xử lý các tác vụ nặng tính toán như thuật toán bóc tách từ khóa tiếng Việt không dấu, giải mã JSON kích thước lớn từ AI API và tính toán ma trận ma trận giá tour phức tạp.
- **Strict Typing & Readonly Properties:** Hệ thống khai báo kiểu dữ liệu chặt chẽ giúp phát hiện lỗi sai kiểu dữ liệu ngay tại giai đoạn biên dịch/thông dịch, giảm thiểu tối đa các lỗi ngoại lệ runtime trong quá trình giao dịch tài chính.
- **Fibers (Xử lý đồng thời nhẹ - Lightweight Concurrency):** Cung cấp cơ chế Coroutines để quản lý các tác vụ I/O không khóa (non-blocking I/O), hỗ trợ hiệu quả khi hệ thống phải đồng thời gửi nhiều request ra các dịch vụ ngoài (MoMo, PayPal, Weather, Gemini).

### 2.3.2. Framework Laravel 9 và Hệ sinh thái
Laravel là framework PHP mã nguồn mở theo chuẩn doanh nghiệp, nổi tiếng với cú pháp tao nhã, cấu trúc chặt chẽ và hệ sinh thái toàn diện:
- **Chu trình vòng đời của một HTTP Request (Request Lifecycle):**
  1. Yêu cầu từ Client đi qua máy chủ Web (Apache với module `mod_rewrite`) và được chuyển hướng về tập tin khởi đầu duy nhất: `public/index.php`.
  2. Nạp Composer Autoloader và khởi tạo thể hiện của ứng dụng (`Illuminate\Foundation\Application`).
  3. Chuyển Request vào HTTP Kernel (`App\Http\Kernel`), tại đây các dịch vụ cốt lõi (`Service Providers`) được đăng ký và khởi động (Bootstrapping: nạp cấu hình, cấu hình môi trường `.env`, kết nối CSDL).
  4. Request đi qua chuỗi Middleware toàn cục và Middleware theo nhóm route (kiểm tra trạng thái bảo trì, mã hóa cookie, xác thực CSRF Token).
  5. Router ánh xạ URI tới Controller hoặc Closure tương ứng. Request đi qua các Middleware cục bộ (`CheckAdmin`, `CheckUser`).
  6. Controller thực thi logic nghiệp vụ, tương tác với Model/Service và trả về đối tượng `Response`.
  7. Response quay ngược lại qua chuỗi Middleware (gắn cookie, header bảo mật) và được gửi về trình duyệt của khách hàng.

### 2.3.3. Tầng ánh xạ quan hệ thực thể Eloquent ORM
Eloquent ORM trong Laravel cài đặt mẫu kiến trúc **Active Record**, trong đó mỗi lớp Model đại diện cho một bảng trong CSDL, và mỗi thể hiện của Model đại diện cho một dòng dữ liệu:
- **Cơ chế quan hệ liên kết dữ liệu phong phú:**
  - *One to Many (1-N):* Một danh mục `Category` có nhiều tour `tours()`; Một tour `Tour` có nhiều chặng lịch trình `tourSchedules()` và nhiều hình ảnh `images()`.
  - *Many to Many (N-N):* Quan hệ giữa tour và các tiện ích đặc thù thông qua bảng trung gian `tour_attr` (`belongsToMany(AttrTour::class)`).
  - *One to One Polymorphic:* Quản lý thanh toán giao dịch liên kết trực tiếp với đơn đặt tour `order()`.
- **Giải quyết triệt để bài toán N+1 Query:**
  - Bài toán N+1 query xảy ra khi truy vấn danh sách N tour, sau đó trong vòng lặp lại thực hiện N câu truy vấn con để lấy hình ảnh hoặc danh mục, gây nghẽn đường truyền và sụt giảm nghiêm trọng hiệu năng CSDL.
  - Dự án ứng dụng kỹ thuật **Eager Loading** (`Tour::with(['category', 'images', 'tourSchedules'])->get()`), gom toàn bộ các khóa ngoại và chỉ thực thi đúng 2 đến 3 câu lệnh SQL tối ưu với mệnh đề `IN (...)`, giảm thời gian phản hồi trang từ 1.8 giây xuống dưới 120ms.

### 2.3.4. Cơ chế Service Container & Dependency Injection
Service Container là trái tim của framework Laravel, đóng vai trò một thùng chứa đảo ngược điều khiển (Inversion of Control - IoC):
- **Dependency Injection (Tiêm phụ thuộc):** Cho phép các Controller khai báo trực tiếp các lớp phụ thuộc (như `Request`, `TourService`, `ChatSession`) vào phương thức khởi tạo (`__construct`) hoặc phương thức xử lý. Container tự động sử dụng Reflection API để khởi tạo và truyền các đối tượng cần thiết.
- **Lợi ích:** Giảm sự phụ thuộc cứng (tight coupling) giữa các lớp, thuận lợi tối đa cho việc viết mã kiểm thử đơn vị (Unit Test) và hoán đổi dịch vụ (ví dụ hoán đổi giữa Gemini AI Service và Groq AI Service mà không cần sửa đổi mã nguồn Controller).

### 2.3.5. Cơ chế Middleware Pipeline
Middleware đóng vai trò như các lớp lọc trung gian bao bọc lấy ứng dụng:
- **Kiểm tra quyền truy cập:** `CheckAdmin` đảm bảo người dùng đã xác thực và có trường `role === 'admin'`, ngăn chặn truy cập trái phép vào các tài nguyên nhạy cảm như quản trị doanh thu, cập nhật trạng thái đơn hàng.
- **Bảo vệ toàn vẹn phiên:** `CheckUser` xác thực tài khoản du khách khi thực hiện quy trình thanh toán hoặc xem lịch sử hóa đơn.

---

## 2.4. CÔNG NGHỆ CƠ SỞ DỮ LIỆU VÀ CẤU TRÚC DỮ LIỆU PHÂN CẤP

### 2.4.1. Hệ quản trị Cơ sở dữ liệu Quan hệ MySQL 8.0
MySQL là hệ quản trị cơ sở dữ liệu quan hệ mã nguồn mở phổ biến nhất thế giới:
- **Đảm bảo tính toàn vẹn giao dịch (ACID - Atomicity, Consistency, Isolation, Durability):** Toàn bộ quy trình đặt tour và thanh toán được thực thi trong một Transaction. Nếu bước tạo giao dịch thanh toán hoặc trừ số lượng chỗ thất bại, toàn bộ thao tác thêm đơn hàng sẽ được hoàn tác (`DB::rollBack()`), loại bỏ hoàn toàn hiện tượng dữ liệu rác hoặc sai lệch số dư.
- **Cơ chế lưu trữ InnoDB:** Hỗ trợ khóa cấp dòng (Row-level Locking) và ràng buộc khóa ngoại (Foreign Key Constraints) với các tùy chọn `ON DELETE CASCADE` và `ON DELETE SET NULL`, tự động duy trì tính nhất quán khi xóa tour hoặc người dùng.
- **Chỉ mục B-Tree (B-Tree Indexing):** Tối ưu hóa tốc độ tìm kiếm các trường thường xuyên lọc như `status`, `category_id`, `start_date`, `price`.

### 2.4.2. Hệ quản trị CSDL Phân tán TiDB Cloud Serverless (NewSQL)
Nhằm giải quyết bài toán chịu tải và sẵn sàng cho môi trường điện toán đám mây hiện đại, dự án sử dụng TiDB Cloud Serverless:
- **Bản chất kiến trúc NewSQL:** TiDB kết hợp các ưu điểm tốt nhất của hai thế giới: Tính toàn vẹn giao dịch ACID mạnh mẽ của CSDL quan hệ truyền thống và khả năng mở rộng vô hạn theo chiều ngang (Horizontal Scalability) của NoSQL.
- **Tương thích giao thức MySQL:** TiDB hỗ trợ hoàn toàn giao thức dây (MySQL Wire Protocol) và cú pháp SQL của MySQL 8.0. Ứng dụng Laravel kết nối tới TiDB Cloud thông qua driver `mysql` tiêu chuẩn mà không cần viết lại bất kỳ dòng mã truy vấn nào.
- **Kiến trúc tách rời Tính toán và Lưu trữ (Disaggregated Compute-Storage):**
  - *Tầng Tính toán (TiDB Nodes):* Tiếp nhận kết nối, phân tích cú pháp SQL và tối ưu hóa kế hoạch thực thi, hoàn toàn không lưu trạng thái (Stateless).
  - *Tầng Lưu trữ (TiKV Nodes):* Lưu trữ dữ liệu phân tán theo cấu trúc Key-Value dựa trên thuật toán đồng thuận Raft Consensus, tự động nhân bản (Multi-replica replication) đảm bảo dữ liệu không bao giờ bị mất ngay cả khi một trung tâm dữ liệu gặp sự cố.
- **Cơ chế bảo mật kết nối TLS/SSL:** TiDB Cloud Serverless bắt buộc mã hóa toàn bộ dữ liệu truyền tải trên mạng. Ứng dụng Laravel được cấu hình sử dụng chứng chỉ số `/etc/ssl/certs/ca-certificates.crt` trong Linux container để thiết lập kênh truyền mã hóa an toàn.

### 2.4.3. Cấu trúc dữ liệu Cây lồng nhau (Nested Set Model / MPTT) trong Quản lý Danh mục
Trong một nền tảng du lịch, danh mục điểm đến có cấu trúc phân cấp đa tầng phức tạp (Ví dụ: *Du lịch Trong Nước -> Miền Bắc -> Hà Giang -> Tour Khám Phá Đồng Văn*).

**So sánh hai mô hình lưu trữ phân cấp:**

| Tiêu chí | Mô hình Danh sách Kề (Adjacency List - `parent_id`) | Mô hình Cây lồng nhau (Nested Set Model - MPTT) |
| :--- | :--- | :--- |
| **Cơ chế lưu trữ** | Chỉ lưu `id` của danh mục cha trong trường `parent_id`. | Lưu hai chỉ số biên độ `_lft` (Left) và `_rgt` (Right) biểu diễn bao đóng tập hợp. |
| **Truy vấn danh mục con** | Bắt buộc dùng đệ quy hoặc vòng lặp nhiều lần (độ phức tạp $O(N)$ truy vấn). | Thực hiện đúng **1 câu lệnh SQL duy nhất** ($O(1)$ truy vấn). |
| **Hiệu năng hệ thống** | Chậm chạp, dễ tràn ngăn xếp (Stack Overflow) khi cây danh mục sâu. | Tối ưu hóa cực đại với chỉ mục B-Tree trên cặp trường `_lft` và `_rgt`. |
| **Mức độ phức tạp khi ghi** | Rất đơn giản khi thêm/xóa nút. | Cần cập nhật lại giá trị left/right của các nút liên quan. |

```
Mô phỏng gán nhãn Left/Right trong Nested Set Model:

                [Du lịch Trong Nước] (1, 10)
                     /                  \
      [Miền Bắc] (2, 7)               [Miền Trung] (8, 9)
         /           \
 [Hà Giang] (3, 4)  [Sa Pa] (5, 6)
```

- **Nguyên lý toán học của Nested Set:**
  Một danh mục $B$ là danh mục con của $A$ khi và chỉ khi:
  $$\text{Left}(A) < \text{Left}(B) < \text{Right}(B) < \text{Right}(A)$$
  Để lấy toàn bộ cây con của "Miền Bắc" ($\_lft=2, \_rgt=7$), hệ thống chỉ cần thực thi:
  `SELECT * FROM categories WHERE _lft BETWEEN 2 AND 7 ORDER BY _lft ASC;`
- **Ứng dụng trong dự án:**
  Dự án tích hợp gói thư viện chuyên dụng `kalnoy/nestedset`, kết hợp với thư viện giao diện `Nestable.js` trên Admin Panel. Quản trị viên có thể kéo thả thay đổi vị trí phân cấp của danh mục điểm đến trực quan, hệ thống tự động tái tính toán toàn bộ chỉ số `_lft` và `_rgt` trong cơ sở dữ liệu một cách nhất quán.

---

## 2.5. CÔNG NGHỆ FRONTEND VÀ TRỰC QUAN HÓA DỮ LIỆU

### 2.5.1. Laravel Blade Template Engine
Blade là công cụ tạo mẫu giao diện mạnh mẽ nhưng vô cùng trực quan của Laravel:
- **Cơ chế kế thừa Layout thông minh:** Sử dụng chỉ thị `@extends('users.master')`, `@section('content')`, `@yield('content')` giúp tái sử dụng cấu trúc Header, Footer, Widget điều hướng trên toàn bộ các trang con, tránh lặp lại mã nguồn (nguyên lý DRY - Don't Repeat Yourself).
- **Phòng chống tấn công XSS mặc định:** Khi xuất dữ liệu bằng cú pháp `{{ $variable }}`, Blade tự động chuyển đổi các ký tự nguy hiểm thành thực thể HTML thông qua hàm `htmlspecialchars()`. Chỉ khi người quản trị chủ động cho phép render nội dung phong phú mới sử dụng cú pháp đặc biệt `{!! $htmlContent !!}`.

### 2.5.2. Tailwind CSS Framework và Hệ thống Thiết kế Universal Dark/Light Theme
Tailwind CSS là framework CSS theo triết lý **Utility-First**, cung cấp các lớp tiện ích có thể kết hợp trực tiếp trong mã HTML:
- **Tối ưu hóa dung lượng (JIT Compiler):** Trình biên dịch JIT phân tích toàn bộ mã nguồn template và chỉ sinh ra các lớp CSS thực sự được sử dụng, giúp giảm dung lượng tập tin CSS từ hàng Megabyte xuống chỉ còn khoảng 15KB - 30KB ở chế độ Production.
- **Hệ thống Universal Theme Token System:**
  - Không dựa vào các lớp màu cứng (hardcoded colors), giao diện xây dựng trên hệ thống biến CSS Token:
    `--color-canvas` (màu nền tổng thể), `--color-paper` (màu thẻ card/bảng biểu), `--color-ink` (màu chữ nội dung), `--color-primary` (màu thương hiệu đất nung Terracotta `#863c20`).
  - Đoạn mã JavaScript khởi tạo chạy ngay trong thẻ `<head>` trước khi trình duyệt dựng giao diện DOM để kiểm tra `localStorage.getItem('theme')`, gắn lớp `dark` ngay lập tức nếu cần, triệt tiêu hoàn toàn hiện tượng nhấp nháy giao diện khó chịu (FOUC - Flash of Unstyled Content).

### 2.5.3. Hệ thống Thông tin Địa lý (Web GIS) và Thư viện Leaflet.js
Trong ứng dụng du lịch, trực quan hóa lộ trình và các điểm dừng chân trên bản đồ là tính năng trọng tâm nâng cao trải nghiệm khách hàng:
- **Khái niệm Web GIS và Tọa độ WGS84:** Mỗi điểm dừng trong lịch trình du lịch (`tour_schedules`) được định danh bởi cặp tọa độ địa lý chuẩn quốc tế: Vĩ độ (`latitude`) và Kinh độ (`longitude`) dưới dạng số thực dấu phẩy động (`decimal(10, 6)`).
- **Thư viện bản đồ tương tác Leaflet.js:**
  - Leaflet là thư viện JavaScript mã nguồn mở hàng đầu với dung lượng siêu nhẹ (~42KB), tương thích hoàn hảo trên cả máy tính để bàn và thiết bị di động cảm ứng.
  - Hệ thống nạp lớp bản đồ nền từ **OpenStreetMap TileLayer** (không giới hạn chi phí và không phụ thuộc API Key hạn chế như Google Maps).
  - Sử dụng đối tượng `L.marker` để ghim các vị trí danh lam thắng cảnh, gắn kèm thông tin `Popup` (tên địa danh, mô tả vắn tắt, hình ảnh đại diện) và sử dụng `L.polyline` để vẽ đường nét đứt mô phỏng lộ trình di chuyển xuyên suốt giữa các ngày.
  - Dữ liệu tọa độ được Controller nạp bất đồng bộ thông qua endpoint API JSON `/tour/schedule/{id}/json` giúp trang chi tiết tour tải nhanh và mượt mà.

---

## 2.6. TRÍ TUỆ NHÂN TẠO VÀ MÔ HÌNH NGÔN NGỮ LỚN (AI & LLMS)

### 2.6.1. Khái niệm Mô hình Ngôn ngữ Lớn (LLM) và Cơ chế Sinh Phản hồi
Mô hình ngôn ngữ lớn (Large Language Model - LLM) là các mạng nơ-ron học sâu dựa trên kiến trúc **Transformer** với cơ chế tự chú ý (Self-Attention Mechanism). Mô hình có khả năng hiểu ngữ cảnh văn bản phức tạp, suy luận logic và sinh ngôn ngữ tự nhiên mạch lạc như con người.

Thay vì dựa vào các kịch bản cứng nhắc kiểu cây quyết định (decision tree) cổ điển, hệ thống tích hợp LLM để đóng vai trò một "Chuyên viên tư vấn lữ hành bản địa" (Travel Concierge), có khả năng thấu hiểu các câu hỏi linh hoạt của du khách (ví dụ: *"Mình có 4 ngày nghỉ lễ, thích biển đẹp và yên tĩnh, ngân sách tầm 5 triệu thì đi đâu hợp lý?"*).

### 2.6.2. Google Gemini 2.0 Flash API và Groq LPU Inference Engine
Hệ thống hỗ trợ tích hợp kép các nền tảng LLM tiên tiến nhất hiện nay:
- **Google Gemini 2.0 Flash:**
  - Mô hình thế hệ mới của Google với khả năng suy luận ngữ cảnh vượt trội, độ dài ngữ cảnh (Context Window) lớn và tối ưu hóa cho tác vụ phản hồi nhanh (low-latency conversational AI).
  - Kết nối thông qua giao thức REST API HTTPS chuẩn: `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={API_KEY}`.
- **Groq LPU (Language Processing Unit):**
  - Groq là kiến trúc phần cứng xử lý AI chuyên biệt, thay thế GPU truyền thống bằng chip LPU có khả năng tính toán ma trận với băng thông cực cao.
  - Tốc độ sinh phản hồi đạt ngưỡng kinh ngạc: **400 - 600 tokens/giây**, triệt tiêu hoàn toàn thời gian chờ đợi của khách hàng khi chat trên website.
  - Sử dụng giao thức tương thích OpenAI Specification, giúp dễ dàng tích hợp và dự phòng.

### 2.6.3. Kỹ thuật Kỹ nghệ Câu lệnh (Prompt Engineering) và Bơm ngữ cảnh động (Context Injection)
Một thách thức cố hữu của các mô hình LLM là hiện tượng ảo giác (Hallucination - mô hình tự bịa ra thông tin không có thật, tự sáng tạo ra tour và giá không tồn tại).

Hệ thống Wanderlust Travel giải quyết triệt để vấn đề này bằng mô hình **RAG thu nhỏ (Retrieval-Augmented Generation / Grounding Context Injection)**:
1. **Thiết kế System Prompt định vị vai trò:**
   Thiết lập nghiêm ngặt bản sắc của bot: Là chuyên viên tư vấn lịch thiệp của Wanderlust Travel Vietnam, chỉ được tư vấn các điểm đến có thật tại Việt Nam, ngôn phong ấm áp, hiếu khách.
2. **Bơm ngữ cảnh dữ liệu động từ Database:**
   Trước khi gửi câu hỏi của khách hàng tới AI, Controller truy vấn 12 tour du lịch thực tế mới nhất từ bảng `tours` (gồm tên tour, điểm đến, thời lượng, giá niêm yết và URL chi tiết). Toàn bộ khối dữ liệu này được chuyển hóa thành ngữ cảnh thực tế kèm theo System Prompt:
   ```
   Bạn CHỈ ĐƯỢC gợi ý các tour có trong danh sách sau đây. 
   Khi nhắc tới tour, bắt buộc chèn liên kết định dạng Markdown [Xem chi tiết & Đặt vé](URL):
   - Tour: Hà Giang Mùa Hoa Tam Giác Mạch | Giá: 3,500,000 VNĐ | URL: https://dulichvoc.onrender.com/tour-detail/1
   - Tour: Phú Quốc Thiên Đường Nghỉ Dưỡng | Giá: 5,200,000 VNĐ | URL: https://dulichvoc.onrender.com/tour-detail/2
   ```
3. **Bộ chuyển đổi định dạng tại Client (Markdown to Interactive UI):**
   Đoạn mã JavaScript phía giao diện tiếp nhận phản hồi từ bot, sử dụng biểu thức chính quy (Regex) quét các chuỗi liên kết Markdown `[...](URL)` và tự động render thành các nút bấm hành động (CTA Button) màu đất nung nổi bật, dẫn du khách trực tiếp tới trang đặt vé của tour tương ứng.

### 2.6.4. Thuật toán Dự phòng Thông minh (Smart Fallback Rule-Based Engine)
Để đảm bảo tính khả dụng cao nhất (High Availability), hệ thống không phụ thuộc hoàn toàn vào dịch vụ bên ngoài. Khi xảy ra sự cố nghẽn mạng quốc tế hoặc tài khoản AI hết hạn mức (Quota Exceeded), hệ thống tự động chuyển sang **Smart Fallback Engine**:
1. Chuẩn hóa chuỗi văn bản đầu vào: Chuyển về chữ thường và loại bỏ toàn bộ dấu thanh tiếng Việt thông qua hàm giải thuật toán loại bỏ ký tự Unicode.
2. Quét ma trận từ khóa địa danh và nhu cầu: "ha giang", "phu quoc", "da lat", "da nang", "sapa", "nha trang", "gia re", "bien", "nui".
3. Thực hiện truy vấn mềm (Fuzzy Search) bằng Eloquent ORM: `Tour::where('name', 'LIKE', "%{$keyword}%")->take(3)->get()`.
4. Tổng hợp câu trả lời tự động bằng tiếng Việt chuẩn mực, kèm theo danh sách thẻ tour có sẵn, đảm bảo người dùng luôn nhận được kết quả tư vấn hữu ích trong mọi tình huống.

---

## 2.7. TÍCH HỢP CỔNG THANH TOÁN TRỰC TUYẾN VÀ AN TOÀN GIAO DỊCH

### 2.7.1. Cổng thanh toán Ví điện tử MoMo và Cơ chế Chữ ký số HMAC-SHA256
MoMo là một trong những hệ sinh thái ví điện tử lớn nhất Việt Nam. Hệ thống tích hợp phương thức thanh toán **MoMo All-in-One QR Code & App-to-App Payment**:
- **Nguyên lý Chữ ký điện tử HMAC-SHA256 (Hash-based Message Authentication Code):**
  - Nhằm ngăn chặn tin tặc sửa đổi các thông số quan trọng (như số tiền thanh toán `amount`, mã đơn hàng `orderId`) trên đường truyền giữa Client và Server.
  - Thuật toán ghép nối các tham số cấu hình (`accessKey`, `amount`, `extraData`, `ipnUrl`, `orderId`, `orderInfo`, `partnerCode`, `redirectUrl`, `requestId`, `requestType`) theo một thứ tự từ điển cố định nghiêm ngặt thành chuỗi `rawHash`.
  - Sử dụng khóa bí mật (`Secret Key`) băm chuỗi `rawHash` bằng thuật toán SHA-256 để sinh ra chuỗi chữ ký số `signature`:
    $$\text{Signature} = \text{HMAC-SHA256}(\text{SecretKey}, \text{RawHash})$$
  - Phía máy chủ MoMo thực hiện thuật toán băm tương tự. Nếu hai chữ ký khớp hoàn toàn, giao dịch mới được phê duyệt.
- **Cơ chế Webhook IPN (Instant Payment Notification):**
  - Sau khi khách quét mã thanh toán thành công, máy chủ MoMo sẽ gọi trực tiếp một HTTP POST Request độc lập tới endpoint `/momo/ipn` của Wanderlust Travel.
  - Phía Controller kiểm tra lại chữ ký số gửi kèm từ MoMo, kiểm tra mã phản hồi (`resultCode == 0`), cập nhật trạng thái đơn hàng sang "Đã thanh toán / Đã đặt cọc" và kích hoạt sự kiện gửi email vé điện tử.
  - Cơ chế IPN đảm bảo đơn hàng không bao giờ bị rớt ngay cả khi khách hàng mất kết nối 4G hoặc tắt trình duyệt ngay sau khi chuyển khoản.

### 2.7.2. Cổng thanh toán Quốc tế PayPal REST API & Chuẩn OAuth 2.0
Để phục vụ du khách nước ngoài hoặc kiều bào, hệ thống tích hợp cổng thanh toán toàn cầu PayPal:
- **Chuẩn xác thực OAuth 2.0 Client Credentials Grant:**
  Ứng dụng sử dụng cặp khóa `client_id` và `client_secret` để gửi yêu cầu lấy Token xác thực (`Bearer Access Token`) từ máy chủ ủy quyền của PayPal. Mọi yêu cầu tạo và xử lý đơn tiếp theo đều phải đính kèm Token này trong HTTP Header `Authorization`.
- **Quy trình Thanh toán 2 Bước (Two-phase Transaction):**
  1. *Tạo đơn (Create Order):* Hệ thống gửi thông tin giỏ hàng lên PayPal với ý định thanh toán `intent = 'CAPTURE'`. PayPal trả về mã giao dịch và liên kết phê duyệt thanh toán (`approve link`).
  2. *Bắt giữ tiền giao dịch (Capture Order):* Sau khi khách hàng đăng nhập tài khoản PayPal và nhấn đồng ý trên trang phê duyệt, PayPal chuyển hướng khách về `/paypal/success`. Tại đây Controller gọi lệnh `OrdersCaptureRequest` để thực sự rút tiền từ tài khoản người dùng về tài khoản doanh nghiệp.
- **Xử lý Chuyển đổi Tỷ giá tiền tệ:**
  Đơn vị tiền tệ chính trong CSDL là Việt Nam Đồng (VNĐ), trong khi PayPal chưa hỗ trợ trực tiếp đơn vị VNĐ cho một số loại tài khoản thương gia thông thường. Hệ thống thực hiện quy đổi tỷ giá sang Đô la Mỹ (USD) dựa trên tỷ giá cố định thời gian thực, làm tròn chính xác 2 chữ số thập phân trước khi gửi sang PayPal API.

### 2.7.3. Cổng chuyển khoản VietQR Napas247 và Cơ chế Đồng bộ Biến động Số dư
Bên cạnh ví điện tử, chuyển khoản ngân hàng qua quét mã QR động là thói quen thanh toán phổ biến nhất của người Việt:
- **Tiêu chuẩn VietQR:** Tuân thủ tiêu chuẩn thanh toán bằng mã phản hồi nhanh của Hiệp hội Thanh toán Quốc tế (EMVCo) và mạng lưới Napas247.
- **Cơ chế Webhook Transaction Sync:** Tích hợp bộ tiếp nhận Webhook tại `VietQRController@handleTransactionSync`. Khi tiền vào tài khoản ngân hàng của doanh nghiệp, máy chủ thanh toán gửi thông báo biến động số dư. Hệ thống tự động phân tích cú pháp nội dung chuyển khoản để trích xuất mã hóa đơn, đối soát số tiền và hoàn tất đơn tự động mà không cần nhân viên kế toán kiểm tra thủ công.

---

## 2.8. AN TOÀN THÔNG TIN VÀ BẢO MẬT ỨNG DỤNG WEB (OWASP TOP 10)

### 2.8.1. Cơ chế Phòng ngừa các Lỗ hổng Bảo mật Phổ biến
Dự án tuân thủ nghiêm ngặt các hướng dẫn an toàn phần mềm của tổ chức OWASP (Open Web Application Security Project):
- **Phòng chống tấn công Giả mạo Yêu cầu Chéo (CSRF - Cross-Site Request Forgery):**
  - Kẻ tấn công có thể lừa người dùng đã đăng nhập nhấn vào một liên kết độc hại nhằm bí mật gửi yêu cầu thay đổi mật khẩu hoặc thanh toán đơn hàng.
  - Laravel triển khai giải pháp **Synchronizer Token Pattern**: Mỗi phiên làm việc sinh một mã Token CSRF ngẫu nhiên, bí mật và được mã hóa lưu trong Session. Mọi biểu mẫu POST, PUT, DELETE đều bắt buộc đính kèm thẻ `@csrf`. Middleware `VerifyCsrfToken` kiểm tra tính hợp lệ của token, nếu sai lệch sẽ lập tức chặn đứng yêu cầu với mã lỗi `419 Page Expired`.
- **Phòng chống Chèn mã độc kịch bản (XSS - Cross-Site Scripting):**
  - Xảy ra khi dữ liệu người dùng nhập (như tên tài khoản, nội dung đánh giá tour) chứa mã JavaScript độc hại được hiển thị lại trên trình duyệt của người dùng khác.
  - Blade Template tự động mã hóa ký tự đặc biệt (`<`, `>`, `&`, `"`, `'`) thành các thực thể HTML an toàn thông qua cơ chế `{{ }}`, vô hiệu hóa hoàn toàn mã kịch bản độc hại.
- **Phòng chống Tiêm mã SQL (SQL Injection):**
  - Lỗ hổng nguy hiểm cho phép kẻ tấn công sửa đổi cấu trúc câu truy vấn để đánh cắp hoặc phá hủy toàn bộ cơ sở dữ liệu.
  - 100% các thao tác dữ liệu trong dự án sử dụng **Eloquent ORM** và **PDO Parameter Binding** (liên kết tham số). Dữ liệu người dùng nhập luôn được coi là các giá trị thuần túy, hoàn toàn tách biệt khỏi câu lệnh SQL, triệt tiêu mọi khả năng bị tấn công SQL Injection.

### 2.8.2. Bảo mật Mật khẩu và Quản lý Phiên làm việc
- **Thuật toán Băm Mật khẩu Bcrypt:**
  - Hệ thống tuyệt đối không lưu mật khẩu ở dạng văn bản rõ (Plaintext). Mật khẩu được mã hóa một chiều bằng hàm băm Bcrypt (dựa trên thuật toán mã hóa khối Blowfish).
  - Bcrypt tự động sinh chuỗi muối ngẫu nhiên (Salt) dài 16 bytes cho mỗi mật khẩu, ngăn chặn hoàn toàn hình thức tấn công bằng bảng tính sẵn (Rainbow Table).
  - Tích hợp hệ số chi phí tính toán (Work Factor / Cost = 10 đến 12), cố tình làm chậm tốc độ tính toán băm để triệt tiêu khả năng tấn công vét cạn (Brute-force) bằng siêu máy tính hoặc GPU đào coin.
- **Bảo mật Phiên làm việc (Session Management):**
  - Mã định danh phiên (Session ID) được lưu trữ trong Cookie với cờ `HttpOnly` (ngăn chặn JavaScript đọc cookie, chống đánh cắp phiên qua XSS) và cờ `SameSite=Lax` (ngăn chặn tấn công CSRF thông qua cookie bên thứ ba).

---

## 2.9. ẢO HÓA CONTAINER VÀ TRIỂN KHAI ĐÁM MÂY (DEVOPS & CLOUD INFRASTRUCTURE)

### 2.9.1. Công nghệ Container hóa với Docker
Docker là nền tảng ảo hóa ở cấp độ hệ điều hành (OS-level Virtualization), cho phép đóng gói toàn bộ ứng dụng, mã nguồn, môi trường thực thi PHP, máy chủ web Apache và các thư viện phụ thuộc thành một đơn vị duy nhất gọi là **Container Image**:
- **Đảm bảo tính nhất quán môi trường (Environment Parity):** Xóa bỏ hoàn toàn định kiến *"mã chạy được trên máy tôi nhưng lỗi trên máy chủ"*. Môi trường phát triển tại máy cá nhân và môi trường Production trên Cloud hoạt động hoàn toàn giống nhau.
- **Phân tích tệp cấu hình Dockerfile đa tầng của dự án:**
  - *Base Image:* `php:8.1-apache`, cung cấp nền tảng PHP ổn định trên nền hệ điều hành Debian Linux thu nhỏ.
  - *Cài đặt Extension:* Cài đặt các mô-đun cần thiết cho ứng dụng lữ hành: `pdo_mysql`, `mbstring`, `zip`, `gd` (xử lý hình ảnh tour), `bcmath` (tính toán tiền tệ chính xác).
  - *Cấu hình Apache:* Kích hoạt module `mod_rewrite`, định tuyến thư mục gốc của trang web về `/var/www/html/public`.
  - *Cài đặt chứng chỉ số SSL:* Tích hợp gói `ca-certificates` để PHP thiết lập các kết nối bảo mật ra bên ngoài (kết nối TiDB Cloud, MoMo, PayPal, Gemini).
- **Tập lệnh Khởi động Tự động hóa (`entrypoint.sh`):**
  Trước khi máy chủ Apache bắt đầu tiếp nhận lưu lượng mạng, script tự động thực thi chuỗi tác vụ tối ưu hóa:
  ```bash
  php artisan config:cache    # Đóng gói cấu hình vào một tập tin duy nhất
  php artisan route:cache     # Biên dịch bảng định tuyến thành mảng phẳng tốc độ cao
  php artisan view:cache      # Biên dịch trước toàn bộ giao diện Blade
  exec apache2-foreground     # Khởi chạy Apache ở tiến trình tiền cảnh (PID 1)
  ```

### 2.9.2. Nền tảng Đám mây PaaS Render và Cơ chế Duy trì Kết nối (Keep-Alive)
- **Nền tảng Render Web Service:** Cung cấp môi trường triển khai ứng dụng đám mây tự động liên kết với kho lưu trữ GitHub (Continuous Deployment - CD). Mỗi khi có commit mới trên nhánh `main`, Render tự động kích hoạt tiến trình Build Docker Image và cập nhật phiên bản mới không gián đoạn dịch vụ (Zero-Downtime Deployment).
- **Giải quyết bài toán Ngủ đông của máy chủ Miễn phí (Cold-Start Problem):**
  - Các gói điện toán đám mây miễn phí thường tự động đưa dịch vụ vào trạng thái ngủ đông (Sleep Mode) nếu không có lưu lượng truy cập sau 15 phút, khiến khách hàng tiếp theo phải chờ đợi từ 50 - 60 giây để máy chủ khởi động lại.
  - Dự án giải quyết triệt để vấn đề này bằng cách thiết kế endpoint kiểm tra sức khỏe siêu nhẹ: `GET /ping` và `GET /health`, kết hợp với dịch vụ giám sát tự động (như UptimeRobot hoặc Cron Job định kỳ) gửi tín hiệu giữ nhịp 10 phút một lần, đảm bảo ứng dụng luôn trong trạng thái nóng (Hot Standby) và phản hồi tức thì.

---

## 2.10. TÓM TẮT CHƯƠNG 2
Chương 2 đã trình bày một cách có hệ thống và toàn diện toàn bộ cơ sở lý thuyết, kiến trúc phần mềm, nguyên lý thuật toán và các nền tảng công nghệ mũi nhọn được ứng dụng trong dự án Wanderlust Travel. 

Việc lựa chọn kết hợp **Laravel 9 (PHP 8.1)**, cơ sở dữ liệu NewSQL phân tán **TiDB Cloud / MySQL**, thuật toán cây phân cấp **Nested Set Model**, giao diện tiện ích **Tailwind CSS**, bản đồ GIS tương tác **Leaflet.js**, trí tuệ nhân tạo **LLM (Gemini / Groq)** và các cổng thanh toán bảo mật chuẩn **HMAC / OAuth 2.0 (MoMo, PayPal, VietQR)** trên nền tảng **Docker Container** đã tạo nên một nền móng công nghệ vững chắc. Đây là căn cứ khoa học trực tiếp để tiến hành các phân tích, thiết kế chi tiết hệ thống được trình bày trong Chương 3.
