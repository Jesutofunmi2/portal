<?php

namespace App\Http\Controllers\Ministry\Statistics;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LgaBroadSchoolStatisticsController extends Controller
{
    public $school;
    public $teacher;
    public $student;
    public $class_arm;
    public $classes;

    public function __construct (
        SchoolRepositoryInterface $school,
        TeacherRepositoryInterface $teacher,
        StudentRepositoryInterface $student,
        ClassArmRepositoryInterface $class_arm, 
        ClassRepositoryInterface $classes
    )
    {
        
        $this->school = $school;
        $this->teacher = $teacher;
        $this->student = $student;
        $this->classes = $classes;
        $this->class_arm = $class_arm;
    }

    public function index (Request $request): JsonResponse
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        
        $this->validate($request, [
            'lga_id' => ['required', 'integer'],
            'session' => ['required', 'integer'],
        ]); 

        $school = $this->school->setSchool();
        $school_table = $school->getTable();

        $schools = $school
            ->where('lga_id', $request->lga_id)
            ->get(['id', 'name']);

        $lga_female_students = $school->where([$school_table.'.lga_id' => $request->lga_id,
                                                'classarm_student.session' => $request->session,
                                                'students.gender' => 'Female'
                                            ])
                                        ->join('students', $school_table.'.id', '=', 'students.school_id')
                                        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                                        ->distinct('classarm_student.student_id')
                                        ->count();

        $lga_male_students = $school->where([$school_table.'.lga_id' => $request->lga_id,
                                            'classarm_student.session' => $request->session,
                                            'students.gender' => 'Male'
                                            ])
                                    ->join('students', $school_table.'.id', '=', 'students.school_id')
                                    ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                                    ->distinct('classarm_student.student_id')
                                    ->count();

        $lga_unknown_gender = $school->where([$school_table.'.lga_id' => $request->lga_id, 'classarm_student.session' => $request->session])
                                    ->whereNotIn('students.gender' ,['Male', 'Female'])
                                    ->join('students', $school_table.'.id', '=', 'students.school_id')
                                    ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                                    ->distinct('classarm_student.student_id')
                                    ->count();

        $lga_students = $lga_female_students + $lga_male_students;
        
        $lga_teachers = $school->where([
                                    $school_table.'.lga_id' => $request->lga_id,
                                    ])
                                ->join('teachers', 'teachers.school_id', '=', $school_table.'.id')
                                ->count();
        
        $lga_female_teachers = $school->where([
                                        $school_table.'.lga_id' => $request->lga_id,
                                        'teachers.gender' => 'Female',
                                        ])
                                ->join('teachers', 'teachers.school_id', '=', $school_table.'.id')
                                ->count();
          
        $lga_male_teachers = $school->where([
                                    $school_table.'.lga_id' => $request->lga_id,
                                    'teachers.gender' => 'Male',
                                    ])
                                ->join('teachers', 'teachers.school_id', '=', $school_table.'.id')
                                ->count();
        
        $school_data = $schools->map(function ($school) use ($request) {

            $male_students = DB::table('classarm_student')
            ->where([
                    'classarm_student.session' => $request->session,
                    'class_arms.school_id' => $school->id,
                    'students.gender' => 'Male'
                    ])
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('students', 'students.id', '=', 'classarm_student.student_id')
            ->distinct('classarm_student.student_id')
            ->count();

            $female_students = DB::table('classarm_student')
            ->where([
                    'classarm_student.session' => $request->session,
                    'class_arms.school_id' => $school->id,
                    'students.gender' => 'Female'
                    ])
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('students', 'students.id', '=', 'classarm_student.student_id')
            ->distinct('classarm_student.student_id')
            ->count();

            $unknown_gender = DB::table('classarm_student')
            ->where([
                    'classarm_student.session' => $request->session,
                    'class_arms.school_id' => $school->id,
                    ])
            ->whereNotIn('students.gender', ['Male','Female'])
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('students', 'students.id', '=', 'classarm_student.student_id')
            ->distinct('classarm_student.student_id')
            ->count();

            $students_all =  $male_students + $female_students;

            $total_teachers = DB::table('teachers')->where(['school_id' => $school->id])
                                ->count();

            $male_teachers = DB::table('teachers')
                                ->where([
                                    'school_id' => $school->id,
                                    'gender' => 'Male'
                                    ])
                                ->count();
                                            
            $female_teachers = DB::table('teachers')
                                ->where([
                                    'school_id' => $school->id,
                                    'gender' => 'Female'
                                    ])
                                ->count();

            $admins = $school->schoolAdmin;

            $adminUser = $admins->map(function ($admin) { return $admin->fullname.' | '.$admin->phone; });

            $classes = $this->classes->setClass()
                                        ->where('school_id', $school->id)
                                        ->get();
            
            $session = $request->session;
            $class_details = $classes->map(function($class) use ($session, $school) {

                $class_id = $class->id;
                $class_name = $class->class_name;

                $class_arms = $this->class_arm->setClassArms()
                                    ->where('school_id', $school->id)
                                    ->where('class_id', $class_id)
                                    ->get();

                    $classes_count = $class_arms->map(function($class_arm) use ($class_name, $class_id, $session) {
                        $class_arm_id = $this->class_arm->find($class_arm->id);
                        $class_arm_students = $class_arm_id->students()
                                ->wherePivot('session', $session)
                                ->wherePivot('class_id', $class_id)
                                ->distinct('student_id')
                                ->count();
                        return $class_name.' '.$class_arm->class_arm.': '.$class_arm_students;
                    });

                return  [
                    'class' => $classes_count
                ];

            });
            
            return [
                'name' => $school->name,
                'total_students' => $students_all,
                'male_students' => $male_students,
                'female_students' => $female_students,
                'unknown_gender' => $unknown_gender,
                'total_teachers' => $total_teachers,
                'male_teachers' => $male_teachers,
                'female_teachers' => $female_teachers,
                'adminUsers' => $adminUser,
                'classes' => $class_details
            ];
          });

        return response()->json([
            'data' => [
                'lga_students' => $lga_students,
                'lga_male_students' => $lga_male_students,
                'lga_female_students' => $lga_female_students,
                'lga_unknown_gender' => $lga_unknown_gender,
                'total_teachers' => $lga_teachers,
                'lga_male_teachers' => $lga_male_teachers,
                'lga_female_teachers' => $lga_female_teachers,
                'schools' => $school_data
            ]
        ],200);
        
    }

    protected function permissionDeny($ability){
        $user = Auth::guard('ministry_api')->user();
        if (!$user) return false;
        
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}