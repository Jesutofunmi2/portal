<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\ActivityLog;


use Closure;

class Log
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
        // record activities here
        $currentPath = Route::getCurrentRoute()->uri;
        $method = $method = $request->method();
        $device = $request->server('HTTP_USER_AGENT');
        $ip = $request->ip();
        if(Auth::guard('ministry_api')->check() || Auth::guard('school_api')->check()
            || Auth::guard('teacher_api')->check() || Auth::guard('student_api')->check()
            || Auth::guard('burser_api')->check() || Auth::guard('liberian_api')->check()
            || Auth::guard('aeo_zeo_api')->check() || Auth::guard('parent_api')->check()){

            if(Auth::guard('ministry_api')->check()){
                $user = auth('ministry_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'super_admin_id' => $user->id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }
            
            if(Auth::guard('school_api')->check()){
                $user = auth('school_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'admin_id' => $user->id,
                    'school_id' => $user->school_id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }
            
            if(Auth::guard('teacher_api')->check()){
                $user = auth('teacher_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'teacher_id' => $user->id,
                    'school_id' => $user->school_id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }
            
            if(Auth::guard('student_api')->check()){
                $user = auth('student_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'student_id' => $user->id,
                    'school_id' => $user->school_id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }

            if(Auth::guard('burser_api')->check()){
                $user = auth('burser_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'burser_id' => $user->id,
                    'school_id' => $user->school_id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }

            if(Auth::guard('liberian_api')->check()){
                $user = auth('liberian_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'liberian_id' => $user->id,
                    'school_id' => $user->school_id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }

            if(Auth::guard('aeo_zeo_api')->check()){
                $user = auth('aeo_zeo_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'aeo_zeo_id' => $user->id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }

            if(Auth::guard('parent_api')->check()){
                $user = auth('parent_api')->user();
                if ($request->isMethod('post')) {
                    $message = 'posted to '.$currentPath.'';
                }else{
                    $message = 'visited '.$currentPath.'';
                }
                ActivityLog::create([
                    'parent_id' => $user->id,
                    'message' => $message,
                    'path' => $currentPath,
                    'type' => $method,
                    'ip' => $ip,
                    'device' => $device
                ]);
            }
        }
                
        
        return $next($request);
    }
}
