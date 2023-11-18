<?php

namespace App\Http\Controllers\Teacher\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Http\Resources\SubjectResource;
use Auth;
use Gate;

class ViewSubjectController extends Controller
{
    /**
    * Teacher Repository class
    * @var obj $teach
    */
    protected $teach;

    /**
    * Subject Repository class
    * @var obj $teach
    */
    protected $subject;

    /**
    * Initialise Controller
    */
    public function __construct(TeacherRepositoryInterface $teacher, 
    SubjectRepositoryInterface $subject) {
        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;
        $this->subject = $subject;
    }

    /**
    * Retrieve all Subjects for a Teacher
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {
        /*
        if($this->permissionDeny('view-subject')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        */
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();
        //Get teacher
        $teacher = $this->teach->setTeacher()
        ->with(['subjects' => function ($query) use ($request) {
            $query->orderBy('subject_name', 'asc')
            ->when($request->query('query'), function ($q, $query) {
                return $q->where('subject_name', 'like', '%'.$query.'%');
            });
        }])
        ->find($teach_id);

        return response()->json([
            'data' => $teacher,
        ]);
    }

    /**
    * Retrieve All Subjects on the portal
    *
    * @return Resource
    */
    public function getAll() {
        $subjects = $this->subject
        ->setSubject()
        ->orderBy('subject_name', 'asc')
        ->get();

        return SubjectResource::collection($subjects);
    }

    protected function permissionDeny($ability) {
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}
