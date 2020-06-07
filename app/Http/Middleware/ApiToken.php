<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
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
        $token = '';
        foreach($request->headers as $k => $h) {
            if($k == 'token') {
                $token = $h[0];
            }
        }

        if ($token != config('app.api_token')) {
            return response()->json('Unauthorized', 401);
        }

        return $next($request);
    }
}
