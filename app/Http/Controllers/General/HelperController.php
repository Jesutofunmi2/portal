<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Resources\SubjectResource;
use App\Models\Classes;
use App\Models\StudentHouse;
use App\Models\ClassArms;
use App\Models\School;
use Illuminate\Support\Facades\DB;

use App\Models\Teacher\Teacher;

class HelperController extends Controller
{
   
    public function getSubjects()
    {
        $Subjects = Subject::get();

        return SubjectResource::collection($Subjects);
    }

    public function getSubjectsByCategory()
    {
        $jssSubjects = Subject::where('class_category','JSS')->orderBy('subject_name','asc')->get(['id','subject_name','subject_code']);
        $sssSubjects = Subject::where('class_category','SSS')->orderBy('subject_name','asc')->get(['id','subject_name','subject_code']);

        return response()->json([
            'data' => [
                'jss_subjects' => $jssSubjects,
                'sss_subjects' => $sssSubjects
            ]
        ],200);
    }

    public function getSubjectsById($id = null)
    {
        $subject = Subject::find($id, ['id','subject_name','subject_code','class_category']);

        return response()->json([
            'data' => [
                'subject' => $subject,
            ]
        ],200);
    }
    
    public function getClasses($school_id = null){
        $classes = Classes::where('school_id','=',$school_id)->get(['id','class_name']);
        if($classes->count() == 0) $classes = null;

        return response()->json([
            'data' => [
                'classes' => $classes,
                'houses' => $this->getHouses($school_id)
            ]
        ],200);
    
    }
    
    public function getHouses($school_id = null){
        $houses = StudentHouse::where('school_id','=',$school_id)->get(['id','name']);
        if($houses->count() == 0) return null ;
    
        return $houses;
    }

    public function getClassArms($class_id = null){
        $classarms = ClassArms::where('class_id','=',$class_id)->get(['id','class_arm']);
        if($classarms->count() == 0) $classarms = null;

        return response()->json([
            'data' => [
                'class_arms' => $classarms,
            ]
        ],200);
    }

    public static function aeozeoSchoolsId(array $lgas) {
        return School::whereIn('lga_id', $lgas)->get('id')->toArray();
    }

    public static function aeozeoSchools(array $lgas) {
        return School::whereIn('lga_id', $lgas)->get();
    }

     //**************** NEW METHOD ******************
    
     public function getSchoolAllClassArms($school_id = null){

        $classarms = DB::table('class_arms')
                        ->select('classes.class_name', 'class_arms.class_arm', 'class_arms.id as class_arm_id', 'class_arms.class_id')
                        ->where('class_arms.school_id', $school_id)
                        ->join('classes', 'classes.id', '=', 'class_arms.class_id')
                        ->get();

        if($classarms->count() == 0) $classarms = null;

        return response()->json([
            'data' => [
                'class_arms' => $classarms,
            ]
        ],200);
    
    }

    public function getClassesByCategory($school_id, $category){
        $classes = Classes::where('school_id', '=', $school_id)
                            ->where('class_name', 'like', '%'.$category.'%')
                            ->get(['id','class_name']);

        if($classes->count() == 0) $classes = null;

        return response()->json([
            'data' => [
                'classes' => $classes
            ]
        ],200);
    }
    
    public function getSchoolInfo($school_id){
        
        $school = School::find($school_id);

        return response()->json([
            'data' => [
                'school' => $school,
            ]
        ],200);
    }
    

    public function getAllTeachers($school_id){
        $teachers = Teacher::where('school_id', '=', $school_id)
                                    ->orderBy('surname','asc')
                                    ->orderBy('firstname','asc')
                                    ->orderBy('middlename','asc')
                                    ->get(['id', 'title', 'surname', 'firstname', 'middlename', 'staff_no', 'gender', 'title']);

        if($teachers->count() == 0) $teachers = null;

        return response()->json([
            'data' => [
                'teachers' => $teachers
            ]
        ],200);
    }//end method



    public function assignSubjectTeacher($school_id, $teacher_id, $subject_id, $classarm_id)
    {   
        $setTeacher = Teacher::find($teacher_id);

        if($setTeacher){

            $teacher_exist = DB::table('subject_teacher')
                            ->where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            ->where('teacher_id', $teacher_id)
                            ->first();

            $class_subject_exist = DB::table('classarm_subject')
                            ->where('classarm_id', $classarm_id)
                            ->where('subject_id', $subject_id)
                            ->first();

            $resp_msg = '';
            $resp_code = 400;

            if(empty($teacher_exist)){
               $setTeacher->subjects()->attach($subject_id, [
                    'school_id' => $school_id,
                ]);

                if($class_subject_exist){
                    $resp_msg .= 'Subject has been successfully assigned to Teacher. But the Class Arm had already been assigned to another Teacher';

                    $resp_code = 200;
                }
                else{
                    $resp_msg = 'Subject has been assigned to teacher and Teacher has been assigned to class arm successfully';

                    $subject_exist = DB::table('classarm_subject')->insert([
                        'classarm_id' => $classarm_id,
                        'subject_id' => $subject_id,
                        'teacher_id' => $teacher_id,
                        'session' => 2021,
                    ]);
                    $resp_code = 200;
                }
            }
            else{
                $resp_msg = 'Selected Subject had been assigned to this Teacher';

                if($class_subject_exist){
                    $resp_msg .= ' and the Class Arm had already been assigned to another Teacher';
                }
                else{
                    $resp_msg = 'Teacher has been assigned to class arm successfully';

                    $subject_exist = DB::table('classarm_subject')->insert([
                        'classarm_id' => $classarm_id,
                        'subject_id' => $subject_id,
                        'teacher_id' => $teacher_id,
                        'session' => 2021,
                    ]);
                    $resp_code = 200;
                }
            }           

            return response()->json([
                'message' => $resp_msg
           ], $resp_code);
        }
        else{
            return response()->json([
            'message' => 'Permission Denied'
           ],400);
        }

    }//end method
    
    
    //**************** NEW METHOD ******************
}
