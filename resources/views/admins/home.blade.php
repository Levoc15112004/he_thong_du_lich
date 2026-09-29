@extends('admins.master')

@section('home')
    <style>
        .dashboard-card {
            background-color: white;
        }
        .dashboard-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
    </style>
    
    <div class="content-wrapper bg-slate-50 min-h-screen">
      <main class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-8 max-w-[120rem] mx-auto">
        <!-- KPI Statistics Row: 4 Metric Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          
          <!-- KPI 1: Doanh thu -->
          <div class="dashboard-card dashboard-card-hover rounded-2xl p-5 relative overflow-hidden border border-slate-100 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tổng Doanh Thu</span>
              <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-coins"></i>
              </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
              <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}<span class="text-sm font-bold text-slate-500 ml-1">đ</span></h3>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs">
              <span class="inline-flex items-center {{ ($revenueChange ?? 0) >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} font-bold px-2 py-0.5 rounded-md">
                <i class="fa-solid {{ ($revenueChange ?? 0) >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1 text-[10px]"></i> {{ abs($revenueChange ?? 0) }}%
              </span>
              <span class="text-slate-400">so với tháng trước</span>
            </div>
          </div>

          <!-- KPI 2: Tổng số lượt đặt chỗ -->
          <div class="dashboard-card dashboard-card-hover rounded-2xl p-5 relative overflow-hidden border border-slate-100 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Đơn Tháng Này</span>
              <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-ticket"></i>
              </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
              <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ $todayOrders ?? 0 }}<span class="text-sm font-bold text-slate-500 ml-1">đơn</span></h3>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs">
              <span class="inline-flex items-center {{ ($orderChange ?? 0) >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} font-bold px-2 py-0.5 rounded-md">
                <i class="fa-solid {{ ($orderChange ?? 0) >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1 text-[10px]"></i> {{ abs($orderChange ?? 0) }}%
              </span>
              <span class="text-slate-400">so với tháng trước</span>
            </div>
          </div>

          <!-- KPI 3: Khách hàng mới -->
          <div class="dashboard-card dashboard-card-hover rounded-2xl p-5 relative overflow-hidden border border-slate-100 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tổng Người Dùng</span>
              <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-user-plus"></i>
              </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
              <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ $totalUsers ?? 0 }}<span class="text-sm font-bold text-slate-500 ml-1">người</span></h3>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs">
              <span class="inline-flex items-center {{ ($userChange ?? 0) >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} font-bold px-2 py-0.5 rounded-md">
                <i class="fa-solid {{ ($userChange ?? 0) >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1 text-[10px]"></i> {{ abs($userChange ?? 0) }}%
              </span>
              <span class="text-slate-400">so với tháng trước</span>
            </div>
          </div>

          <!-- KPI 4: Tỷ lệ lấp đầy tour -->
          <div class="dashboard-card dashboard-card-hover rounded-2xl p-5 relative overflow-hidden border border-slate-100 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Lượt Truy Cập</span>
              <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-eye"></i>
              </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
              <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">{{ $views ?? 0 }}<span class="text-sm font-bold text-slate-500 ml-1">lượt</span></h3>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs">
              <span class="inline-flex items-center {{ ($viewChange ?? 0) >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} font-bold px-2 py-0.5 rounded-md">
                <i class="fa-solid {{ ($viewChange ?? 0) >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} mr-1 text-[10px]"></i> {{ abs($viewChange ?? 0) }}%
              </span>
              <span class="text-slate-400">so với tháng trước</span>
            </div>
          </div>

        </section>

        <!-- Advanced Multi-Metric Analytics Section -->
        <section class="space-y-6">
          
          <!-- Main Chart: Doanh Thu, Đơn Hàng & Người Dùng Mới với Bộ Lọc Chuyển Tab -->
          <div class="dashboard-card rounded-3xl p-6 lg:p-7 shadow-sm border border-slate-200/80">
            
            <!-- Top Controls: Tab Chỉ số & Bộ Lọc Thời Gian -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5 pb-6 border-b border-slate-100">
              
              <!-- Metric Switcher Tabs -->
              <div class="flex flex-wrap items-center gap-2" id="metricTabs">
                <button onclick="switchAnalyticsMetric('revenue')" id="tabBtnRevenue" class="metric-tab active px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-all duration-200 bg-emerald-500 text-white shadow-md shadow-emerald-500/25 flex items-center gap-2">
                  <i class="fa-solid fa-coins"></i>
                  <span>Doanh Thu & Lợi Nhuận</span>
                </button>
                <button onclick="switchAnalyticsMetric('bookings')" id="tabBtnBookings" class="metric-tab px-4 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center gap-2">
                  <i class="fa-solid fa-receipt"></i>
                  <span>Đơn Đặt Tour & Giữ Chỗ</span>
                </button>
                <button onclick="switchAnalyticsMetric('users')" id="tabBtnUsers" class="metric-tab px-4 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center gap-2">
                  <i class="fa-solid fa-user-check"></i>
                  <span>Tài Khoản Đăng Ký & Người Dùng</span>
                </button>
              </div>

              <!-- Timeframe & Export Controls -->
              <div class="flex items-center gap-3 self-start xl:self-auto">
                <div class="inline-flex p-1 bg-slate-100/90 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600">
                  <button onclick="setTimeRange('7d', this)" class="timerange-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-colors">7 Ngày</button>
                  <button onclick="setTimeRange('30d', this)" class="timerange-btn active px-3 py-1.5 rounded-lg bg-white text-emerald-700 font-bold shadow-xs transition-colors">30 Ngày</button>
                  <button onclick="setTimeRange('9m', this)" class="timerange-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-colors">Cả năm</button>
                </div>

                <button onclick="showToast('Đang kết xuất biểu đồ báo cáo định dạng PNG...', 'info')" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors" title="Tải ảnh biểu đồ">
                  <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                </button>
              </div>
            </div>

            <!-- Mini Summary Highlights Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-5 border-b border-slate-100 text-xs">
              <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60">
                <span class="text-slate-400 block font-semibold" id="highlightLabel1">Tổng giá trị</span>
                <span class="text-lg font-bold text-slate-900 mt-1 block" id="highlightVal1">2.48 Tỷ VNĐ</span>
                <span class="text-[11px] text-emerald-600 font-bold flex items-center gap-1 mt-0.5">
                  <i class="fa-solid fa-arrow-trend-up"></i> +18.4% tốc độ
                </span>
              </div>
              <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60">
                <span class="text-slate-400 block font-semibold" id="highlightLabel2">Điểm cao nhất</span>
                <span class="text-lg font-bold text-slate-900 mt-1 block" id="highlightVal2">3.50 Tỷ</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-0.5">Mùa cao điểm hè</span>
              </div>
              <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60">
                <span class="text-slate-400 block font-semibold" id="highlightLabel3">Trung bình</span>
                <span class="text-lg font-bold text-slate-900 mt-1 block" id="highlightVal3">82.6 Triệu</span>
                <span class="text-[11px] text-cyan-600 font-bold mt-0.5">Đạt 108% mục tiêu</span>
              </div>
              <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60">
                <span class="text-slate-400 block font-semibold" id="highlightLabel4">Tỷ lệ hoàn tất</span>
                <span class="text-lg font-bold text-emerald-600 mt-1 block" id="highlightVal4">94.8%</span>
                <span class="text-[11px] text-slate-500 font-semibold mt-0.5">Tỷ lệ hủy chỉ 5.2%</span>
              </div>
            </div>

            <!-- Dynamic Chart Canvas Container -->
            <div class="relative mt-5">
              <div class="h-80 sm:h-96 w-full">
                <canvas id="primaryAnalyticsChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Two Side-by-Side Detailed Breakdown Charts -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Secondary Chart 1: Phân bổ nguồn người dùng & Thiết bị truy cập -->
            <div class="dashboard-card rounded-3xl p-6 flex flex-col justify-between border border-slate-200/80 shadow-sm">
              <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                  <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Nguồn Khách Hàng</h3>
                    <p class="text-xs text-slate-500">Tỷ lệ chuyển đổi người dùng thành viên</p>
                  </div>
                  <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">
                    <i class="fa-solid fa-users-viewfinder"></i>
                  </span>
                </div>

                <div class="relative h-60 flex items-center justify-center my-4">
                  <canvas id="userSourceChart"></canvas>
                  <!-- Center cutout stat -->
                  <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tổng User</span>
                    <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ number_format($totalUsers ?? 0) }}</span>
                    <span class="text-[10px] text-emerald-600 font-extrabold">+{{ abs($userChange ?? 0) }}% tháng này</span>
                  </div>
                </div>
              </div>

              <!-- Legend detail tags -->
              <div class="grid grid-cols-2 gap-2 text-xs pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50">
                  <span class="flex items-center gap-2 text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Trực tiếp Web
                  </span>
                  <strong class="text-slate-900">48%</strong>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50">
                  <span class="flex items-center gap-2 text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span> Mobile Web
                  </span>
                  <strong class="text-slate-900">28%</strong>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50">
                  <span class="flex items-center gap-2 text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span> Mạng xã hội
                  </span>
                  <strong class="text-slate-900">16%</strong>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50">
                  <span class="flex items-center gap-2 text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Giới thiệu
                  </span>
                  <strong class="text-slate-900">8%</strong>
                </div>
              </div>
            </div>

            <!-- Secondary Chart 2: Tăng Trưởng Tài Khoản & Người Dùng Kích Hoạt Đặt Tour -->
            <div class="dashboard-card rounded-3xl p-6 lg:col-span-2 flex flex-col justify-between border border-slate-200/80 shadow-sm">
              <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                  <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Tốc Độ Tạo Tài Khoản Mới & Đặt Tour Lần Đầu</h3>
                    <p class="text-xs text-slate-500">Theo dõi phễu kích hoạt (Signups vs First-Time Bookers)</p>
                  </div>
                  <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1.5 text-xs text-slate-600 font-semibold">
                      <span class="w-3 h-3 rounded-md bg-emerald-500"></span> Đăng ký tài khoản
                    </span>
                    <span class="flex items-center gap-1.5 text-xs text-slate-600 font-semibold">
                      <span class="w-3 h-3 rounded-md bg-cyan-400"></span> Đặt tour đầu tiên
                    </span>
                  </div>
                </div>

                <div class="h-64 sm:h-72 mt-4">
                  <canvas id="userGrowthBarChart"></canvas>
                </div>
              </div>

              <!-- Bottom Key Metric Footnote -->
              <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1.5">
                  <i class="fa-solid fa-lightbulb text-amber-500"></i>
                  Tỷ lệ chuyển đổi từ đăng ký sang đặt tour đạt mức <strong>64.2%</strong>
                </span>
                <button onclick="showToast('Xuất danh sách phân tích nhóm người dùng mới...', 'info')" class="text-emerald-600 font-bold hover:underline flex items-center gap-1">
                  Xem chi tiết phễu <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
              </div>
            </div>

          </div>
        </section>

        <!-- Top Tours Performance -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          
          <div class="dashboard-card rounded-2xl p-6 lg:col-span-2 shadow-sm border border-slate-200/80">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
              <div>
                <h3 class="text-base font-bold text-slate-900">Top Tour Được Quan Tâm & Lượt Xem</h3>
                <p class="text-xs text-slate-500">Giám sát mức độ phổ biến các tour trọng điểm</p>
              </div>
            </div>

            <!-- Tour Slots List -->
            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 no-scrollbar">
              @if(isset($topViewedTours) && count($topViewedTours) > 0)
                  @foreach ($topViewedTours as $tour)
                  <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                      <img src="{{ Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image) }}" alt="{{ $tour->name }}" class="w-14 h-14 rounded-xl object-cover">
                      <div>
                        <h4 class="font-bold text-slate-900 text-sm max-w-[200px] sm:max-w-[300px] truncate" title="{{ $tour->name }}">{{ $tour->name }}</h4>
                        <p class="text-xs text-slate-500">Giá: <span class="font-bold text-emerald-600">{{ number_format($tour->sale_price ?? $tour->price ?? 0, 0, ',', '.') }}đ</span></p>
                      </div>
                    </div>
                    <div class="w-full sm:w-48 text-right sm:text-left">
                      <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-semibold text-slate-600">Lượt xem</span>
                        <span class="font-bold text-emerald-600"><i class="fa-solid fa-eye text-[10px] mr-1"></i>{{ number_format($tour->view_count ?? 0) }}</span>
                      </div>
                      <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, (($tour->view_count ?? 0) / 100)) }}%"></div>
                      </div>
                    </div>
                    <div class="flex items-center gap-2">
                      <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">HOT</span>
                      <a href="{{ route('admin.tours.edit', $tour->id) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                      </a>
                    </div>
                  </div>
                  @endforeach
              @else
                  <div class="text-center p-8 text-slate-500">Chưa có dữ liệu tour</div>
              @endif
            </div>
          </div>

          <div class="dashboard-card rounded-2xl p-6 flex flex-col justify-between shadow-sm border border-slate-200/80">
            <div>
              <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-base font-bold text-slate-900">Bài Viết Mới Nhất</h3>
                <span class="text-xs text-blue-500 font-bold flex items-center gap-1">
                  <i class="fa-solid fa-newspaper text-[12px]"></i> Blog
                </span>
              </div>

              <!-- Blogs Feed -->
              <div class="space-y-4">
                  @if(isset($latestBlogs) && count($latestBlogs) > 0)
                      @foreach ($latestBlogs as $blog)
                      <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center justify-between mb-1.5">
                          <div class="flex items-center gap-2 flex-1">
                            <span class="font-bold text-slate-800 text-xs truncate max-w-[200px]" title="{{ $blog->title }}">{{ $blog->title ?? 'Không có tiêu đề' }}</span>
                          </div>
                        </div>
                        <div class="flex justify-between items-center mt-2 border-t border-slate-100 pt-2">
                          <span class="text-[10px] text-slate-400"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</span>
                          <span class="px-2 py-0.5 rounded-lg text-[10px] font-semibold {{ $blog->status == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $blog->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                          </span>
                        </div>
                      </div>
                      @endforeach
                  @else
                      <div class="text-center p-4 text-slate-500 text-xs">Chưa có bài viết nào</div>
                  @endif
              </div>
            </div>

            <a href="{{ route('blog.index') }}" class="w-full mt-4 py-2.5 block rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all text-center">
              Quản Lý Kho Bài Viết
            </a>
          </div>

        </section>

      </main>
    </div>

  <!-- Toast Notification Container -->
  <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // System Data Injection
    const dbMonthlyRevenue = @json($monthlyRevenue ?? []);
    let lblRev = [];
    let dtaRev = [];
    if(dbMonthlyRevenue.length > 0) {
        lblRev = dbMonthlyRevenue.map(item => item.month + '/' + item.year);
        dtaRev = dbMonthlyRevenue.map(item => item.total);
    } else {
        lblRev = ['01/09', '05/09', '09/09', '13/09', '17/09', '21/09', '25/09', '29/09'];
        dtaRev = [280000000, 390000000, 310000000, 480000000, 560000000, 490000000, 620000000, 680000000];
    }
    const tgtRev = dtaRev.map(v => v * 0.85);

    let chartInstanceMain = null;
    let chartInstanceUserSource = null;
    let chartInstanceUserGrowth = null;
    let activeAnalyticsMetric = 'revenue';
    let currentPeriod = '30d';

    const analyticsDataset = {
      revenue: {
        labels: lblRev,
        dataset1Label: 'Doanh thu thực thu (VNĐ)',
        dataset2Label: 'Kế hoạch chỉ tiêu (VNĐ)',
        data1: dtaRev,
        data2: tgtRev,
        unit: ' đ',
        color1: '#10b981',
        color2: '#06b6d4',
        h1: '{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} VNĐ',
        h2: '-',
        h3: '-',
        h4: '100%',
        lbl1: 'Tổng giá trị doanh thu',
        lbl2: 'Đỉnh doanh thu kỳ',
        lbl3: 'Trung bình',
        lbl4: 'Tỷ lệ tăng trưởng'
      },
      bookings: {
        labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
        dataset1Label: 'Số đơn đặt hoàn tất',
        dataset2Label: 'Số đơn giữ chỗ chờ duyệt',
        data1: [142, 185, 160, 245],
        data2: [25, 30, 22, 40],
        unit: ' đơn',
        color1: '#059669',
        color2: '#f59e0b',
        h1: '{{ $todayOrders ?? 0 }} Đơn',
        h2: '-',
        h3: '-',
        h4: '88.5%',
        lbl1: 'Tổng lượt đặt tour tháng',
        lbl2: 'Kỷ lục đơn',
        lbl3: 'Tần suất đơn hàng',
        lbl4: 'Tỷ lệ lấp đầy chỗ'
      },
      users: {
        labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
        dataset1Label: 'Tài khoản đăng ký mới',
        dataset2Label: 'Người dùng hoạt động mỗi ngày',
        data1: [95, 130, 115, 180],
        data2: [540, 680, 620, 890],
        unit: ' user',
        color1: '#0284c7',
        color2: '#10b981',
        h1: '{{ $totalUsers ?? 0 }} User',
        h2: '-',
        h3: '-',
        h4: '64.2%',
        lbl1: 'Tổng cộng tài khoản',
        lbl2: 'Đăng ký mới cao nhất',
        lbl3: 'Lượng truy cập hằng ngày',
        lbl4: 'Chuyển đổi đăng ký'
      }
    };

    window.addEventListener('DOMContentLoaded', () => {
      initModernCharts();
    });

    function initModernCharts() {
      renderMainAnalyticsChart(activeAnalyticsMetric);

      const ctxSource = document.getElementById('userSourceChart');
      if (ctxSource) {
        chartInstanceUserSource = new Chart(ctxSource, {
          type: 'doughnut',
          data: {
            labels: ['Mobile App/Web', 'Web Trực Tiếp', 'Mạng Xã Hội', 'Khác'],
            datasets: [{
              data: [48, 28, 16, 8],
              backgroundColor: ['#10b981', '#14b8a6', '#06b6d4', '#f59e0b'],
              hoverBackgroundColor: ['#059669', '#0d9488', '#0891b2', '#d97706'],
              borderWidth: 3,
              borderColor: '#ffffff',
              hoverOffset: 6
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: '#0f172a',
                padding: 12,
                cornerRadius: 12,
                titleFont: { size: 12, weight: 'bold' },
                bodyFont: { size: 12 },
              }
            },
            cutout: '76%'
          }
        });
      }

      const ctxGrowth = document.getElementById('userGrowthBarChart');
      if (ctxGrowth) {
        chartInstanceUserGrowth = new Chart(ctxGrowth, {
          type: 'bar',
          data: {
            labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
            datasets: [
              {
                label: 'Đăng ký mới',
                data: [320, 450, 520, 610, 780],
                backgroundColor: 'rgba(16, 185, 129, 0.85)',
                borderRadius: 8,
              },
              {
                label: 'Khách đơn đầu',
                data: [195, 290, 340, 410, 525],
                backgroundColor: 'rgba(6, 182, 212, 0.75)',
                borderRadius: 8,
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
              y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
              x: { grid: { display: false } }
            }
          }
        });
      }
    }

    function renderMainAnalyticsChart(metricKey) {
      const canvas = document.getElementById('primaryAnalyticsChart');
      if (!canvas) return;

      const ctx = canvas.getContext('2d');
      const dataInfo = analyticsDataset[metricKey] || analyticsDataset.revenue;

      if (chartInstanceMain) {
        chartInstanceMain.destroy();
      }

      const gradientPrimary = ctx.createLinearGradient(0, 0, 0, 360);
      gradientPrimary.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
      gradientPrimary.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

      const gradientSecondary = ctx.createLinearGradient(0, 0, 0, 360);
      gradientSecondary.addColorStop(0, 'rgba(6, 182, 212, 0.25)');
      gradientSecondary.addColorStop(1, 'rgba(6, 182, 212, 0.0)');

      chartInstanceMain = new Chart(ctx, {
        type: 'line',
        data: {
          labels: dataInfo.labels,
          datasets: [
            {
              label: dataInfo.dataset1Label,
              data: dataInfo.data1,
              borderColor: dataInfo.color1,
              backgroundColor: gradientPrimary,
              fill: true,
              tension: 0.42,
              borderWidth: 3,
              pointBackgroundColor: '#ffffff',
              pointBorderColor: dataInfo.color1,
              pointRadius: 4,
            },
            {
              label: dataInfo.dataset2Label,
              data: dataInfo.data2,
              borderColor: dataInfo.color2,
              backgroundColor: gradientSecondary,
              fill: true,
              tension: 0.42,
              borderWidth: 2.5,
              borderDash: [5, 5],
              pointBackgroundColor: '#ffffff',
              pointBorderColor: dataInfo.color2,
              pointRadius: 3.5,
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { position: 'top', align: 'end' },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return ` ${context.dataset.label}: ${new Intl.NumberFormat('vi-VN').format(context.raw)}${dataInfo.unit}`;
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                 callback: function(value) {
                    if(value >= 1000000) return (value / 1000000) + ' M';
                    return value;
                 }
              }
            },
            x: { grid: { display: false } }
          }
        }
      });

      updateHighlightStats(dataInfo);
    }

    function switchAnalyticsMetric(metricKey) {
      activeAnalyticsMetric = metricKey;
      const tabMap = { revenue: 'tabBtnRevenue', bookings: 'tabBtnBookings', users: 'tabBtnUsers' };

      document.querySelectorAll('.metric-tab').forEach(btn => {
        btn.classList.remove('active', 'bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/25');
        btn.classList.add('bg-slate-100', 'text-slate-600');
      });

      const activeBtn = document.getElementById(tabMap[metricKey]);
      if (activeBtn) {
        activeBtn.classList.add('active', 'bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/25');
        activeBtn.classList.remove('bg-slate-100', 'text-slate-600');
      }

      renderMainAnalyticsChart(metricKey);
    }

    function updateHighlightStats(info) {
      if(document.getElementById('highlightVal1')) document.getElementById('highlightVal1').textContent = info.h1;
      if(document.getElementById('highlightVal2')) document.getElementById('highlightVal2').textContent = info.h2;
      if(document.getElementById('highlightVal3')) document.getElementById('highlightVal3').textContent = info.h3;
      if(document.getElementById('highlightVal4')) document.getElementById('highlightVal4').textContent = info.h4;
      if(document.getElementById('highlightLabel1')) document.getElementById('highlightLabel1').textContent = info.lbl1;
      if(document.getElementById('highlightLabel2')) document.getElementById('highlightLabel2').textContent = info.lbl2;
      if(document.getElementById('highlightLabel3')) document.getElementById('highlightLabel3').textContent = info.lbl3;
      if(document.getElementById('highlightLabel4')) document.getElementById('highlightLabel4').textContent = info.lbl4;
    }

    function setTimeRange(range, btn) {
      currentPeriod = range;
      document.querySelectorAll('.timerange-btn').forEach(b => b.classList.remove('active', 'bg-white', 'text-emerald-700', 'font-bold', 'shadow-xs'));
      if (btn) btn.classList.add('active', 'bg-white', 'text-emerald-700', 'font-bold', 'shadow-xs');
      renderMainAnalyticsChart(activeAnalyticsMetric);
    }

    function showToast(message, type = 'info') {
      const container = document.getElementById('toastContainer');
      if (!container) return;
      const toast = document.createElement('div');
      toast.className = 'pointer-events-auto px-4 py-3 rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200 text-slate-800 text-xs font-semibold shadow-xl flex items-center gap-3 transform translate-y-3 opacity-0 transition-all duration-300';
      toast.innerHTML = `<span>${message}</span>`;
      container.appendChild(toast);
      requestAnimationFrame(() => toast.classList.remove('translate-y-3', 'opacity-0'));
      setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
      }, 3500);
    }
  </script>
@endsection
