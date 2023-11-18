<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use App\Http\Helper\GeneralHelper;
use App\Http\Resources\ClassArmResource;
use App\Http\Resources\StudentCollection;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AssignStudentController extends Controller
{
    //
    protected $classarm;
    protected $admin;
    protected $student;

    public function __construct(ClassArmRepositoryInterface $classarm, AdminRepositoryInterface $admin, StudentRepositoryInterface $student)
        {

        $this->middleware('auth:school_api');

        $this->classarm = $classarm;
        $this->admin = $admin;
        $this->student = $student;

    }


    public function index(Request $request)
    {
        if($this->permissionDeny('assign-student-to-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'class' => 'required|int',
            'arm' => 'required|int',
            'session' => 'required|int',
            'term' => ["required", "in:First,Second,Third"]
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->student->setStudent()->query()
        ->select(DB::raw('MAX(students.id) as id, MAX(students.regnum) as regnum, MAX(students.passport) as passport, MAX(classes.class_name) as clas, MAX(class_arms.class_arm) as arm, MAX(classarm_student.session) as session, MAX(classarm_student.term) as term'), 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->where('students.school_id', $school_id)
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        ->where('classarm_student.class_id', $request->query('class'))
        ->where('classarm_student.classarm_id', $request->query('arm'))
        ->where('classarm_student.session', $request->query('session'))
        ->where('classarm_student.term', $request->query('term'))
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->groupBy('students.surname', 'students.firstname', 'students.middlename')
        ->get();

        return new StudentCollection($query);
    }

    public function assign(Request $request)
    {
        if($this->permissionDeny('assign-student-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }
 
        $this->validate($request, [
            'class' => 'required|int',
            'arm' => 'required|int',
            'session' => 'required|int',
            'term' => ["required", "in:First,Second,Third"],
            'next_class' => 'required|int',
            'next_arm' => 'required|int',
            'next_session' => 'required|int',
            'next_term' => ["required", "in:First,Second,Third"],
            'ids' => ["required"]
        ]);

        $this->validateNextClass($request);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->next_session;
        $term = $request->next_term;
        $classarm_id = $request->next_arm;
        $class_id = $request->next_class;

        $exist_students = DB::table('classarm_student')->select('student_id')->whereRaw("`classarm_id` = ".$classarm_id." AND `term` = '".$term."' AND `session` = ".$session )->get();

        $exist_students_array = $exist_students->map(function($student) {
            return $student->student_id;
        })->toArray();

        $ids = explode(',', $request->ids);

        $non_exist_students = array_diff($ids, $exist_students_array);

        if(count($non_exist_students) > 0){
            $classarm_get =  $this->classarm->find($classarm_id);

            $classarm_get->students()->attach($non_exist_students, ['session' => $session, 'term' => $term, 'class_id' => $class_id]);

            $msg = 'You have successfully moved '.count($non_exist_students).' students from '.GeneralHelper::getClassNameByClassID($request->class).' '.GeneralHelper::getClassArmNameByClassArmID($request->arm).' '.$request->term.' term '.$request->session.'/'.($request->session + 1).' to '.GeneralHelper::getClassNameByClassID($class_id).' '.GeneralHelper::getClassArmNameByClassArmID($classarm_id).' '.$term.' term '.$session.'/'.($session + 1);
        }else{
            $msg = 'You have already move '.GeneralHelper::getClassNameByClassID($request->class).' '.GeneralHelper::getClassArmNameByClassArmID($request->arm).' '.$request->term.' term '.$request->session.'/'.($request->session + 1).' to '.GeneralHelper::getClassNameByClassID($class_id).' '.GeneralHelper::getClassArmNameByClassArmID($classarm_id).' '.$term.' term '.$session.'/'.($session + 1);
        }

        return response()->json([
            'data' => [
                'message' => $msg
            ]
        ]);
    }

    public function remove(Request $request)
    {
        if($this->permissionDeny('remove-assign-student-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }
 
        $this->validate($request, [
            'class' => 'required|int',
            'arm' => 'required|int',
            'session' => 'required|int',
            'term' => ["required", "in:First,Second,Third"],
            'ids' => ["required"]
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->session;
        $term = $request->term;
        $classarm_id = $request->arm;
        $class_id = $request->class;

        $exist_students = DB::table('classarm_student')->select('student_id')->whereRaw("`classarm_id` = ".$classarm_id." AND `term` = '".$term."' AND `session` = ".$session )->get();

        $exist_students_array = $exist_students->map(function($student) {
            return $student->student_id;
        })->toArray();

        $ids = explode(',', $request->ids);

        $remove_students = array_diff($exist_students_array, $ids);
        
        $classarm_get =  $this->classarm->find($classarm_id);

        if(count($remove_students) > 0) {

            $classarm_get->students()->wherePivot('session','=', $session)
                                    ->wherePivot('class_id','=', $class_id)
                                    ->wherePivot('term','=', $term)->sync($remove_students, ['session' => $session, 'term' => $term, 'class_id' => $class_id]);

            $msg = 'You have successfully removed '.count($ids).' students from '.GeneralHelper::getClassNameByClassID($request->class).' '.GeneralHelper::getClassArmNameByClassArmID($request->arm).' '.$request->term.' term '.$request->session.'/'.($request->session + 1);
        }
        else{
            $classarm_get->students()->wherePivot('session','=', $session)
                                        ->wherePivot('class_id','=', $class_id)
                                        ->wherePivot('term','=', $term)
                                        ->detach();
            $msg = 'You have successfully removed all students from '.GeneralHelper::getClassNameByClassID($request->class).' '.GeneralHelper::getClassArmNameByClassArmID($request->arm).' '.$request->term.' term '.$request->session.'/'.($request->session + 1);
        }

        return response()->json([
            'data' => [
                'message' => $msg
            ]
        ]);
    }

    public function reassign(Request $request)
    {
        if($this->permissionDeny('assign-student-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }
 
        $this->validate($request, [
            'class' => 'required|int',
            'arm' => 'required|int',
            'session' => 'required|int',
            'term' => ["required", "in:First,Second,Third"],
            'next_class' => 'required|int',
            'next_arm' => 'required|int',
            'next_session' => 'required|int',
            'next_term' => ["required", "in:First,Second,Third"],
            'ids' => ["required"]
        ]);

        $this->validateReAssign($request);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->session;
        $term = $request->term;
        $to_classarm_id = $request->next_arm;
        $from_classarm_id = $request->arm;
        $class_id = $request->class;

        $ids = explode(',', $request->ids);

        $where_clause = '('.implode(', ', $ids ).')';

        //START:: QUERY
        DB::update("UPDATE `classarm_student` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `result_vouchers` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `student_results` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `student_comments` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `student_subject_unoffered` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `practical_skills` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `character_attitudes` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);
        DB::update("UPDATE `transfers` SET `classarm_id` = ? WHERE `session` = ? AND `classarm_id` = ? AND `term` = ? AND `class_id` = ? AND `student_former_id` IN ".$where_clause."", [$to_classarm_id, $session, $from_classarm_id, ''.$term.'', $class_id]);

        return response()->json([
            'data' => [
                'message' => count($ids).' student(s) have been successfully moved to the selected Class Arm'
            ]
        ]);
    }

    protected function permissionDeny($ability) {
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }

    protected function validateReAssign($request) {
        abort_if($request->term != $request->next_term, 400, 'Sorry, the term should be the same');
        $session = $request->session+1;
        $session = "$request->session/$session";
        abort_if($request->session != $request->next_session, 400, "Sorry, the session should be $session");
        abort_if($request->class != $request->next_class, 400, "Sorry, the class should be the same");
        abort_if($request->arm == $request->next_arm, 400, "Sorry, the class arm should not be the same");      
    }

    protected function validateNextClass($request) {
        switch ($request->term) {
            case 'First':
                abort_if($request->next_term != 'Second', 400, 'Sorry, the next term should be Second Term');
                $session = $request->session+1;
                $session = "$request->session/$session";
                abort_if($request->session != $request->next_session, 400, "Sorry, the session should be $session");
                abort_if($request->class != $request->next_class, 400, "Sorry, the class should be the same");
                abort_if($request->arm != $request->next_arm, 400, "Sorry, the class arm should be the same");
                break;

            case 'Second':
                abort_if($request->next_term != 'Third', 400, 'Sorry, the next term should be Third Term');
                $session = $request->session+1;
                $session = "$request->session/$session";
                abort_if($request->session != $request->next_session, 400, "Sorry, the session should be $session");
                abort_if($request->class != $request->next_class, 400, "Sorry, the class should be the same");
                abort_if($request->arm != $request->next_arm, 400, "Sorry, the class arm should be the same");
                break;

            case 'Third':
                abort_if($request->next_term != 'First', 400, 'Sorry, the next term should be First Term of next session');
                abort_if($request->session == $request->next_session , 400, 'Sorry, the last session and new session can not be the same');
                $new_session = $request->session+1;
                $session = $request->next_session+1;
                $session = "$request->next_session/$session";
                abort_if($request->next_session != $new_session, 400, "Sorry, the session should not be $session");
                abort_if($request->class == $request->next_class, 400, "Sorry, the class should not be the same");
                abort_if($request->arm == $request->next_arm, 400, "Sorry, the class arm should not be the same");
                break;
            
            default:
                abort(400, 'Error, please select correct term');
        }
    }
}