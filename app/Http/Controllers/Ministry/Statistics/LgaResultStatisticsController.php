<?php

namespace App\Http\Controllers\Ministry\Statistics;

use App\Http\Controllers\Controller;
use App\Models\ClassArms;
use App\Models\Classes;
use App\Models\StudentResult;
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

class LgaResultStatisticsController extends Controller
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
            'term' => ['required', 'string'],
        ]); 

        $students = $this->student->setStudent();

        $school = $this->school->setSchool();
        $school_table = $school->getTable();

        $schools = $school
            ->where('lga_id', $request->lga_id)
            ->get(['id', 'name']);
            
        $school_data = $schools->map(function($school) use ($request) {
        
            $students_all = $school->schoolStudent
                            ->count();

            $school_session_results = StudentResult::where([
                'school_id' => $school->id,
                'session' => $request->session,
                'term' => $request->term
            ])->count();
            
            $color_indicator = ($school_session_results > 0) ? 'result_green.gif': 'result_red.jpg';

            $color_indicator_img = env('BASE_PATH').'images/'.$color_indicator;
                    
            $students_with_results_count = StudentResult::where([
                                                'school_id' => $school->id,
                                                'session' => $request->session,
                                                'term' => $request->term,
                                                ])
                                                ->distinct('student_id')
                                                ->count();
                
            $results_classarm_list = StudentResult::select('classarm_id', 'class_id')
                                                ->where('school_id', $school->id)
                                                ->where('session', $request->session)
                                                ->where('term', $request->term)
                                                ->groupBy('classarm_id')
                                                ->get();     
            
            $classarm_data = $results_classarm_list->map(function($results_classarm) use ($request, $school) {
                    $classarm_id = $results_classarm->classarm_id;
                    $class_id = $results_classarm->class_id;
                            
                    $classarm_session_results = StudentResult::where('school_id', $school->id)
                                                        ->where('session', $request->session)
                                                        ->where('term', $request->term)
                                                        ->where('classarm_id', $classarm_id)
                                                        ->distinct('student_id')
                                                        ->count();
                                                    
                    $class_name = $this->getClassNameByClassID($class_id) ;
                    $classarm_name = $this->getClassArmNameByClassArmID($classarm_id);

                    return [
                        'class_id' => $class_id,
                        'classarm_id' => $classarm_id,
                        'class_name' => $class_name,
                        'classarm_name' => $classarm_name,
                        'classarm_count' => $classarm_session_results
                    ];
            });
            
            $classarm_list = $classarm_data->map(function($class){
                return $class['class_name'].' '.$class['classarm_name'].': '.$class['classarm_count'].' Student\'s Result';
            });

            $release_data = $classarm_data->map(function ($class) use ($request, $school) {
                $classarm_id = $class['classarm_id'];
                $class_id = $class['class_id'];
                
                $classarm_released_results = StudentResult::where('school_id', $school->id)
                                            ->where('session', $request->session)
                                            ->where('term', $request->term)
                                            ->where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('status', 1)
                                            ->distinct('student_id')
                                            ->count();

                return $class['class_name'].' '.$class['classarm_name'].': '.$classarm_released_results.' Student\'s Result';  
            });

            return [
                'name' => $school->name,
                'total_students' => $students_all,
                'total_result_by_student' => $students_with_results_count,
                'total_result_by_arm' => $classarm_list,
                'release_result' => $release_data,
                'indicator' => $color_indicator_img
            ];
        });

        return response()->json([
            'data' => $school_data
        ],200);
        
    }

    public function getClassNameByClassID($class_id){

        $classes = Classes::find($class_id);
    
        $class_name = (!empty($classes->class_name)) ? $classes->class_name: '';
        return $class_name;
    }
    
    public function getClassArmNameByClassArmID($classarm_id){
    
        $classarm = ClassArms::find($classarm_id);
    
        return $classarm ? $classarm->class_arm : 'Not found';
    }

    protected function permissionDeny($ability){
        $user = Auth::guard('ministry_api')->user();
        if (!$user) return false;
        
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}