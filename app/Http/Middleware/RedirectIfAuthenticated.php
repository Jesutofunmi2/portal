<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     * 
     */
 
    public function handle($request, Closure $next, $guard = null){
        
       /*
        if ($guard == "ministry_admin" && Auth::guard($guard)->check()) {
            return redirect()->route('ministry_dashboard');
        } */
            switch ($guard) {

            case 'ministry_admin':
                if(Auth::guard($guard)->check()){

                    $user = Auth::guard('ministry_admin')->user();
            
                    //redirect to aeozeo dashboard if the admin admin user is aeozeo
                    if($user->is_aeozeo) return redirect()->route('aeo_zeo_dashboard');

                    return redirect()->route('ministry_dashboard');
                }
            break;
            case 'school_admin':
                if(Auth::guard($guard)->check()){
                    return redirect()->route('school_dashboard');
                }
            break;
            case 'student':
                    if(Auth::guard($guard)->check()){
                    return redirect()->route('student_dashboard');
                }
            break;
            case 'teacher':
                    if(Auth::guard($guard)->check()){
                    return redirect()->route('teacher_dashboard');
                }
            break;
            case 'liberian':
                if(Auth::guard($guard)->check()){
                return redirect()->route('liberian_dashboard');
            }
            case 'burser':
                if(Auth::guard($guard)->check()){
                return redirect()->route('burser_dashboard');
            }
            case 'parent':
                if(Auth::guard($guard)->check()){
                return redirect()->route('parent_dashboard');
            }
            break;

            case 'unity_exam':
                    if(Auth::guard($guard)->check()){
                    return redirect()->route('exam.unity.dashboard');
                }
            break;
            
            case 'entrance':
                    if(Auth::guard($guard)->check()){
                    return redirect()->route('exam.entrance.dashboard');
                }
            break;
        }
        
        return $next($request);
    }
    
}
