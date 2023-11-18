<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return redirect('https://odsgmoest.org.ng/school/auth/login');
})->name('welcome');

Route::get('admin/school/class-wallet/payment-receipt','Admins\Wallet\VerifyPaymentController@receipt');
Route::get('admin/school/class-wallet/payment-receipt/bulk','Admins\Wallet\VerifyPaymentController@printBulkReceipt');
// Ministry Routes
Route::get('/ministry/auth/login','Auth\Ministry\AuthController@login')->name('ministry_login_page');
Route::post('/ministry/auth/login','Auth\Ministry\AuthController@login')->name('ministry_login_page_post');
Route::post('/ministry/auth/otp','Auth\Ministry\AuthController@getOTP')->name('ministry_login_otp');

Route::match(['get', 'post'],  'ministry/auth/forget-password', 'Auth\Ministry\ForgetPassword@forget')->name('ministry_forget_password');
Route::get('ministry/auth/reset-password','Auth\Ministry\ForgetPassword@reset')->name('ministry_reset_password');
Route::post('ministry/auth/set-password','Auth\Ministry\ForgetPassword@set')->name('ministry_set_password');

Route::get('ministry/email-verification', 'Auth\Ministry\EmailVerificationController@updateEmail')->name('updateEmail');
Route::post('ministry/email-verification', 'Auth\Ministry\EmailVerificationController@sendVerification')->name('ministryEmailVerification');
Route::get('ministry/email-verification/verify', 'Auth\Ministry\EmailVerificationController@verify')->name('ministryEmailVerify');

Route::get('/cas-admin/auth/login','Auth\Ministry\AuthController@casLogin')->name('cas_login_page');
Route::post('/cas-admin/auth/login','Auth\Ministry\AuthController@casLogin')->name('cas_login_page_post');
Route::post('/cas-admin/auth/otp','Auth\Ministry\AuthController@getCasOTP')->name('cas_login_otp');

Route::group([ 
    'prefix' => 'ministry',
    'middleware'=>['auth:ministry_admin', 'is_ministry'],
    ],
    function (){
        Route::get('/dashboard','Auth\Ministry\DashboardController@index')->name('ministry_dashboard');
        Route::post('/logout','Auth\Ministry\AuthController@logout')->name('ministry_logout');

        Route::get('{any}','Auth\Ministry\DashboardController@index')->where('any', '.*');
    }
);

Route::group([ 
    'prefix' => 'cas',
    'middleware'=>['auth:ministry_admin'],
    ],
    function (){
        Route::get('/dashboard','Auth\Ministry\DashboardController@casIndex')->name('cas_dashboard');
        Route::post('/logout','Auth\Ministry\AuthController@casLogout')->name('cas_logout');

        Route::get('{any}','Auth\Ministry\DashboardController@casIndex')->where('any', '.*');
    }
);

// School Routes
Route::get('/school/auth/login','Auth\School\AuthController@login')->name('school_login_page');
Route::post('/school/auth/login','Auth\School\AuthController@login')->name('school_login_page_post');
Route::post('/school/auth/otp','Auth\School\AuthController@getOTP')->name('school_login_otp');

Route::match(['get', 'post'],  'school/auth/forget-password', 'Auth\School\ForgetPassword@forget')->name('school_forget_password');
Route::get('school/auth/reset-password','Auth\School\ForgetPassword@reset')->name('school_reset_password');
Route::post('school/auth/set-password','Auth\School\ForgetPassword@set')->name('school_set_password');

Route::get('school/email-verification', 'Auth\School\EmailVerificationController@updateEmail')->name('schoolUpdateEmail');
Route::post('school/email-verification', 'Auth\School\EmailVerificationController@sendVerification')->name('schoolEmailVerification');
Route::get('school/email-verification/verify', 'Auth\School\EmailVerificationController@verify')->name('schoolEmailVerify');

Route::group([
    'prefix' => 'school',
    'middleware'=>['auth:school_admin'],
    ],
    function (){
        Route::get('/dashboard','Auth\School\DashboardController@index')->name('school_dashboard');
        Route::post('/logout','Auth\School\AuthController@logout')->name('school_logout');

        Route::get('{any}','Auth\School\DashboardController@index')->where('any', '.*');
    }
);

// Teacher Routes
Route::get('/teacher/auth/login','Auth\Teacher\TeacherAuthController@login')->name('teacher_login_page');
Route::post('/teacher/auth/login','Auth\Teacher\TeacherAuthController@login')->name('teacher_login_page_post');
Route::post('/teacher/auth/otp','Auth\Teacher\TeacherAuthController@getOTP')->name('teacher_login_otp');

