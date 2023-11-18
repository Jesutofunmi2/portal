<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuth
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
        /*
        try {
            if (! $token = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            } else if ( $e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            }else{
                return response()->json([
                    'message' => 'Please Login'
                ],401);
            }
        }
        */
        if(auth('ministry_api')->check() || auth('school_api')->check() ||
            auth('teacher_api')->check() || auth('student_api')->check() ||
            auth('burser_api')->check() || auth('liberian_api')->check() ||
            auth('aeo_zeo_api')->check() || auth('parent_api')->check() 
         ){

            return $next($request);
        }
        else{
            return response()->json([
                'error' => 'Unauthenticated'
            ],401);
        }

       
    }
}
