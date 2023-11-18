<?php

namespace App\Http\Controllers\Ministry\Statistics;

use Auth;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SchoolRepositoryInterface;

class LgaBroadSubjectStatisticsController extends Controller
{
    public $school;
    public $lga_teachers;

    public function __construct (
        SchoolRepositoryInterface $school)
    {
        $this->school = $school;
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
        ]); 

        $school = $this->school->setSchool();

        $schools = $school
            ->where('lga_id', $request->lga_id)
            ->get(['id', 'name']);

            $school_data = $schools->map(function($school) use ($request){

                $subject_teacher_list = DB::table('classarm_subject')
                ->select('classarm_subject.id', 'classarm_subject.classarm_id', 'classes.class_name', 'class_arms.class_arm', 'subjects.subject_name', 'teachers.title', 'teachers.firstname', 'teachers.surname', 'teachers.gender')
                ->where('class_arms.school_id', $school->id)
                ->join('teachers', 'classarm_subject.teacher_id', '=', 'teachers.id')
                ->join('subjects', 'subjects.id', '=', 'classarm_subject.subject_id')
                ->join('class_arms', 'class_arms.id', '=', 'classarm_subject.classarm_id')
                ->join('classes', 'classes.id', '=', 'class_arms.class_id')
                ->orderBy('subjects.subject_name', 'ASC')
                ->get(); 

                $subjects = $subject_teacher_list->map(function($subject){
                    return [
                        'class' => $subject->class_name,
                        'class_arm' => $subject->class_arm,
                        'subject_name' => $subject->subject_name,
                        'teacher_name' => $subject->title.' '.$subject->surname.' '.$subject->firstname,
                    ];
                });
    
                return [
                    'name' => $school->name,
                    'subjects' => $subjects
                ];
    
            });

        return response()->json([
                    'data' => $school_data
                ]);
       
    }

    protected function permissionDeny($ability){
        $user = Auth::guard('ministry_api')->user();
        if (!$user) return false;
        
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}