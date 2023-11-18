<?php

namespace App\Http\Controllers\Ministry\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Helper\GeneralHelper;
use App\Http\Helper\StudentExcelExport;
use App\Models\Classes;
use App\Repositories\Interfaces\NgStatesLGARepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class LgaStudentStatisticsController extends Controller
{
    public $school;
    public $student;
    public $ngstate_lgas;

    public function __construct (
        SchoolRepositoryInterface $school,
        StudentRepositoryInterface $student,
        NgStatesLGARepositoryInterface $ngstate_lgas
    )
    {
        $this->school = $school;
        $this->student = $student;
        $this->ngstate_lgas = $ngstate_lgas;
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

        $excelData = [];
        
        
        $school_data = $schools->map(function ($school) use ($request, &$excelData) {

            $total_male = 0;
            $total_female = 0;
            $total_unknown = 0;

            $JSS1 = Classes::whereSchoolId($school->id)
                        ->where('class_name', 'like', 'J%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                        })
                        ->get('id');
            $JSS1 = $JSS1->map(function ($jss) { return $jss->id;})->toArray();

            $JSS2 = Classes::whereSchoolId($school->id)->where('class_name', 'like', 'J%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            })
                            ->get('id');
            $JSS2 = $JSS2->map(function ($jss) { return $jss->id;})->toArray();

            $JSS3 = Classes::whereSchoolId($school->id)->where('class_name', 'like', 'J%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                            })
                            ->get('id');
            $JSS3 = $JSS3->map(function ($jss) { return $jss->id;})->toArray();

            $SSS1 = Classes::whereSchoolId($school->id)
                            ->where('class_name', 'like', 'S%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                            })
                            ->get('id');
            $SSS1 = $SSS1->map(function ($sss) { return $sss->id;})->toArray();

            $SSS2 = Classes::whereSchoolId($school->id)
                            ->where('class_name', 'like', 'S%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                            })
                            ->get('id');
            $SSS2 = $SSS2->map(function ($sss) { return $sss->id;})->toArray();

            $SSS3 = Classes::whereSchoolId($school->id)
                            ->where('class_name', 'like', 'S%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                            })
                            ->get('id');
            $SSS3 = $SSS3->map(function ($sss) { return $sss->id;})->toArray();

            $classes = [
                    [
                        'class_name' => 'JSS 1',
                        'class_ids' => $JSS1
                    ],
                    [
                        'class_name' => 'JSS 2',
                        'class_ids' => $JSS2
                    ],
                    [
                        'class_name' => 'JSS 3',
                        'class_ids' => $JSS3
                    ],
                    [
                        'class_name' => 'SSS 1',
                        'class_ids' => $SSS1
                    ],
                    [
                        'class_name' => 'SSS 2',
                        'class_ids' => $SSS2
                    ],
                    [
                        'class_name' => 'SSS 3',
                        'class_ids' => $SSS3
                    ]
                ];
            
            $excel = [strtoupper($school->name)];
            $classes = collect($classes);

            $student_by_class = $classes->map(function ($class) use ($request, $school, &$excel, &$total_male, &$total_female, &$total_unknown) {
                
                $male_students = DB::table('classarm_student')
                ->where([
                        'classarm_student.session' => $request->session,
                        'class_arms.school_id' => $school->id,
                        'students.gender' => 'Male'
                        ])
                ->whereIn('classarm_student.class_id', $class['class_ids'])
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
                ->whereIn('classarm_student.class_id', $class['class_ids'])
                ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
                ->join('students', 'students.id', '=', 'classarm_student.student_id')
                ->distinct('classarm_student.student_id')
                ->count();

                $unknown_gender = DB::table('classarm_student')
                ->where([
                        'classarm_student.session' => $request->session,
                        'class_arms.school_id' => $school->id,
                        ])
                ->whereIn('classarm_student.class_id', $class['class_ids'])
                ->whereNotIn('students.gender', ['Male','Female'])
                ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
                ->join('students', 'students.id', '=', 'classarm_student.student_id')
                ->distinct('classarm_student.student_id')
                ->count();

                $all_students = $male_students + $female_students;

                $excel = array_merge($excel, [$male_students, $female_students, $unknown_gender, $all_students]);

                $total_male += $male_students;
                $total_female += $female_students;
                $total_unknown += $unknown_gender;

                return [
                    'class_name' => $class['class_name'],
                    'total_students' => $all_students,
                    'male_students' => $male_students,
                    'female_students' => $female_students,
                    'unknown_gender' => $unknown_gender,
                ];

            });

            $total_student = $total_male + $total_female + $total_unknown;

            $excel = array_merge($excel, ['', $total_male, $total_female, $total_unknown, $total_student]);

            array_push($excelData, $excel);
           
            return [
                'name' => strtoupper($school->name),
                'classes' => $student_by_class,
                'total_student' => $total_student,
                'total_male' => $total_male,
                'total_female' => $total_female,
                'total_unknown' => $total_unknown,
            ];
          });

          $lga_name = GeneralHelper::getLga($request->lga_id);

          $session = (int) $request->session + 1;
          $msg = strtoupper("Students statistics based on Schools for $lga_name L.G.A  $request->session/$session Academic Session.");

          $url = $this->export($excelData, $msg);

        return response()->json([
            'data' => $school_data,
            'url' => $url
        ],200);
        
    }

    public function allStudent (Request $request): JsonResponse
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'session' => ['required', 'integer'],
        ]); 

        $students = $this->student->setStudent();

        $school = $this->school->setSchool();
        $school_table = $school->getTable();
        
        $state_id = env('STATE_ID');
        $lgas = $this->ngstate_lgas->findWithStateId($state_id);
        $excelData = [];

        $classes = collect($this->getClasses());

        $data = $lgas->map(function ($lga) use ($request, $classes, $school, &$excelData) {

            $school_ids = $school->where('lga_id', $lga->id)->get('id');
            $lga_school_ids = $school_ids->map(function ($school) { return $school->id; })->toArray();

            $session = $request->session;
            $excel = [strtoupper($lga->name)];

            $total_male = 0;
            $total_female = 0;
            $total_unknown = 0;

            $class_data = $classes->map(function ($class) use ($lga_school_ids, $session, &$excel, &$total_male, &$total_female, &$total_unknown) {
                
                $male_students = DB::table('classarm_student')
                        ->where([
                            'classarm_student.session' =>  $session,
                            'students.gender' => 'Male'
                        ])
                        ->whereIn('classarm_student.class_id', $class['class_ids'])
                        ->whereIn('class_arms.school_id', $lga_school_ids)
                        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
                        ->join('students', 'students.id', '=', 'classarm_student.student_id')
                        ->distinct('classarm_student.student_id')
                        ->count();

                $female_students = DB::table('classarm_student')
                        ->where([
                            'classarm_student.session' =>  $session,
                            'students.gender' => 'Female'
                        ])
                        ->whereIn('classarm_student.class_id', $class['class_ids'])
                        ->whereIn('class_arms.school_id', $lga_school_ids)
                        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
                        ->join('students', 'students.id', '=', 'classarm_student.student_id')
                        ->distinct('classarm_student.student_id')
                        ->count();

                $unknown_gender = DB::table('classarm_student')
                        ->where('classarm_student.session',  $session,)
                        ->whereIn('classarm_student.class_id', $class['class_ids'])
                        ->whereIn('class_arms.school_id', $lga_school_ids)
                        ->whereNotIn('students.gender', ['Male','Female'])
                        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
                        ->join('students', 'students.id', '=', 'classarm_student.student_id')
                        ->distinct('classarm_student.student_id')
                        ->count();
                
                $all_students = $male_students + $female_students;
                
                $excel = array_merge($excel, [$male_students, $female_students, $unknown_gender, $all_students]);

                $total_male += $male_students;
                $total_female += $female_students;
                $total_unknown += $unknown_gender;


                return [
                    'class_name' => $class['class_name'],
                    'total_students' => $all_students,
                    'male_students' => $male_students,
                    'female_students' => $female_students,
                    'unknown_gender' => $unknown_gender,
                ];
            });

            $total_student = $total_male + $total_female + $total_unknown;
            $excel = array_merge($excel, ['', $total_male, $total_female, $total_unknown, $total_student]);

            array_push($excelData, $excel);
            return [
                'lga_name' => strtoupper($lga->name),
                'class_data' => $class_data,
                'total_student' => $total_student,
                'total_male' => $total_male,
                'total_female' => $total_female,
                'total_unknown' => $total_unknown,
            ];

        });

        $session = (int) $request->session + 1;
        $msg = strtoupper("Students statistics based on L.G.A for Ondo State $request->session/$session Academic Session");

        $url = $this->export($excelData, $msg);

        return response()->json([
            'data' => $data,
            'url' => $url
        ],200);
        
    }

    protected function getClasses(): Array
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        
        $JSS1 = Classes::where('class_name', 'like', 'J%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                        })
                        ->get('id');
        $JSS1 = $JSS1->map(function ($jss) { return $jss->id;})->toArray();

        $JSS2 = Classes::where('class_name', 'like', 'J%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                        })
                        ->get('id');
        $JSS2 = $JSS2->map(function ($jss) { return $jss->id;})->toArray();

        $JSS3 = Classes::where('class_name', 'like', 'J%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                        })
                        ->get('id');
        $JSS3 = $JSS3->map(function ($jss) { return $jss->id;})->toArray();

        $SSS1 = Classes::where('class_name', 'like', 'S%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%1%')->orWhere('class_name', 'like', '%one%');
                        })
                        ->get('id');
        $SSS1 = $SSS1->map(function ($sss) { return $sss->id;})->toArray();

        $SSS2 = Classes::where('class_name', 'like', 'S%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%2%')->orWhere('class_name', 'like', '%two%');
                        })
                        ->get('id');
        $SSS2 = $SSS2->map(function ($sss) { return $sss->id;})->toArray();

        $SSS3 = Classes::where('class_name', 'like', 'S%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%3%')->orWhere('class_name', 'like', '%three%');
                        })
                        ->get('id');
        $SSS3 = $SSS3->map(function ($sss) { return $sss->id;})->toArray();

        return [
            [
                'class_name' => 'JSS 1',
                'class_ids' => $JSS1
            ],
            [
                'class_name' => 'JSS 2',
                'class_ids' => $JSS2
            ],
            [
                'class_name' => 'JSS 3',
                'class_ids' => $JSS3
            ],
            [
                'class_name' => 'SSS 1',
                'class_ids' => $SSS1
            ],
            [
                'class_name' => 'SSS 2',
                'class_ids' => $SSS2
            ],
            [
                'class_name' => 'SSS 3',
                'class_ids' => $SSS3
            ]
        ];
    }

    protected function permissionDeny($ability){
        $user = Auth::guard('ministry_api')->user();
        if (!$user) return false;
        
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

    public function export(array $data, string $msg): String
    {
        $filename = 'statistics/student_stat_'.time().'.xlsx';

        $url = Excel::store(new StudentExcelExport(
            $data,
            $msg
        ), $filename);
        
        return url('codeBase/public/'.$filename);
    }


}