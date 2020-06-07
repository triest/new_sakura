<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends Middleware
{

    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (\Route::is('admin.*')) {
                return route('admin.login');
            }
            if (\Route::is('lk.*')) {
                return route('lk.login');
            }
        }
    }
}