Route::match(['get', 'post'],  'teacher/auth/forget-password', 'Auth\Teacher\ForgetPassword@forget')->name('teacher_forget_password');
Route::get('teacher/auth/reset-password','Auth\Teacher\ForgetPassword@reset')->name('teacher_reset_password');
Route::post('teacher/auth/set-password','Auth\Teacher\ForgetPassword@set')->name('teacher_set_password');

Route::get('teacher/email-verification', 'Auth\Teacher\EmailVerificationController@updateEmail')->name('teacherUpdateEmail');
Route::post('teacher/email-verification', 'Auth\Teacher\EmailVerificationController@sendVerification')->name('teacherEmailVerification');
Route::get('teacher/email-verification/verify', 'Auth\Teacher\EmailVerificationController@verify')->name('teacherEmailVerify');

Route::group([
    'prefix' => 'teacher',
    'middleware'=>['auth:teacher'],
    ],
    function (){
        Route::get('/dashboard','Auth\Teacher\DashboardController@index')->name('teacher_dashboard');
        Route::post('/logout','Auth\Teacher\TeacherAuthController@logout')->name('teacher_logout');

        Route::get('{any}','Auth\Teacher\DashboardController@index')->where('any', '.*');
    }
);


// student Routes
Route::get('/student/payment-receipt', "Student\StudentReceiptController@index");
Route::get('/student/auth/login','Auth\Student\StudentAuthController@login')->name('student_login_page');
Route::post('/student/auth/login','Auth\Student\StudentAuthController@login')->name('student_login_page_post');

Route::group([
    'prefix' => 'student',
    'middleware'=>['auth:student'],
    ],
    function (){
        Route::get('/dashboard','Auth\Student\DashboardController@index')->name('student_dashboard');
        Route::post('/logout','Auth\Student\StudentAuthController@logout')->name('student_logout');

        Route::get('{any}','Auth\Student\DashboardController@index')->where('any', '.*');

    }
);



// Liberian Routes
Route::get('/liberian/auth/login','Auth\Liberian\LiberianAuthController@login')->name('liberian_login_page');
Route::post('/liberian/auth/login','Auth\Liberian\LiberianAuthController@login')->name('liberian_login_page_post');
Route::post('/liberian/auth/otp','Auth\Liberian\LiberianAuthController@getOTP')->name('liberian_login_otp');

Route::match(['get', 'post'],  'liberian/auth/forget-password', 'Auth\Liberian\ForgetPassword@forget')->name('liberian_forget_password');
Route::get('liberian/auth/reset-password','Auth\Liberian\ForgetPassword@reset')->name('liberian_reset_password');
Route::post('liberian/auth/set-password','Auth\Liberian\ForgetPassword@set')->name('liberian_set_password');

Route::get('liberian/email-verification', 'Auth\Liberian\EmailVerificationController@updateEmail')->name('liberianUpdateEmail');
Route::post('liberian/email-verification', 'Auth\Liberian\EmailVerificationController@sendVerification')->name('liberianEmailVerification');
Route::get('liberian/email-verification/verify', 'Auth\Liberian\EmailVerificationController@verify')->name('liberianEmailVerify');

Route::group([
    'prefix' => 'liberian',
    'middleware'=>['auth:liberian'],
    ],
    function (){
        Route::get('/dashboard','Auth\Liberian\DashboardController@index')->name('liberian_dashboard');
        Route::post('/logout','Auth\Liberian\LiberianAuthController@logout')->name('liberian_logout');

        Route::get('{any}','Auth\Liberian\DashboardController@index')->where('any', '.*');

    }
);

// Burser Routes
Route::get('/burser/auth/login','Auth\Burser\BurserAuthController@login')->name('burser_login_page');
Route::post('/burser/auth/login','Auth\Burser\BurserAuthController@login')->name('burser_login_page_post');
Route::post('/burser/auth/otp','Auth\Burser\BurserAuthController@getOTP')->name('burser_login_otp');

Route::match(['get', 'post'],  'burser/auth/forget-password', 'Auth\Burser\ForgetPassword@forget')->name('burser_forget_password');
Route::get('burser/auth/reset-password','Auth\Burser\ForgetPassword@reset')->name('burser_reset_password');
Route::post('burser/auth/set-password','Auth\Burser\ForgetPassword@set')->name('burser_set_password');

