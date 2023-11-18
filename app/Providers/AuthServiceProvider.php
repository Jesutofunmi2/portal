<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth; //use this library

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        /*
        if(Auth::guard('ministry_api')){
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
    
            try {
                // attempt to verify the credentials and create a token for the user
                $token = JWTAuth::getToken();
                $apy = JWTAuth::getPayload($token)->toArray();
                dd(auth('ministry_api')->user()->fullname);

            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        
                return response()->json(['token_expired'], 500);
        
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        
                return response()->json(['token_invalid'], 500);
        
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        
                return response()->json(['token_absent' => $e->getMessage()], 500);
        
            }
        }
       */

        $this->registerPolicies($gate);
        $this->registerSchoolAdminPolicies($gate);
        $this->registerMinistryAdminPolicies($gate);
        $this->registerTeacherPolicies($gate);

    }
    public function registerMinistryAdminPolicies($gate){

        Auth::shouldUse('ministry_api');
        
        $gate->define('view-student', function($admin){
            return $admin->hasPermission('view-student');
        });

        $gate->define('create-student', function($admin){
            return $admin->hasPermission('create-student');
        });

        $gate->define('edit-student', function($admin){
            return $admin->hasPermission('edit-student');
        });

        $gate->define('delete-student', function($admin){
            return $admin->hasPermission('delete-student');
        });

        $gate->define('view-user', function($admin){
            return $admin->hasPermission('view-user');
        });
        
        $gate->define('create-user', function($admin){
            return $admin->hasPermission('create-user');
        });

        $gate->define('edit-user', function($admin){
            return $admin->hasPermission('edit-user');
        });

        $gate->define('delete-user', function($admin){
            return $admin->hasPermission('delete-user');
        });

        $gate->define('view-teacher', function($admin){
            return $admin->hasPermission('view-teacher');
        });
        $gate->define('create-teacher', function($admin){
            return $admin->hasPermission('create-teacher');
        });

        $gate->define('edit-teacher', function($admin){
            return $admin->hasPermission('edit-teacher');
        });

        $gate->define('delete-teacher', function($admin){
            return $admin->hasPermission('delete-teacher');
        });

        $gate->define('view-subject', function($admin){
            return $admin->hasPermission('view-subject');
        });
        $gate->define('create-subject', function($admin){
            return $admin->hasPermission('create-subject');
        });

        $gate->define('edit-subject', function($admin){
            return $admin->hasPermission('edit-subject');
        });

        $gate->define('delete-subject', function($admin){
            return $admin->hasPermission('delete-subject');
        });

        $gate->define('view-class', function($admin){
            return $admin->hasPermission('view-class');
        });
        $gate->define('create-class', function($admin){
            return $admin->hasPermission('create-class');
        });

        $gate->define('edit-class', function($admin){
            return $admin->hasPermission('edit-class');
        });

        $gate->define('delete-class', function($admin){
            return $admin->hasPermission('delete-class');
        });

        $gate->define('view-classarm', function($admin){
            return $admin->hasPermission('view-classarm');
        });
        $gate->define('create-classarm', function($admin){
            return $admin->hasPermission('create-classarm');
        });

        $gate->define('edit-classarm', function($admin){
            return $admin->hasPermission('edit-classarm');
        });

        $gate->define('delete-classarm', function($admin){
            return $admin->hasPermission('delete-classarm');
        });

        $gate->define('view-remarks', function($admin){
            return $admin->hasPermission('view-remarks');
        });
        $gate->define('single-upload-remarks', function($admin){
            return $admin->hasPermission('single-upload-remarks');
        });
        $gate->define('batch-upload-remarks', function($admin){
            return $admin->hasPermission('batch-upload-remarks');
        });

        $gate->define('edit-student-remarks', function($admin){
            return $admin->hasPermission('edit-student-remarks');
        });

        $gate->define('delete-student-remarks', function($admin){
            return $admin->hasPermission('delete-student-remarks');
        });

        $gate->define('view-result', function($admin){
            return $admin->hasPermission('view-result');
        });
        $gate->define('single-upload-result', function($admin){
            return $admin->hasPermission('single-upload-result');
        });
        $gate->define('batch-upload-result', function($admin){
            return $admin->hasPermission('batch-upload-result');
        });

        $gate->define('edit-student-result', function($admin){
            return $admin->hasPermission('edit-student-result');
        });

        $gate->define('delete-student-result', function($admin){
            return $admin->hasPermission('delete-student-result');
        });
        

        $gate->define('assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('assign-teacher-to-classarm');
        });

        $gate->define('edit-assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-teacher-to-classarm');
        });

        $gate->define('remove-assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-teacher-to-classarm');
        });

        $gate->define('assign-student-to-classarm', function($admin){
            return $admin->hasPermission('assign-student-to-classarm');
        });

        $gate->define('edit-assign-student-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-student-to-classarm');
        });

        $gate->define('remove-assign-student-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-student-to-classarm');
        });

        $gate->define('assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('assign-subject-to-classarm');
        });

        $gate->define('edit-assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-subject-to-classarm');
        });

        $gate->define('remove-assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-subject-to-classarm');
        });

        $gate->define('view-school', function($admin){
            return $admin->hasPermission('view-school');
        });
        $gate->define('create-school', function($admin){
            return $admin->hasPermission('create-school');
        });

        $gate->define('edit-school', function($admin){
            return $admin->hasPermission('edit-school');
        });

        $gate->define('delete-school', function($admin){
            return $admin->hasPermission('delete-school');
        });

        $gate->define('view-school-admin', function($admin){
            return $admin->hasPermission('view-school-admin');
        });

        $gate->define('create-school-admin', function($admin){
            return $admin->hasPermission('create-school-admin');
        });

        $gate->define('edit-school-admin', function($admin){
            return $admin->hasPermission('edit-school-admin');
        });

        $gate->define('delete-school-admin', function($admin){
            return $admin->hasPermission('delete-school-admin');
        });

        $gate->define('create-scratch-card', function($admin){
            return $admin->hasPermission('create-scratch-card');
        });

        $gate->define('view-scratch-card', function($admin){
            return $admin->hasPermission('view-scratch-card');
        });

        $gate->define('delete-scratch-card', function($admin){
            return $admin->hasPermission('delete-scratch-card');
        });

        $gate->define('lock-and-release-student-result', function($admin){
            return $admin->hasPermission('lock-and-release-student-result');
        });

         $gate->define('view-debtor-penalty', function($admin){
            return $admin->hasPermission('view-debtor-penalty');
        });

         $gate->define('create-debtor-penalty', function($admin){
            return $admin->hasPermission('create-debtor-penalty');
        });

         $gate->define('status-debtor-penalty', function($admin){
            return $admin->hasPermission('status-debtor-penalty');
        });

        $gate->define('view-transfer', function($admin){
            return $admin->hasPermission('view-transfer');
        });

        $gate->define('edit-wallet', function($admin){
            return $admin->hasPermission('edit-wallet');
        });

        $gate->define('edit-id-card-request', function($admin){
            return $admin->hasPermission('edit-id-card-request');
        });

        $gate->define('view-annual-assessment', function($admin){
            return $admin->hasPermission('view-annual-assessment');
        });

        $gate->define('view-statistics', function($admin){
            return $admin->hasPermission('view-statistics');
        });

        $gate->define('view-schools-survey', function($admin){
            return $admin->hasPermission('view-schools-survey');
        });

        $gate->define('view-activity-log', function($admin){
            return $admin->hasPermission('view-activity-log');
        });

        $gate->define('reset-login-attempt', function($admin){
            return $admin->hasPermission('reset-login-attempt');
        });

        $gate->define('download-student-passport', function($admin){
            return $admin->hasPermission('download-student-passport');
        });

        $gate->define('post-faq', function($admin){
            return $admin->hasPermission('post-faq');
        });

        $gate->define('delete-faq', function($admin){
            return $admin->hasPermission('delete-faq');
        });

        $gate->define('view-payment-histroy', function($admin){
            return $admin->hasPermission('view-payment-histroy');
        });
        
        

        $gate->define('create-task', function($admin){
            return $admin->hasPermission('create-task');
        });

        $gate->define('view-task', function($admin){
            return $admin->hasPermission('view-task');
        });

        $gate->define('edit-task', function($admin){
            return $admin->hasPermission('edit-task');
        });

        $gate->define('delete-task', function($admin){
            return $admin->hasPermission('delete-task');
        });


        $gate->define('create-ministry-department', function($admin){
            return $admin->hasPermission('create-ministry-department');
        });

        $gate->define('edit-ministry-department', function($admin){
            return $admin->hasPermission('edit-ministry-department');
        });

        $gate->define('view-ministry-department', function($admin){
            return $admin->hasPermission('view-ministry-department');
        });
        
        $gate->define('delete-ministry-department', function($admin){
            return $admin->hasPermission('delete-ministry-department');
        });
    
    }


    public function registerSchoolAdminPolicies($gate){

        Auth::shouldUse('school_api');
        
        $gate->define('view-student', function($admin){
            return $admin->hasPermission('view-student');
        });

        $gate->define('create-student', function($admin){
            return $admin->hasPermission('create-student');
        });

        $gate->define('edit-student', function($admin){
            return $admin->hasPermission('edit-student');
        });

        $gate->define('delete-student', function($admin){
            return $admin->hasPermission('delete-student');
        });

        $gate->define('view-user', function($admin){
            return $admin->hasPermission('view-user');
        });
        
        $gate->define('create-user', function($admin){
            return $admin->hasPermission('create-user');
        });

        $gate->define('edit-user', function($admin){
            return $admin->hasPermission('edit-user');
        });

        $gate->define('delete-user', function($admin){
            return $admin->hasPermission('delete-user');
        });

        $gate->define('view-teacher', function($admin){
            return $admin->hasPermission('view-teacher');
        });
        $gate->define('create-teacher', function($admin){
            return $admin->hasPermission('create-teacher');
        });

        $gate->define('edit-teacher', function($admin){
            return $admin->hasPermission('edit-teacher');
        });

        $gate->define('delete-teacher', function($admin){
            return $admin->hasPermission('delete-teacher');
        });

        $gate->define('view-subject', function($admin){
            return $admin->hasPermission('view-subject');
        });
        $gate->define('create-subject', function($admin){
            return $admin->hasPermission('create-subject');
        });

        $gate->define('edit-subject', function($admin){
            return $admin->hasPermission('edit-subject');
        });

        $gate->define('delete-subject', function($admin){
            return $admin->hasPermission('delete-subject');
        });

        $gate->define('view-class', function($admin){
            return $admin->hasPermission('view-class');
        });
        $gate->define('create-class', function($admin){
            return $admin->hasPermission('create-class');
        });

        $gate->define('edit-class', function($admin){
            return $admin->hasPermission('edit-class');
        });

        $gate->define('delete-class', function($admin){
            return $admin->hasPermission('delete-class');
        });

        $gate->define('view-classarm', function($admin){
            return $admin->hasPermission('view-classarm');
        });
        $gate->define('create-classarm', function($admin){
            return $admin->hasPermission('create-classarm');
        });

        $gate->define('edit-classarm', function($admin){
            return $admin->hasPermission('edit-classarm');
        });

        $gate->define('delete-classarm', function($admin){
            return $admin->hasPermission('delete-classarm');
        });

        $gate->define('view-remarks', function($admin){
            return $admin->hasPermission('view-remarks');
        });
        $gate->define('single-upload-remarks', function($admin){
            return $admin->hasPermission('single-upload-remarks');
        });
        $gate->define('batch-upload-remarks', function($admin){
            return $admin->hasPermission('batch-upload-remarks');
        });

        $gate->define('edit-student-remarks', function($admin){
            return $admin->hasPermission('edit-student-remarks');
        });

        $gate->define('delete-student-remarks', function($admin){
            return $admin->hasPermission('delete-student-remarks');
        });

        $gate->define('view-result', function($admin){
            return $admin->hasPermission('view-result');
        });
        $gate->define('single-upload-result', function($admin){
            return $admin->hasPermission('single-upload-result');
        });
        $gate->define('batch-upload-result', function($admin){
            return $admin->hasPermission('batch-upload-result');
        });

        $gate->define('edit-student-result', function($admin){
            return $admin->hasPermission('edit-student-result');
        });

        $gate->define('delete-student-result', function($admin){
            return $admin->hasPermission('delete-student-result');
        });
        

        $gate->define('assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('assign-teacher-to-classarm');
        });

        $gate->define('edit-assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-teacher-to-classarm');
        });

        $gate->define('remove-assign-teacher-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-teacher-to-classarm');
        });

        $gate->define('assign-student-to-classarm', function($admin){
            return $admin->hasPermission('assign-student-to-classarm');
        });

        $gate->define('edit-assign-student-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-student-to-classarm');
        });

        $gate->define('remove-assign-student-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-student-to-classarm');
        });

        $gate->define('assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('assign-subject-to-classarm');
        });

        $gate->define('edit-assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-subject-to-classarm');
        });

        $gate->define('remove-assign-subject-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-subject-to-classarm');
        });

        $gate->define('view-school-house', function($admin){
            return $admin->hasPermission('view-school-house');
        });
        $gate->define('create-school-house', function($admin){
            return $admin->hasPermission('create-school-house');
        });

        $gate->define('edit-school-house', function($admin){
            return $admin->hasPermission('edit-school-house');
        });

        $gate->define('delete-school-house', function($admin){
            return $admin->hasPermission('delete-school-house');
        });

        $gate->define('assign-student-to-school-house', function($admin){
            return $admin->hasPermission('assign-student-to-school-house');
        });

        $gate->define('remove-assign-student-from-school-house', function($admin){
            return $admin->hasPermission('remove-assign-student-from-school-house');
        });

        $gate->define('lock-and-release-student-result', function($admin){
            return $admin->hasPermission('lock-and-release-student-result');
        });

        $gate->define('view-debtor-penalty', function($admin){
            return $admin->hasPermission('view-debtor-penalty');
        });

         $gate->define('create-debtor-penalty', function($admin){
            return $admin->hasPermission('create-debtor-penalty');
        });

         $gate->define('status-debtor-penalty', function($admin){
            return $admin->hasPermission('status-debtor-penalty');
        });

         $gate->define('view-transfer', function($admin){
            return $admin->hasPermission('view-transfer');
        });

         $gate->define('signature-transfer', function($admin){
            return $admin->hasPermission('signature-transfer');
        });

         $gate->define('assign-transfer-student-to-class', function($admin){
            return $admin->hasPermission('assign-transfer-student-to-class');
        });

         $gate->define('new-teacher-transfer', function($admin){
            return $admin->hasPermission('new-teacher-transfer');
        });

         $gate->define('inward-teacher-transfer-history', function($admin){
            return $admin->hasPermission('inward-teacher-transfer-history');
        });

         $gate->define('outward-teacher-transfer-history', function($admin){
            return $admin->hasPermission('outward-teacher-transfer-history');
        });

         $gate->define('confirm-teacher-transfer', function($admin){
            return $admin->hasPermission('confirm-teacher-transfer');
        });

         
        $gate->define('assign-counsellor-to-classarm', function($admin){
            return $admin->hasPermission('assign-counsellor-to-classarm');
        });

        $gate->define('edit-assign-counsellor-to-classarm', function($admin){
            return $admin->hasPermission('edit-assign-counsellor-to-classarm');
        });

        $gate->define('remove-assign-counsellor-to-classarm', function($admin){
            return $admin->hasPermission('remove-assign-counsellor-to-classarm');
        });

        $gate->define('remove-subject-from-teacher', function($admin){
            return $admin->hasPermission('remove-subject-from-teacher');
        });

        $gate->define('assign-subject-to-teacher', function($admin){
            return $admin->hasPermission('assign-subject-to-teacher');
        });


    }

    public function registerTeacherPolicies($gate){

        Auth::shouldUse('teacher_api');

        $gate->define('view-result', function($teacher){
            return $teacher->hasPermission('view-result');
        });

        $gate->define('single-upload-result', function($teacher){
            return $teacher->hasPermission('single-upload-result');
        });

        $gate->define('batch-upload-result', function($teacher){
            return $teacher->hasPermission('batch-upload-result');
        });

        $gate->define('edit-result', function($teacher){
            return $teacher->hasPermission('edit-result');
        });

        $gate->define('delete-result', function($teacher){
            return $teacher->hasPermission('delete-result');
        });

        $gate->define('view-remarks', function($teacher){
            return $teacher->hasPermission('view-remarks');
        });

        $gate->define('single-upload-remarks', function($teacher){
            return $teacher->hasPermission('single-upload-remarks');
        });

        $gate->define('batch-upload-remarks', function($teacher){
            return $teacher->hasPermission('batch-upload-remarks');
        });

        $gate->define('edit-remarks', function($teacher){
            return $teacher->hasPermission('edit-remarks');
        });

        $gate->define('delete-remarks', function($teacher){
            return $teacher->hasPermission('delete-remarks');
        });

        $gate->define('view-assignment-teacher', function($teacher){
            return $teacher->hasPermission('view-assignment-teacher');
        });
        $gate->define('create-assignment-teacher', function($teacher){
            return $teacher->hasPermission('create-assignment-teacher');
        });

        $gate->define('edit-assignment-teacher', function($teacher){
            return $teacher->hasPermission('edit-assignment-teacher');
        });

        $gate->define('delete-assignment-teacher', function($teacher){
            return $teacher->hasPermission('delete-assignment-teacher');
        });
    }
}
