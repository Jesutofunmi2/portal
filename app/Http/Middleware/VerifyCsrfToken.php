<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'ministry/logout',
        'school/logout',
        'student/logout',
        'teacher/logout',
        'liberian/logout',
        'aeo_zeo/logout',
        'parent/logout',
        'cas/logout',
        'api/ministry/login',
        'api/school/login',
        'api/student/login',
        'api/teacher/login',
        'api/liberian/login',
        'api/aeo_zeo/login',
        'api/parent/login',
        'api/ministry/logout',
        'api/school/logout',
        'api/student/logout',
        'api/teacher/logout',
        'api/liberian/logout',
        'api/aeo_zeo/logout',
        'api/parent/logout',
    ];
}
