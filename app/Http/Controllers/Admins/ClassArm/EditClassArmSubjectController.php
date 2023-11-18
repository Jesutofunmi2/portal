<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassArmResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class EditClassArmSubjectController extends Controller
{
    //
    protected $classarm;

    protected $admin;

    public function __construct(ClassArmRepositoryInterface $classarm, AdminRepositoryInterface $admin)
        {

        $this->middleware('auth:school_api');

        $this->classarm = $classarm;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        if($this->permissionDeny('edit-assign-subject-to-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;

        $classarm = $this->classarm->setClassArms()
        ->with(['classes'])
        ->find($id);

        $subjects = DB::table('classarm_subject')
                        ->select('classarm_subject.id as classarm_subject_id', 'classarm_subject.subject_id as subject_id',
                        'classarm_subject.teacher_id as teacher_id', 'subjects.subject_name', 'subjects.class_category',
                        'subjects.subject_code', 'teachers.title', 'teachers.surname', 'teachers.firstname', 'teachers.middlename')
                        ->where('classarm_subject.classarm_id', $id)
                        ->join('subjects', 'classarm_subject.subject_id', '=', 'subjects.id')
                        ->leftJoin('teachers', 'classarm_subject.teacher_id', '=', 'teachers.id')
                        ->get();

        return response()->json([
            'data' => [
                'classes' => $classarm,
                'subjects' => $subjects
            ] 
        ]);

    }

    public function update(Request $request, $id = null)
    {
        if($this->permissionDeny('edit-assign-subject-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        $setClassArm = $this->classarm->find($id);

        abort_if(is_null($setClassArm), 400, 'Class arm not found');

        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;

        $messages = [
            'subject_id.required' => 'Select a Subject.',
            'teacher_id.required' => 'Select a Teacher.',
        ];
    
        $rules = [
                'subject_id' => 'required',
                'teacher_id' => 'required',
        ];
        
        $this->validate($request, $rules, $messages);

        $teacher_id = $request->teacher_id;
        $subject_id = $request->subject_id;

        $teacher = DB::table('subject_teacher')
                ->where('school_id', $school_id)
                ->where('subject_id', $subject_id)
                ->where('teacher_id', $teacher_id)
                ->exists();

        abort_if(! $teacher, 400, 'No teacher found for some selected subjects');

        $subject_exist = DB::table('classarm_subject')
                        ->where('classarm_id', $id)
                        ->where('subject_id', $subject_id)
                        ->exists();

        abort_if($subject_exist, 400, 'Subject already assign to class');

        $subject_exist = DB::table('classarm_subject')->insert([
            'classarm_id' => $id,
            'subject_id' => $subject_id,
            'teacher_id' => $teacher_id,
            'session' => 2021,
        ]);
           
        return response()->json([
            'data' => [
                'message' => 'Class Arm Subject added successfully'
            ]
        ]);

    }

    public function deleteClassarmSubject($id = null)
    {
        if($this->permissionDeny('edit-assign-subject-to-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        DB::table('classarm_subject')->where('id', $id)->delete();

        return response()->json([
            'data' => [
                'message' => 'Class Arm Subjects Deleted successfully'
            ]
        ]);

    }

    public function getSubjectTeachers($subjectId = null)
    {
        if($this->permissionDeny('edit-assign-subject-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

       //Get the school admin id
       $admin = Auth::guard('school_api')->user();
       //Get the school_id
       $school_id = $admin->school_id;
    
        $teachers = DB::table('subject_teacher')
                        ->select('teachers.id', 'teachers.title', 'teachers.surname', 'teachers.firstname', 'teachers.middlename')
                        ->where('subject_teacher.school_id', $school_id)
                        ->where('subject_teacher.subject_id', $subjectId)
                        ->join('teachers', 'subject_teacher.teacher_id', '=', 'teachers.id')
                        ->get();

        if(count($teachers) == 0) {
            abort(400, 'No teacher found for the selected subject');
        }

        return response()->json([
            'data' => $teachers
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}