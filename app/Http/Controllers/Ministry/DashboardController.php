<?php

namespace App\Http\Controllers\Ministry;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\HelperController;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\NgStatesLGARepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    protected $superadmin;
    protected $school;
    protected $admin;
    protected $student;
    protected $ngstate_lgas;
    protected $teachers;
    protected $subjects;

    public function __construct(
        SuperAdminRepositoryInterface $superadmin,
        SchoolRepositoryInterface $school,
        AdminRepositoryInterface $admin,
        StudentRepositoryInterface $student,
        NgStatesLGARepositoryInterface $ngstate_lgas,
        TeacherRepositoryInterface $teachers,
        SubjectRepositoryInterface $subjects
        )
    {

        $this->superadmin = $superadmin;
        $this->school = $school;
        $this->admin = $admin;
        $this->student = $student;
        $this->ngstate_lgas = $ngstate_lgas;
        $this->teachers = $teachers;
        $this->subjects = $subjects;

        $this->middleware('auth:ministry_api');
    }

    public function appStat()
    {
        $user = Auth::guard('ministry_api')->user();

        $school_ids = [];

        if($user && $user->is_aeozeo) {
            $school_ids = HelperController::aeozeoSchoolsId($user->lgas);
        }

        $totalSchool = $this->school->setSchool()
                                    ->when($user && $user->is_aeozeo, function($q) use ($user) {
                                        return $q->whereIn('lga_id', $user->lgas);
                                    })
                                    ->count();

        $totalTeacher = $this->teachers->setTeacher()
                                    ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                                        return $q->whereIn('school_id', $school_ids);
                                    })
                                    ->count();

        $totalStudent = $this->student->setStudent()
                                    ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                                        return $q->whereIn('school_id', $school_ids);
                                    })
                                    ->count();

        $totalMinistryAdmin = $this->superadmin->setSuperAdmin()->count();
        
        $totalSchoolAdmin = $this->admin->setAdmin()
                                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                                            return $q->whereIn('school_id', $school_ids);
                                        })
                                        ->count();

        $subjects = $this->subjects->setSubject()->count();
        $state_id = env('STATE_ID');
        $total_lgas = $this->ngstate_lgas->findWithStateId($state_id)->count();
        
        $session = env('CURRENT_SESSION');

        $currentSessionTotalStudent = $this->student->setStudent()
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('students.school_id', $school_ids);
                        })
                        ->distinct('classarm_student.student_id')
                        ->count();

        return response()->json(['data' => [
           'totalSchool' => $totalSchool,
           'totalTeacher' => $totalTeacher,
           'totalStudent' => $totalStudent,
           'totalMinistryAdmin' => $totalMinistryAdmin,
           'totalSchoolAdmin' => $totalSchoolAdmin,
           'total_lgas' => $total_lgas,
           'totalSubject' => $subjects,
           'currentSessionTotalStudent' => $currentSessionTotalStudent,
           'currentSession' => $session
        ]]);
    }

    public function studentSummary(Request $request)
    {
        $user = Auth::guard('ministry_api')->user();

        $state_id = env('STATE_ID');
        $session = env('CURRENT_SESSION');

        if($user && $user->is_aeozeo) {
            $lgas = $this->ngstate_lgas->setNgStatesLGA()->query()
            ->where('state_id', $state_id)
            ->whereIn('id', $user->lgas)
            ->get();
        }
        else {
            $lgas = $this->ngstate_lgas->findWithStateId($state_id);
        }

        $lga_summary = $lgas->map(function($lga) use ($session) {

            $school_ids = HelperController::aeozeoSchoolsId([$lga->id]);

            $lga_student_count = $this->student->setStudent()
                ->whereIn('students.school_id', $school_ids)
                ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                ->where('classarm_student.session', $session)
                ->distinct('classarm_student.student_id')
                ->count();

            return [
                'lga_id' => $lga->id,
                'lga_name' => $lga->name,
                'lga_student_count' => $lga_student_count
            ];
        });

        return response()->json(['data' => [
            'lga_summary' => $lga_summary,
            'currentSession' => $session
        ]]);
    }

}
