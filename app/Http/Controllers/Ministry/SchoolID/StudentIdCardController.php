<?php

namespace App\Http\Controllers\Ministry\SchoolID;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Http\Resources\IdCardResource;
use App\Http\Resources\StudentCollection;
use App\Models\Classes;
use App\Models\DigitalPayment;
use App\Models\School;
use App\Models\StudentIDCardRequest;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StudentIdCardController extends Controller
{
    protected $students;

    /**
    * Class Repository class
    * @var obj
    */
    protected $clas;

    public function __construct(StudentRepositoryInterface $students,
                            ClassRepositoryInterface $clas)
    {

        $this->middleware('auth:ministry_api');

        $this->students = $students;
        $this->clas = $clas;

    }

    // get id card request statistics
    public function statistics(Request $request, int $school_id): JsonResponse
    {
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate(['session' => ['required', 'integer']]);

        $schoolRequest = new StudentIDCardRequest;

        $all = $schoolRequest::where([
                                    'school_id'=> $school_id,
                                    'session' => $request->session,
                                    ])->count();

        $approved = $schoolRequest::where([
                                        'school_id' => $school_id,
                                        'session' => $request->session,
                                        'is_verified' => true,
                                        'is_downloaded' => false ])
                                    ->count();

        $pending = $schoolRequest::where([
                                        'is_verified' => false,
                                        'is_downloaded' => false,
                                        'session' => $request->session,
                                        'school_id' => $school_id ])
                                        ->count();

        $download = $schoolRequest::where([
                                        'is_verified' => true,
                                        'is_downloaded' => true,
                                        'session' => $request->session,
                                        'school_id' => $school_id,
                                        ])
                                    ->count();

        return response()->json([
            'data' => [
                'all' => $all,
                'pending' => $pending,
                'approved' => $approved,
                'download' => $download,
            ]
        ]);
    }

    // get approved id card request
    public function approved(Request $request, int $school_id)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate(['session' => ['required', 'integer']]);
        
        $students = StudentIDCardRequest::query()
            ->select('students.id', 'students.surname',
                        'students.firstname', 'students.regnum',
                        'students.middlename')
            ->where([
                    'student_id_card_requests.school_id' => $school_id,
                    'student_id_card_requests.session' => $request->session,
                    'student_id_card_requests.is_verified' => true,
                    'student_id_card_requests.is_downloaded' => false,
                    ])
            ->join('students', 'students.id', '=', 'student_id_card_requests.student_id')
            ->paginate(40);

        return IdCardResource::collection($students);
    }

    // get pending id card request
    public function pending(Request $request, int $school_id)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate(['session' => ['required', 'integer']]);

        $students = StudentIDCardRequest::query()
            ->select('students.id', 'students.surname',
                        'students.firstname', 'students.regnum',
                        'students.middlename')
            ->where([
                    'student_id_card_requests.school_id' => $school_id,
                    'student_id_card_requests.session' => $request->session,
                    'student_id_card_requests.is_verified' => false,
                    'student_id_card_requests.is_downloaded' => false,
                    ])
            ->join('students', 'students.id', '=', 'student_id_card_requests.student_id')
            ->paginate(40);

        return IdCardResource::collection($students);
    }

    // get downloaded id card request
    public function downloaded(Request $request, int $school_id)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate(['session' => ['required', 'integer']]);

        $students = StudentIDCardRequest::query()
            ->select('student_id')
            ->where([
                    'school_id' => $school_id,
                    'session' => $request->session,
                    'is_downloaded' => true,
                    'is_verified' => true
                    ])
            ->paginate(40);

        $students_list = $students->map(function ($student) {

            $student = $this->students->find($student->student_id);

            $student_class =  $student->classarms()->wherePivot('session', '=', $student->session)
                ->orderBy('term', 'desc')
                ->first();

            // class id is found
            if ($student_class) {
                $class = optional(Classes::find($student_class->class_id))->class_name;
                $class_arm = $student_class->class_arm;
                $session = $student_class->pivot->session;
            }
            else {
                $class = 'N/A';
                $class_arm = 'N/A';
                $session = 'N/A';
            }
            
            return [
                'id' => $student->id,
                'fullname' => "$student->surname $student->firstname $student->middlename",
                'regnum' => $student->regnum,
                'class' => $class,
                'class_arm' => $class_arm,
                'session' => $session
            ];
        });

        return IdCardResource::collection($students)->additional([
            'students' => $students_list
        ]);
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}