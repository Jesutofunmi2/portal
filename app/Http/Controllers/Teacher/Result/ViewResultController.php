<?php

namespace App\Http\Controllers\Teacher\Result;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ViewResultController extends Controller
{
    //
    protected $teacher;

    protected $student;

    public function __construct(TeacherRepositoryInterface $teacher, StudentRepositoryInterface $student)
    {

        $this->middleware('auth:teacher_api');

        $this->teacher = $teacher;

        $this->student = $student;

    }


    public function index(Request $request)
    {
        
        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
        ]);
        
        //Get the school admin id
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $school_id = $this->teacher->find($teacher_id)->school_id;

        $studIDs = DB::table('classarm_student')
        ->where('classarm_id', $request->input('classarm_id'))
        ->where('class_id', $request->input('class_id'))
        ->where('session', $request->input('session'))
        ->where('term', $request->input('term'))
        ->pluck('student_id');

        $query = $this->student->setStudent()->query()
        ->with(['studentResults' => function ($query) use($request, $school_id) {
            $query->where('class_id', $request->input('class_id'))
            ->where('classarm_id', $request->input('classarm_id'))
            ->where('session', $request->input('session'))
            ->where('term', $request->input('term'))
            ->where('school_id', $school_id);
        }, 'studentResults.subject:id,subject_name'])
        ->select('id', 'surname', 'firstname', 'middlename')
        ->whereIn('id', $studIDs)
        ->where('school_id', $school_id)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->get();

        return new StudentCollection($query);

    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}