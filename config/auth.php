<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'ministry_api' => [
            'driver' => 'jwt',
            'provider' => 'ministry_admins',
            'hash' => false,
        ],

        'school_api' => [
            'driver' => 'jwt',
            'provider' => 'school_admins',
            'hash' => false,
        ],

        'teacher_api' => [
            'driver' => 'jwt',
            'provider' => 'teachers',
            'hash' => false,
        ],

        'student_api' => [
            'driver' => 'jwt',
            'provider' => 'students',
            'hash' => false,
        ],

        'liberian_api' => [
            'driver' => 'jwt',
            'provider' => 'liberians',
            'hash' => false,
        ],

        'burser_api' => [
            'driver' => 'jwt',
            'provider' => 'bursers',
            'hash' => false,
        ],

        'parent_api' => [
            'driver' => 'jwt',
            'provider' => 'parents',
            'hash' => false,
        ],

        'aeo_zeo_api' => [
            'driver' => 'jwt',
            'provider' => 'aeo_zeos',
            'hash' => false,
        ],

        'ministry_admin' => [
            'driver' => 'session',
            'provider' => 'ministry_admins',
        ],
        'school_admin' => [
            'driver' => 'session',
            'provider' => 'school_admins',
        ],
        'teacher' => [
            'driver' => 'session',
            'provider' => 'teachers',
        ],
        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],
        'liberian' => [
            'driver' => 'session',
            'provider' => 'liberians',
        ],
        'burser' => [
            'driver' => 'session',
            'provider' => 'bursers',
        ],
        'parent' => [
            'driver' => 'session',
            'provider' => 'parents',
        ],
        'aeo_zeo' => [
            'driver' => 'session',
            'provider' => 'aeo_zeos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
      
        'ministry_admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Ministry\Admin::class,
        ],
        'school_admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\School\Admin::class,
        ],
        'teachers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Teacher\Teacher::class,
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student\Student::class,
        ],
        'liberians' => [
            'driver' => 'eloquent',
            'model' => App\Models\Liberian\Liberian::class,
        ],
        'bursers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Burser\Burser::class,
        ],
        'parents' => [
            'driver' => 'eloquent',
            'model' => App\Models\Parent\Parents::class,
        ],
        'aeo_zeos' => [
            'driver' => 'eloquent',
            'model' => App\Models\AEO_ZEO\AEO_ZEO::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'ministry_admins' => [
            'provider' => 'ministry_admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'school_admins' => [
            'provider' => 'school_admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'teachers' => [
            'provider' => 'teachers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'liberians' => [
            'provider' => 'liberians',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'bursers' => [
            'provider' => 'bursers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'parents' => [
            'provider' => 'parents',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
