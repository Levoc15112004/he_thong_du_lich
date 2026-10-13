<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Lấy URL redirect callback chuẩn
     */
    protected function getRedirectUrl(): string
    {
        $redirect = config('services.google.redirect');

        // Nếu redirect không rỗng và không phải placeholder mặc định http://localhost/auth/google/callback
        if (!empty($redirect) && !str_contains($redirect, 'localhost/auth/google/callback')) {
            return $redirect;
        }

        // Tự động tạo URL callback chuẩn theo host và port hiện tại (Render HTTPS hoặc localhost)
        return route('google.callback');
    }

    public function redirect()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('account')
                ->with('error', 'Chưa cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong file .env hoặc Render Environment!');
        }

        try {
            return Socialite::driver('google')
                ->redirectUrl($this->getRedirectUrl())
                ->stateless()
                ->redirect();
        } catch (\Throwable $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('account')
                ->with('error', 'Không thể kết nối Google: ' . $e->getMessage());
        }
    }

    public function callback()
    {
        try {
            $chatSessionId = session('chat_session_id');
            $redirectUrl = $this->getRedirectUrl();

            try {
                $googleUser = Socialite::driver('google')
                    ->redirectUrl($redirectUrl)
                    ->stateless()
                    ->user();
            } catch (\Throwable $ex) {
                Log::warning('Google stateless failed, retrying standard: ' . $ex->getMessage());
                $googleUser = Socialite::driver('google')
                    ->redirectUrl($redirectUrl)
                    ->user();
            }

            if (! $googleUser || ! $googleUser->getEmail()) {
                return redirect()->route('account')
                    ->with('error', 'Không lấy được thông tin tài khoản từ Google.');
            }

            $email = $googleUser->getEmail();
            $user = User::where('email', $email)->first();

            // Kiểm tra nếu tài khoản bị khóa
            if ($user && $user->status === 'dung_hoat_dong') {
                return redirect()->route('account')
                    ->with('error', 'Tài khoản của bạn đã bị khóa hoặc dừng hoạt động!');
            }

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?: explode('@', $email)[0],
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'role' => 'user',
                    'status' => 'dang_hoat_dong',
                ]);
            } else {
                if (! $user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $user->avatar ?: $googleUser->getAvatar(),
                        'email_verified_at' => $user->email_verified_at ?: now(),
                    ]);
                }
            }

            Auth::login($user, true);

            // Cập nhật chat session nếu có
            if ($chatSessionId) {
                \App\Models\ChatSession::where('id', $chatSessionId)
                    ->whereNull('user_id')
                    ->update([
                        'user_id' => Auth::id(),
                    ]);
                session()->put('chat_session_id', $chatSessionId);
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.home')->with('success', 'Đăng nhập Quản trị viên thành công!');
            }

            if (str_contains((string) session('ads'), 'cart')) {
                session()->forget('ads');
                return redirect()->route('user.order.index');
            }

            return redirect()->route('user.home')->with('success', 'Đăng nhập Google thành công!');

        } catch (\Throwable $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('account')
                ->with('error', 'Đăng nhập Google thất bại: ' . $e->getMessage());
        }
    }
}
