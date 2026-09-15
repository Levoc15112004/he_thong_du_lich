<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckAdmin
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
        if (Auth::user()->role === 'admin') {
            return $next($request);
        } else {
            return redirect()->route('login.admin')
                ->with('err', 'Tài khoản của bạn không có quyền truy cập trang quản trị!')
                ->withInput();
        }
    } else {
        return redirect()->route('login.admin')
            ->with('err', 'Vui lòng đăng nhập để truy cập trang quản trị!');
    }

    }
}
