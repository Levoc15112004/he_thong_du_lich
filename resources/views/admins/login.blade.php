<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WanderVibe - Đăng Nhập Cổng Quản Trị & Điều Hành Tour</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome Icons 6.5.1 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#f0fdf4',
              100: '#dcfce7',
              200: '#bbf7d0',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
            }
          },
          animation: {
            'float-slow': 'floatSlow 6s ease-in-out infinite alternate',
            'pulse-soft': 'pulseSoft 4s ease-in-out infinite',
          },
          keyframes: {
            floatSlow: {
              '0%': { transform: 'translateY(0px)' },
              '100%': { transform: 'translateY(-10px)' },
            },
            pulseSoft: {
              '0%, 100%': { opacity: 0.7, transform: 'scale(1)' },
              '50%': { opacity: 1, transform: 'scale(1.04)' },
            }
          }
        }
      }
    }
  </script>

  <style>
    body {
      background-color: #0f172a;
    }

    /* Kính mờ bề mặt cao cấp nổi trên nền ảnh */
    .glass-card {
      background: rgba(15, 23, 42, 0.78);
      backdrop-filter: blur(32px);
      -webkit-backdrop-filter: blur(32px);
      border: 1px solid rgba(255, 255, 255, 0.16);
      box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.65), 0 0 50px -10px rgba(16, 185, 129, 0.22);
    }

    /* Input focus glow animation */
    .input-field {
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .input-field:focus {
      background-color: rgba(255, 255, 255, 0.14);
      border-color: #10b981;
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2), 0 10px 20px -5px rgba(0, 0, 0, 0.3);
    }

    /* Viền gradient tinh tế */
    .gradient-border-box {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(6, 182, 212, 0.08));
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
  </style>
</head>

