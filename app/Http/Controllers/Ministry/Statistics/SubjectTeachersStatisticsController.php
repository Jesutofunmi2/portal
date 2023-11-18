<?php

namespace App\Http\Controllers\Ministry\Statistics;

use Auth;
use Gate;
use Excel;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\SubjectCategory;
use App\Models\Teacher\Teacher;
use Illuminate\Http\JsonResponse;
use App\Http\Helper\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Helper\SubjectExcelExport;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\Interfaces\NgStatesLGARepositoryInterface;

class SubjectTeachersStatisticsController extends Controller
{
    protected $school;
    protected $ngstate_lgas;
    protected $subjects;

    public function __construct (
        SchoolRepositoryInterface $school,
        NgStatesLGARepositoryInterface $ngstate_lgas,
        SubjectRepositoryInterface $subjects
    )
    {
        $this->school = $school;
        $this->ngstate_lgas = $ngstate_lgas;
        $this->subjects = $subjects;
    }

    public function teacher (Request $request): JsonResponse
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

        $session = $request->session;

        $categories = SubjectCategory::all();

        $excelData = [];
        
        $school_data = $schools->map(function ($school) use ($session, $categories, &$excelData) {

            $data = [$school->name];

            $teachers = Teacher::where('school_id', $school->id)->get('id');
            $teachers_id = $teachers->map(function ($teacher) { return $teacher->id;})->toArray();

            $category = $categories->map(function ($category) use ($session, $teachers_id, &$data) {
                $subjects = $this->subjects->setSubject()->where('subject_category', $category->id)->get();

                $inner = [];
                $subject_data = $subjects->map(function($subject) use ($session, $teachers_id, &$inner) {
                    $teacher_count = DB::table('classarm_subject')
                    ->where([
                            'session' => $session,
                            'subject_id' => $subject->id,
                            ])
                    ->whereIn('classarm_subject.teacher_id', $teachers_id)
                    ->distinct('teacher_id')
                    ->count();

                    $inner = array_merge($inner,[$teacher_count]);

                    return [
                        'subject' => $subject->subject_name.'('.$subject->class_category.')',
                        'teacher_count' => $teacher_count
                    ];
                });

                $data = array_merge($data,$inner);

                return [
                    'name' => $category->name,
                    'subject_data' =>  $subject_data
                ];
            });

            array_push($excelData, $data);

            return [
                'name' => $school->name,
                'categories' => $category,
            ];
        });

        $header = $this->formatExcelHeader($categories);

        $lga_name = GeneralHelper::getLga($request->lga_id);

        $session = (int) $request->session + 1;
        $msg = strtoupper("Subject-Teacher statistics based on Schools for $lga_name L.G.A  $request->session/$session Academic Session.");

        $url = $this->export($header['data'], $header['subjects_list'], $msg, $excelData);

        return response()->json([
            'data' => $school_data,
            'url' => $url
        ],200);
        
    }

    public function allTeacher (Request $request): JsonResponse
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        
        $this->validate($request, [
            'session' => ['required', 'integer'],
        ]); 

        $subjects = $this->subjects->setSubject()->all();

        $school = $this->school->setSchool();
        $school_table = $school->getTable();

        $state_id = env('STATE_ID');

        $session = $request->session;

        $lgas = $this->ngstate_lgas->findWithStateId($state_id);

        $categories = SubjectCategory::all();

        $excelData = [];

        $school_data = $lgas->map(function ($lga) use ($categories, $session, $school, &$excelData) {

            $data = [$lga->name];

            $schools = $this->school->setSchool()->where('lga_id', $lga->id)->get('id');
            $schools_id = $schools->map(function ($school) { return $school->id;})->toArray();

            $teachers = Teacher::whereIn('school_id', $schools_id)->get('id');
            $teachers_id = $teachers->map(function ($teacher) { return $teacher->id;})->toArray();

            $category = $categories->map(function ($category) use ($session, $teachers_id, &$data) {
                $inner = [];
                $subjects = $this->subjects->setSubject()->where('subject_category', $category->id)->get();

                $subject_data = $subjects->map(function($subject) use ($session, $teachers_id, &$inner) {
                    $teacher_count = DB::table('classarm_subject')
                    ->where([
                            'session' => $session,
                            'subject_id' => $subject->id,
                            ])
                    ->whereIn('classarm_subject.teacher_id', $teachers_id)
                    ->distinct('teacher_id')
                    ->count();

                    $inner = array_merge($inner,[$teacher_count]);
    
                    return [
                        'subject' => $subject->subject_name.'('.$subject->class_category.')',
                        'teacher_count' => $teacher_count
                    ];
                });

                $data = array_merge($data,$inner);

                return [
                    'name' => $category->name,
                    'subject_data' =>  $subject_data
                ];
            });

            array_push($excelData, $data);

            return [
                'lga_name' => $lga->name,
                'categories' => $category,
            ];
        });

        $header = $this->formatExcelHeader($categories);

        $session = (int) $request->session + 1;
        $msg = strtoupper("Subject-Teacher statistics based on L.G.A for Ondo State  $request->session/$session Academic Session.");

        $url = $this->export($header['data'], $header['subjects_list'], $msg, $excelData);

        return response()->json([
            'data' => $school_data,
            'url' => $url
        ],200);
        
    }

    public function export(array $header, array $subjects_list, string $msg, array $data): String
    {
        $filename = 'statistics/subject_stat_'.time().'.xlsx';

        $url = Excel::store(new SubjectExcelExport(
            $header,
            $subjects_list,
            $msg,
            $data
        ), $filename);
        
        return url($filename);
    }

    protected function formatExcelHeader($categories) {
        $data = ['LGA / SCHOOL NAME'];
        $subjects_list = [''];
        $categories->each(function ($category) use (&$data, &$subjects_list) {
            $data = array_merge($data, [$category->name]);

            $subjects = $this->subjects->setSubject()->where('subject_category', $category->id)->get();
            $subjects_count = $subjects->count();

            for ($i=1; $i < $subjects_count; $i++) { 
                $data = array_merge($data, ['']);
            }

            $subjects->each(function ($subject) use (&$subjects_list) {
                $subjects_list = array_merge($subjects_list, ["$subject->subject_name ($subject->class_category)"]);
            });

        });

        return ['data' => $data, 'subjects_list' => $subjects_list];
    }

    protected function permissionDeny($ability){
        $user = Auth::guard('ministry_api')->user();
        if (!$user) return false;
        
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}