Route::get('burser/email-verification', 'Auth\Burser\EmailVerificationController@updateEmail')->name('burserUpdateEmail');
Route::post('burser/email-verification', 'Auth\Burser\EmailVerificationController@sendVerification')->name('burserEmailVerification');
Route::get('burser/email-verification/verify', 'Auth\Burser\EmailVerificationController@verify')->name('burserEmailVerify');

Route::group([
    'prefix' => 'burser',
    'middleware'=>['auth:burser'],
    ],
    function (){
        Route::get('/dashboard','Auth\Burser\DashboardController@index')->name('burser_dashboard');
        Route::post('/logout','Auth\Burser\BurserAuthController@logout')->name('burser_logout');

        Route::get('{any}','Auth\Burser\DashboardController@index')->where('any', '.*');

    }
);


// Parents Routes
Route::get('/parent/auth/login','Auth\Parent\ParentAuthController@login')->name('parent_login_page');
Route::post('/parent/auth/login','Auth\Parent\ParentAuthController@login')->name('parent_login_page_post');
Route::post('/parent/auth/otp','Auth\Parent\ParentAuthController@getOTP')->name('parent_login_otp');

Route::match(['get', 'post'],  'parent/auth/forget-password', 'Auth\Parent\ForgetPassword@forget')->name('parent_forget_password');
Route::get('parent/auth/reset-password','Auth\Parent\ForgetPassword@reset')->name('parent_reset_password');
Route::post('parent/auth/set-password','Auth\Parent\ForgetPassword@set')->name('parent_set_password');

Route::get('parent/email-verification', 'Auth\Parent\EmailVerificationController@updateEmail')->name('parentUpdateEmail');
Route::post('parent/email-verification', 'Auth\Parent\EmailVerificationController@sendVerification')->name('parentEmailVerification');
Route::get('parent/email-verification/verify', 'Auth\Parent\EmailVerificationController@verify')->name('parentEmailVerify');

Route::group([
    'prefix' => 'parent',
    'middleware'=>['auth:parent'],
    ],
    function (){
        Route::get('/dashboard','Auth\Parent\DashboardController@index')->name('parent_dashboard');
        Route::post('/logout','Auth\Parent\ParentAuthController@logout')->name('parent_logout');

        Route::get('{any}','Auth\Parent\DashboardController@index')->where('any', '.*');

    }
);

// AEO Routes
Route::get('/aeo_zeo/auth/login','Auth\AEO_ZEO\AEO_ZEOAuthController@login')->name('aeo_zeo_login_page');
Route::post('/aeo_zeo/auth/login','Auth\AEO_ZEO\AEO_ZEOAuthController@login')->name('aeo_zeo_login_page_post');
Route::post('/aeo_zeo/auth/otp','Auth\AEO_ZEO\AEO_ZEOAuthController@getOTP')->name('aeo_zeo_login_otp');

Route::match(['get', 'post'],  'aeo_zeo/auth/forget-password', 'Auth\AEO_ZEO\ForgetPassword@forget')->name('aeo_zeo_forget_password');
Route::get('aeo_zeo/auth/reset-password','Auth\AEO_ZEO\ForgetPassword@reset')->name('aeo_zeo_reset_password');
Route::post('aeo_zeo/auth/set-password','Auth\AEO_ZEO\ForgetPassword@set')->name('aeo_zeo_set_password');

Route::get('aeo_zeo/email-verification', 'Auth\AEO_ZEO\EmailVerificationController@updateEmail')->name('aeo_zeoUpdateEmail');
Route::post('aeo_zeo/email-verification', 'Auth\AEO_ZEO\EmailVerificationController@sendVerification')->name('aeo_zeoEmailVerification');
Route::get('aeo_zeo/email-verification/verify', 'Auth\AEO_ZEO\EmailVerificationController@verify')->name('aeo_zeoEmailVerify');

Route::group([
    'prefix' => 'aeo_zeo',
    'middleware'=>['auth:ministry_admin'],
    ],
    function (){
        Route::get('/dashboard','Auth\AEO_ZEO\DashboardController@index')->name('aeo_zeo_dashboard');
        Route::post('/logout','Auth\AEO_ZEO\AEO_ZEOAuthController@logout')->name('aeo_zeo_logout');

        Route::get('{any}','Auth\AEO_ZEO\DashboardController@index')->where('any', '.*');

    }
);

