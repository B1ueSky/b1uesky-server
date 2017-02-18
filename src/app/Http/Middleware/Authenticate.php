<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
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
        // check if the password hashed token in Header Authorization matches the admin password
        $token = $request->header('Authorization', '');
        if (!password_verify(env('ADMIN_PASSWORD'), $token)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
