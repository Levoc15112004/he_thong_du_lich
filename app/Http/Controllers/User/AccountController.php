<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function account()
    {
        if (! str_contains(url()->previous(), 'account')) {
            session(['ads' => url()->previous()]);
        }

        return view('users.account');
    }

    public function user()
    {
        if (Auth::check()) {
            return redirect()->route('user.profile', Auth::id());
        }

        return redirect()->route('account');
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // lưu chat session trước login
        $chatSessionId = session('chat_session_id');

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'status' => 'dang_hoat_dong',
        ]);

        Auth::login($user);

        // Tự động lấy voucher dành cho đăng ký lần đầu
        $voucher = Voucher::where('event_type', 'register')
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->whereColumn('used_count', '<', 'quantity')
            ->latest()
            ->first();

        if ($voucher) {
            $alreadyHasVoucher = UserVoucher::where('user_id', $user->id)
                ->where('voucher_id', $voucher->id)
                ->exists();

            if (! $alreadyHasVoucher) {
                UserVoucher::create([
                    'user_id' => $user->id,
                    'voucher_id' => $voucher->id,
                    'status' => 0,
                ]);

                $voucher->increment('used_count');

                // nếu dùng hết thì tự tắt
                if ($voucher->fresh()->used_count >= $voucher->quantity) {
                    $voucher->update([
                        'status' => 0,
                    ]);
                }
            }
        }

        // update chat session sau login
        if ($chatSessionId) {
            \App\Models\ChatSession::where('id', $chatSessionId)
                ->whereNull('user_id')
                ->update([
                    'user_id' => $user->id,
                ]);
        }

        session()->put('chat_session_id', $chatSessionId);

        if (str_contains((string) Session::get('ads'), 'cart')) {
            Session::forget('ads');

            return redirect()->route('user.order.index');
        }

        Session::forget('ads');

        return redirect()->route('user.home');
    }

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');

        //  LƯU CHAT SESSION TRƯỚC LOGIN
        $chatSessionId = session('chat_session_id');

        $user = User::where('email', $req->email)->first();

        if (! $user) {
            return back()->withErrors([
                'login_error' => 'Email hoặc mật khẩu không chính xác!',
            ])->withInput();
        }

        if ($user->status === 'dung_hoat_dong') {
            return back()->withErrors([
                'login_error' => 'Tài khoản của bạn đã bị dừng hoạt động!',
            ]);
        }

        if (Auth::attempt($credentials)) {

            //  UPDATE CHAT SESSION
            if ($chatSessionId) {
                \App\Models\ChatSession::where('id', $chatSessionId)
                    ->whereNull('user_id')
                    ->update([
                        'user_id' => Auth::id(),
                    ]);
            }

            // RESTORE chat_session_id
            session()->put('chat_session_id', $chatSessionId);

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.home');
            }

            if (str_contains((string) Session::get('ads'), 'cart')) {
                Session::forget('ads');

                return redirect()->route('user.order.index');
            }

            Session::forget('ads');

            return redirect()->route('user.home');
        }

        return back()->withErrors([
            'login_error' => 'Email hoặc mật khẩu không chính xác!',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('user.home')->with('success', 'Đăng xuất thành công!');
    }

    public function update(Request $request)
    {
        // 1. Validate
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
        ]);

        // 2. Lấy user hiện tại
        $user = Auth::user();

        // 3. Check mật khẩu cũ
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không đúng',
            ]);
        }

        // 4. Update bằng User::where()->update()
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

    public function showForgotForm()
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        return view('users.auth.forgot_password', compact('categories', 'notifications', 'unreadCount'));
    }

    // Gửi OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email không tồn tại']);
        }

        $otp = rand(100000, 999999);

        session([
            'reset_email' => $request->email,
            'reset_otp' => $otp,
            'otp_expired' => now()->addMinutes(10),
        ]);

        $subject = 'Xác nhận đổi mật khẩu - WanderVibe';
        $content = "Xin chào {$user->name},\n\nMã xác nhận đặt lại mật khẩu WanderVibe của bạn là: {$otp}\nMã này có hiệu lực trong 10 phút. Vui lòng không chia sẻ mã này cho bất kỳ ai.\n\nTrân trọng,\nĐội ngũ WanderVibe Travel";
        $htmlContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 500px; margin: 0 auto; border: 1px solid #fed7aa; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                <div style='background: linear-gradient(135deg, #f97316, #f43f5e); padding: 24px; text-align: center; color: white;'>
                    <h2 style='margin: 0; font-size: 22px; font-weight: bold;'>WanderVibe Travel</h2>
                    <p style='margin: 6px 0 0; opacity: 0.9; font-size: 13px;'>Yêu cầu đặt lại mật khẩu</p>
                </div>
                <div style='padding: 28px 24px; text-align: center;'>
                    <p style='margin: 0 0 16px; color: #475569; font-size: 14px;'>Xin chào <strong>" . htmlspecialchars($user->name) . "</strong>,</p>
                    <p style='margin: 0 0 20px; color: #64748b; font-size: 13px;'>Bạn vừa yêu cầu mã xác nhận để đổi lại mật khẩu tài khoản. Dưới đây là mã OTP của bạn:</p>
                    <div style='display: inline-block; background: #fff7ed; border: 2px dashed #f97316; border-radius: 12px; padding: 14px 28px; margin: 10px 0 20px;'>
                        <span style='font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #ea580c; font-family: monospace;'>" . $otp . "</span>
                    </div>
                    <p style='margin: 0; color: #94a3b8; font-size: 12px;'>Mã có hiệu lực trong vòng <strong>10 phút</strong>. Nếu không phải bạn yêu cầu, vui lòng bỏ qua email này.</p>
                </div>
            </div>
        ";

        $mailSent = false;
        $resendApiKey = env('RESEND_API_KEY');

        // 1. Thử gửi qua Resend API (HTTPS port 443 - không bị chặn cổng SMTP trên Render/Cloud)
        if (!empty($resendApiKey)) {
            try {
                $fromEmail = env('RESEND_FROM_EMAIL', 'WanderVibe <onboarding@resend.dev>');
                $response = \Illuminate\Support\Facades\Http::withToken($resendApiKey)
                    ->timeout(10)
                    ->post('https://api.resend.com/emails', [
                        'from' => $fromEmail,
                        'to' => [$request->email],
                        'subject' => $subject,
                        'html' => $htmlContent,
                        'text' => $content,
                    ]);

                if ($response->successful()) {
                    $mailSent = true;
                } else {
                    \Illuminate\Support\Facades\Log::warning('Resend OTP mail failed: ' . $response->body());
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Resend OTP exception: ' . $e->getMessage());
            }
        }

        // 2. Fallback sang SMTP nếu chưa gửi được qua Resend
        if (!$mailSent) {
            try {
                Mail::raw($content, function ($message) use ($request, $subject) {
                    $message->to($request->email)->subject($subject);
                });
                $mailSent = true;
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('SMTP OTP mail error: ' . $e->getMessage());
            }
        }

        // Nếu cả 2 đều bị chặn mạng/timeout trên cloud server
        if (!$mailSent) {
            \Illuminate\Support\Facades\Log::info("OTP generated for {$request->email}: {$otp}");
            return redirect()->route('password.reset')
                ->with('warning', 'Hệ thống gửi thư qua mạng đang bận. Mã OTP của bạn là: ' . $otp);
        }

        return redirect()->route('password.reset')->with('success', 'Đã gửi mã xác nhận OTP vào email của bạn!');
    }

    // Form nhập OTP + mật khẩu mới
    public function showResetForm()
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();
        if (! session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('users.auth.reset_password', compact('categories', 'notifications', 'unreadCount'));
    }

    // Đổi mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (
            session('reset_otp') != $request->otp ||
            now()->greaterThan(session('otp_expired'))
        ) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn']);
        }

        User::where('email', session('reset_email'))
            ->update([
                'password' => Hash::make($request->password),
            ]);

        session()->forget(['reset_email', 'reset_otp', 'otp_expired']);

        return redirect('/account')->with('success', 'Đổi mật khẩu thành công');
    }
}
