<?php

namespace App\Http\Middleware;

use Closure;

class IsMinistry
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
        $user = auth('ministry_admin')->user();
        if ($user && $user->is_cas_admin) {
            return redirect()->route('cas_dashboard');
        }
        return $next($request);
    }
}
