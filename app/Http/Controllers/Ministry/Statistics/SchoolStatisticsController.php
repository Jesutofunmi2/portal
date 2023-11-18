<?php

namespace App\Http\Controllers\Ministry\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\HelperController;
use App\Http\Resources\MinistrySchoolResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolStatisticsController extends Controller
{
    public $school;
    public $teacher;
    public $student;
    public $schoolAdmin;

    public function __construct (
        SchoolRepositoryInterface $school,
        TeacherRepositoryInterface $teacher,
        StudentRepositoryInterface $student,
        AdminRepositoryInterface $schoolAdmin
    )
    {
        $this->school = $school;
        $this->teacher = $teacher;
        $this->student = $student;
        $this->schoolAdmin = $schoolAdmin;
    }

    public function overall (Request $request): JsonResponse
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $user = Auth::guard('ministry_api')->user();

        $school_ids = [];

        if($user && $user->is_aeozeo) {
            $school_ids = HelperController::aeozeoSchoolsId($user->lgas);
        }

        $schools = $this->school->setSchool();
        $teachers = $this->teacher->setTeacher();
        $students = $this->student->setStudent();

        $total_schools = $schools->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($user) {
                            return $q->whereIn('lga_id', $user->lgas);
                        })
                        ->count();

        $total_teachers = $teachers->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->count();

        $total_male_teachers = $teachers->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->where('gender','Male')
                        ->count();

        $total_female_teachers = $teachers->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->where('gender','Female')
                        ->count();

        $total_students = $students->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->count();

        $total_male_students = $students->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->where('gender','Male')
                        ->count();

        $total_female_students = $students->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->where('gender','Female')
                        ->count();

        $unknown_gender_students = $students->query()
                        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
                            return $q->whereIn('school_id', $school_ids);
                        })
                        ->whereNotIn('gender',['Male', 'Female'])
                        ->count();


        return response()->json([
                    'data' => [
                        'total_schools' => $total_schools,
                        'total_teachers' => $total_teachers,
                        'total_male_teachers' => $total_male_teachers,
                        'total_female_teachers' => $total_female_teachers,
                        'total_students' => $total_students,
                        'total_female_students' => $total_female_students,
                        'total_male_students' => $total_male_students,
                        'unknown_gender_students' => $unknown_gender_students
                        ]
                ],200);
        
    }

    public function allSchools (Request $request): AnonymousResourceCollection
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $user = Auth::guard('ministry_api')->user();

        $schools = $this->school->setSchool()->query()
            ->when($user && $user->is_aeozeo, function($q) use ($user) {
                return $q->whereIn('lga_id', $user->lgas);
            })
            ->when($request->lga_id, function ($query, $id) {
                return $query->where('lga_id', $id);
            })
            ->paginate(40);


        return MinistrySchoolResource::collection($schools);
        
    }

    public function school (Request $request, $schoolId): JsonResponse
    {
        if($this->permissionDeny('view-statistics')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        
        if(! is_numeric($schoolId)){
            abort(400, 'An error occur, unknown School-ID');
        }

        $schools = $this->school->setSchool();
        
        $school =  $schools->find($schoolId);
        $school = new MinistrySchoolResource($school);

        $schoolAdmin = $this->schoolAdmin->setAdmin()->where('school_id', $schoolId)->count();

        $teachers = $this->teacher->setTeacher();
        $students = $this->student->setStudent();

        $total_teachers = $teachers->where('school_id', $schoolId)->count();
        $total_male_teachers = $teachers->where(['school_id' => $schoolId, 'gender' => 'Male'])->count();
        $total_female_teachers = $teachers->where(['school_id' => $schoolId, 'gender' => 'Female'])->count();

        $total_students = $students->where('school_id', $schoolId)->count();
        $total_male_students = $students->where(['school_id' => $schoolId, 'gender' => 'Male'])->count();
        $total_female_students = $students->where(['school_id' => $schoolId, 'gender' => 'Female'])->count();
        $unknown_gender_students = $students->where('school_id', $schoolId)->whereNotIn('gender',['Male', 'Female'])->count();


        return response()->json([
                    'data' => [
                        'school' => $school,
                        'schoolAdmin' => $schoolAdmin,
                        'total_teachers' => $total_teachers,
                        'total_male_teachers' => $total_male_teachers,
                        'total_female_teachers' => $total_female_teachers,
                        'total_students' => $total_students,
                        'total_female_students' => $total_female_students,
                        'total_male_students' => $total_male_students,
                        'unknown_gender_students' => $unknown_gender_students
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