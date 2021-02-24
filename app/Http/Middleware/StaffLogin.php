<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class StaffLogin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->getRequestUri();
        
        if (substr($url, 0, strlen('/login')) == '/login') {
            if (Auth::check()) {
                return redirect('checkstaff');
            }
        } else {
            if (!Auth::check()) {
                return redirect('login');
            }
        }
        return $next($request);
    }
}
