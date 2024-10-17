<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == '1'){
                return $next($request);
            }else {
                return redirect()->route('login')->with([
                    'message' => 'Bạn không có quyền truy cập trang này.'
                ]); // Chuyển hướng đăng nhập
            }
        }else{
            return redirect()->route('login')
            ->with('message', 'Đăng nhập trước !!!');
        }
           
    }
}
