<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
        // Nếu role là admin thì cho phép đi tiếp
        if (Auth::user()->role === 'user') {
            return $next($request);
        } else {
            // Nếu không phải admin → quay về trang login admin
            return redirect()->route('account')
                ->with('err', 'Tài khoản của bạn không có quyền truy cập trang này!')
                ->withInput();
        }
    } else {
        // Nếu chưa đăng nhập → chuyển hướng tới trang login
        return redirect()->route('account')
            ->with('err', 'Vui lòng đăng nhập để truy cập trang web!');
    }
    }
}
