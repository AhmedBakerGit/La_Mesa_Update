<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('admin.login');
    //     }
    // }

    public function handle($request, Closure $next)
    {
        $url = $request->getRequestUri();
        
        if (substr($url, 0, strlen('/admin/login')) == '/admin/login' || substr($url, 0, strlen('/admin/register'))== '/admin/register') {
            if (Auth::guard('admin')->check()) {
                return redirect('admin/restaurants');
            }
        } else {
            if (!Auth::guard('admin')->check()) {
                return redirect('admin/login');
            }
        }

        return $next($request);
    }
}
