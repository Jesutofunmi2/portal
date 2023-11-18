<?php

namespace App\Http\Controllers\Ministry\Statistics;

use Auth;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MinistrySchoolResource;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LgaSchoolStatisticsController extends Controller
{
    public $school;
    public $teacher;
    public $student;

    public function __construct (
        SchoolRepositoryInterface $school,
        TeacherRepositoryInterface $teacher,
        StudentRepositoryInterface $student
    )
    {
        $this->school = $school;
        $this->teacher = $teacher;
        $this->student = $student;
    }

    public function student (Request $request): JsonResponse
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

        $students = $this->student->setStudent();

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

            $students_all = $male_students + $female_students;
            
            return [
                'name' => $school->name,
                'total_students' => $students_all,
                'male_students' => $male_students,
                'female_students' => $female_students,
                'unknown_gender' => $unknown_gender,
            ];
          });

        return response()->json([
            'data' => [
                'lga_students' => $lga_students,
                'lga_male_students' => $lga_male_students,
                'lga_female_students' => $lga_female_students,
                'lga_unknown_gender' => $lga_unknown_gender,
                'schools' => $school_data
            ]
        ],200);
        
    }

    public function teacher(Request $request): JsonResponse
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
                                    
        $teacher_data = $schools->map(function ($school) use ($request) {

                        $class_teachers = DB::table('classarm_teacher')
                                        ->where([
                                            'classarm_teacher.session' => $request->session,
                                            'class_arms.school_id' => $school->id
                                            ])
                                        ->join('class_arms', 'class_arms.id', '=', 'classarm_teacher.classarm_id')
                                        ->count();

                        $subject_teachers = DB::table('subject_teacher')
                                        ->where('school_id', $school->id)
                                        ->count();
                    
                       
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

                         // getting subjects, subject_teachers count and subject teachers
                        $school_subjects = DB::table('subjects')
                                        ->select('subject_teacher.subject_id', 'subjects.subject_name', 'subjects.class_category')
                                        ->join('subject_teacher', 'subject_teacher.subject_id', '=', 'subjects.id')
                                        ->where('subject_teacher.school_id', $school->id)
                                        ->distinct('subject_teacher.subject_id')
                                        ->get();
                                       

                        $subject_list = $school_subjects->map(function($subject) use ($school) {

                                        $subject_id = $subject->subject_id;  
                                        $teachers_count = DB::table('subject_teacher')
                                        ->where(['subject_id' => $subject_id, 'school_id' => $school->id])
                                        ->count();
                                    
                                        return [
                                            'subject' => '('.$subject->class_category.') '.$subject->subject_name.': '.$teachers_count.' Teacher(s)'
                                        ];

                        });

                                       
                        
                        return [
                                'name' => $school->name,
                                'total_teachers' => $total_teachers,
                                'male_teachers' => $male_teachers,
                                'female_teachers' => $female_teachers,
                                'class_teachers' => $class_teachers,
                                'subject_teachers' => $subject_teachers,
                                'subjects' => $subject_list
                            ];
                        });

        return response()->json([
                    'data' => [
                        'total_teachers' => $lga_teachers,
                        'lga_male_teachers' => $lga_male_teachers,
                        'lga_female_teachers' => $lga_female_teachers,
                        'schools' => $teacher_data
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