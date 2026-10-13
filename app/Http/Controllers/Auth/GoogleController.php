<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('account')
                ->with('error', 'Chức năng Đăng nhập Google cần được cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong file .env trên hosting/server.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('account')
                ->with('error', 'Không thể kết nối Google: ' . $e->getMessage());
        }
    }

    public function callback()
    {
        try {

            $chatSessionId = session('chat_session_id');

            try {
                $googleUser = Socialite::driver('google')->user();
            } catch (\Throwable $ex) {
                // Thử chế độ stateless nếu có lỗi session/CSRF state trên cloud/Render
                $googleUser = Socialite::driver('google')->stateless()->user();
            }

            if (! $googleUser || ! $googleUser->email) {
                return redirect()->route('account')
                    ->with('error', 'Không lấy được thông tin tài khoản từ Google.');
            }

            $user = User::where('email', $googleUser->email)->first();

            if (! $user) {

                $user = User::create([
                    'name' => $googleUser->name ?? explode('@', $googleUser->email)[0],
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => 'user',
                    'status' => 'dang_hoat_dong',
                ]);

            } else {

                if (! $user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar ?: $user->avatar,
                    ]);
                }
            }

            Auth::login($user, true);

            // FIX: update chat session giống AccountController
            if ($chatSessionId) {
                \App\Models\ChatSession::where('id', $chatSessionId)
                    ->whereNull('user_id')
                    ->update([
                        'user_id' => Auth::id(),
                    ]);
            }

            session()->put('chat_session_id', $chatSessionId);

            return redirect()->route('user.home')->with('success', 'Đăng nhập Google thành công!');

        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect()->route('account')
                ->with('error', 'Đăng nhập Google thất bại: ' . $e->getMessage());
        }
    }
}