<body class="h-full text-white antialiased font-sans flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

  <!-- Hình nền phong cảnh tràn toàn bộ màn hình chất lượng cao -->
  <div class="fixed inset-0 z-0">
    <img 
      src="https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=2400&q=85" 
      alt="WanderVibe Vietnam Background" 
      class="w-full h-full object-cover object-center filter brightness-[0.52] contrast-[1.08] scale-105 transform animate-pulse-soft"
    >
    <!-- Lớp phủ Gradient đa tầng điện ảnh bảo đảm độ tương phản chữ -->
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/65 to-slate-950/75"></div>
    <div class="absolute inset-0 bg-radial-gradient from-emerald-500/12 via-transparent to-transparent pointer-events-none"></div>
  </div>

  <!-- Ambient Light Orbs phát sáng nhẹ nhàng phía sau form -->
  <div class="fixed -top-24 -left-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="fixed -bottom-24 -right-24 w-[450px] h-[450px] bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

  <!-- Form đăng nhập trung tâm dành riêng cho Quản Trị Viên -->
  <div class="w-full max-w-[440px] glass-card rounded-3xl p-7 sm:p-9 relative z-10 my-auto">
    
    <!-- Top Brand Logo & Header -->
    <div class="text-center mb-6">
      <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-500 items-center justify-center text-white shadow-xl shadow-emerald-500/30 mb-3 hover:scale-105 transition-transform duration-300">
        <i class="fa-solid fa-compass text-2xl"></i>
      </div>
      
      <div class="flex items-center justify-center gap-2 mb-1">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
          Wander<span class="text-emerald-400">Vibe</span>
        </h1>
        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[10px] font-extrabold text-emerald-300 uppercase tracking-widest">
          Admin Portal
        </span>
      </div>
      
      <p class="text-xs text-slate-300 mt-1 max-w-xs mx-auto leading-relaxed">
        Cổng điều hành trung tâm dành cho Quản trị viên hệ thống WanderVibe.
      </p>
    </div>

    <!-- Cảnh báo lỗi xác thực từ backend Laravel -->
    @if (session('error'))
        <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 flex items-start gap-3 backdrop-blur-md">
            <i class="fa-solid fa-triangle-exclamation text-red-400 mt-0.5"></i>
            <p class="text-xs font-semibold text-red-300 leading-snug">{{ session('error') }}</p>
        </div>
    @endif
    
    <!-- Form nhập liệu chính của Quản trị viên -->
    <form id="adminLoginForm" onsubmit="handleLoginSubmit(event)" method="POST" action="{{ route('postLogin.admin') }}" class="space-y-4">
      @csrf
      
      <!-- Trường Email Quản trị -->
      <div>
        <label for="adminEmail" class="block text-xs font-bold text-slate-200 uppercase tracking-wider mb-1.5">
          Email Quản Trị Viên
        </label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <i class="fa-solid fa-user-shield text-sm"></i>
          </div>
          <input 
            type="email" 
            id="adminEmail" 
            name="email"
            value="{{ old('email') }}"
            required 
            placeholder="admin@wandervibe.vn"
            class="input-field w-full pl-10 pr-4 py-3 rounded-2xl bg-white/10 border border-white/15 text-white text-xs sm:text-sm placeholder-slate-400 focus:outline-none"
          >
        </div>
        @error('email')
            <span class="text-[11px] font-semibold text-red-400 mt-1.5 block flex items-center gap-1.5">
                <i class="fa-solid fa-xmark"></i> {{ $message }}
            </span>
        @enderror
      </div>

      <!-- Trường Mật khẩu -->
      <div>
        <div class="flex items-center justify-between mb-1.5">
          <label for="adminPassword" class="block text-xs font-bold text-slate-200 uppercase tracking-wider">
            Mật Khẩu Quản Trị
          </label>
          <button type="button" onclick="openForgotPasswordModal()" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 hover:underline">
            Quên mật khẩu?
          </button>
        </div>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <i class="fa-solid fa-lock text-sm"></i>
          </div>
          <input 
            type="password" 
            id="adminPassword" 
            name="password"
            required 
            placeholder="Nhập mật khẩu quản trị..."
            class="input-field w-full pl-10 pr-11 py-3 rounded-2xl bg-white/10 border border-white/15 text-white text-xs sm:text-sm placeholder-slate-400 focus:outline-none font-mono"
          >
          <button 
            type="button" 
            id="togglePasswordBtn" 
            onclick="togglePasswordVisibility()" 
            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white transition-colors"
            title="Hiện/Ẩn mật khẩu"
          >
            <i class="fa-regular fa-eye text-sm" id="passwordIcon"></i>
          </button>
        </div>
        @error('password')
            <span class="text-[11px] font-semibold text-red-400 mt-1.5 block flex items-center gap-1.5">
                <i class="fa-solid fa-xmark"></i> {{ $message }}
            </span>
        @enderror
      </div>

      <!-- Duy trì đăng nhập & Bảo mật phiên làm việc -->
      <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer select-none">
          <input type="checkbox" id="rememberSession" name="remember" checked class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-400 bg-white/10 border-white/20">
          <span class="text-xs font-medium text-slate-300">Ghi nhớ phiên làm việc</span>
        </label>
      </div>

      <!-- Nút Đăng nhập -->
      <button 
        type="submit" 
        id="loginSubmitBtn"
        class="w-full mt-3 py-3.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:to-teal-600 text-white font-extrabold text-sm shadow-xl shadow-emerald-500/30 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 group"
      >
        <span id="loginBtnText">Đăng Nhập Quản Trị Viên</span>
        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform" id="loginBtnIcon"></i>
        <!-- Spinner loading (hidden by default) -->
        <svg id="loginSpinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </button>
    </form>

    <!-- Footer chân form -->
    <div class="pt-5 mt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
      <a href="{{ url('/') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-1.5 font-medium">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Quay lại Website
      </a>
      <span class="text-slate-400 text-[11px] flex items-center gap-1.5 font-medium">
        <i class="fa-solid fa-lock text-[10px] text-emerald-400"></i> WanderVibe Security
      </span>
    </div>

  </div>

  <div id="forgotPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300 border border-white/15">
      <div class="flex items-center justify-between pb-4 border-b border-white/10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 border border-amber-400/30 flex items-center justify-center text-base font-bold">
            <i class="fa-solid fa-key"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white">Khôi Phục Mật Khẩu Admin</h3>
            <p class="text-xs text-slate-400">Cấp lại quyền quản trị viên</p>
          </div>
        </div>
        <button onclick="closeForgotPasswordModal()" class="w-8 h-8 rounded-full hover:bg-white/10 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <form id="resetPasswordForm" onsubmit="handleResetPassword(event)" class="mt-5 space-y-4 text-xs">
        <p class="text-slate-300 leading-relaxed">
          Vui lòng nhập địa chỉ email quản trị viên của bạn. Hệ thống sẽ gửi mã bảo mật OTP 6 chữ số để thiết lập lại mật khẩu.
        </p>

        <div>
          <label class="block font-bold text-slate-200 mb-1">Email quản trị viên</label>
          <input 
            type="email" 
            id="resetEmailInput" 
            required 
            placeholder="admin@wandervibe.vn" 
            class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:bg-white/15 text-xs"
          >
        </div>

        <div class="pt-2 flex items-center justify-end gap-2.5">
          <button type="button" onclick="closeForgotPasswordModal()" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-slate-300 font-bold transition-all">
            Hủy bỏ
          </button>
          <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold shadow-md shadow-emerald-500/25 transition-all">
            Gửi Mã OTP Khôi Phục
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

  <script>
    function togglePasswordVisibility() {
      const passInput = document.getElementById('adminPassword');
      const icon = document.getElementById('passwordIcon');
      if (!passInput || !icon) return;

      if (passInput.type === 'password') {
        passInput.type = 'text';
        icon.className = 'fa-regular fa-eye-slash text-sm text-emerald-400';
      } else {
        passInput.type = 'password';
        icon.className = 'fa-regular fa-eye text-sm text-slate-400';
      }
    }

    // Intercept form submission, show loading states, then allow natural submit
    function handleLoginSubmit(event) {
      // Do NOT prevent default here so it hits the Laravel backend route (postLogin.admin)
      // We only want to decorate the UI while it submits
      
      const email = document.getElementById('adminEmail')?.value.trim() || '';
      const password = document.getElementById('adminPassword')?.value || '';
      const submitBtn = document.getElementById('loginSubmitBtn');
      const btnText = document.getElementById('loginBtnText');
      const btnIcon = document.getElementById('loginBtnIcon');
      const spinner = document.getElementById('loginSpinner');

      // Check validity (HTML5 required will handle empty fields, but if valid we switch UI)
      if (email && password) {
        if (btnText) btnText.textContent = "Đang xác thực...";
        if (btnIcon) btnIcon.classList.add('hidden');
        if (spinner) spinner.classList.remove('hidden');
        if (submitBtn) {
           // To allow form submission, do not disable the button right away,
           // or use form.submit() immediately if disabling.
           // However standard Laravel form submission relies on the button not being disabled immediately.
           submitBtn.style.opacity = '0.9';
           submitBtn.style.cursor = 'wait';
        }
      }
    }

    function openForgotPasswordModal() {
      const modal = document.getElementById('forgotPasswordModal');
      const emailField = document.getElementById('adminEmail');
      const resetField = document.getElementById('resetEmailInput');

      if (resetField && emailField) {
        resetField.value = emailField.value;
      }

      if (modal) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.querySelector('.transform')?.classList.remove('scale-95');
        modal.querySelector('.transform')?.classList.add('scale-100');
      }
    }

    function closeForgotPasswordModal() {
      const modal = document.getElementById('forgotPasswordModal');
      if (modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.querySelector('.transform')?.classList.add('scale-95');
        modal.querySelector('.transform')?.classList.remove('scale-100');
      }
    }

    function handleResetPassword(event) {
      event.preventDefault();
      const email = document.getElementById('resetEmailInput')?.value || '';
      closeForgotPasswordModal();
      showToast(`Đã gửi đường link và mã OTP khôi phục tới: ${email}`, 'success');
    }

    // Toast Notification thanh lịch không dùng alert()
    function showToast(message, type = 'info') {
      const container = document.getElementById('toastContainer');
      if (!container) return;

      const toast = document.createElement('div');
      toast.className = 'pointer-events-auto px-4 py-3 rounded-2xl bg-slate-900/95 backdrop-blur-xl border border-white/15 text-white text-xs font-semibold shadow-2xl flex items-center gap-3 transform translate-y-3 opacity-0 transition-all duration-300';

      const icon = type === 'success' 
        ? '<i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>' 
        : (type === 'warning' ? '<i class="fa-solid fa-triangle-exclamation text-amber-400 text-sm"></i>' : '<i class="fa-solid fa-circle-info text-cyan-400 text-sm"></i>');

      toast.innerHTML = `${icon}<span>${message}</span>`;
      container.appendChild(toast);

      requestAnimationFrame(() => {
        toast.classList.remove('translate-y-3', 'opacity-0');
      });

      setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
      }, 3500);
    }
  </script>
</body>
</html>
