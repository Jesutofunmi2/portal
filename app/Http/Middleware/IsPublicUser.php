<?php

namespace App\Http\Middleware;

use Closure;

class IsPublicUser
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
        $auth_token = $request->header('auth');
        $server_token = env('AUTH_SECRET');

        if(is_null($auth_token)) {
            return response()->json([
                'message' => 'Permission Denied'
               ], 403
            );
        }

        if($auth_token != $server_token) {
            return response()->json([
                'message' => 'Invalid Auth Token'
               ], 401
            );
        }

        return $next($request);
    }
}
