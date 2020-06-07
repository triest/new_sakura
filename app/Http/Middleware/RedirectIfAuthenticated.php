<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (\Auth::guard('lk')->check() && \Route::is('lk.*')) {
            return redirect()->route('lk.home');
        }

        if (\Auth::guard('admin')->check() && \Route::is('admin.*')) {
            return redirect()->route('admin.home');
        }

        return $next($request);
    }
}
