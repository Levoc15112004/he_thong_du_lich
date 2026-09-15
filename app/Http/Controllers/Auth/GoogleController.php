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
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {

            $chatSessionId = session('chat_session_id');

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if (! $user) {

                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => 'user',
                ]);

            } else {

                if (! $user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
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

            return redirect()->route('user.home');

        } catch (Exception $e) {

            return redirect()->route('account')
                ->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}
