<?php

namespace App\Http\Helper;

use App\Http\Resources\SubjectResource;
use App\Models\ClassArms;
use App\Models\Classes;
use App\Models\NgStatesLGA;
use App\Models\School;
use App\Models\Student\Student;
use App\Models\Teacher\Teacher;
use Illuminate\Support\Facades\DB;
use PDF;

class GeneralHelper {

    public static function getLga($id)
    {
        return NgStatesLGA::findOrFail($id)->name;
    }

    public static function getSchool($id)
    {
        $school = School::find($id);
        if($school) return $school->name;
        return 'N/A';

    }

    public static function getAssocSubject($teacher_id){

        $teacher = Teacher::find($teacher_id);

        $subjects = $teacher->subjects()->get();
        if($subjects->count()){
            return SubjectResource::collection($subjects);
        }
        else{
            return null;
        }
    }

    public static function getSchoolName($school_id){
        if($school_id > 0){
            $school = School::where('id','=',$school_id)->first();
            return $school->name;
        }
    
        return 'School not avaiable';
    }

    public static function  getAssocTeacher($subject_id){
        $teachers = [];
        $subjectTeacher = DB::table('subject_teacher')->where('subject_id', $subject_id)->get('teacher_id');
  
        if(count($subjectTeacher) > 0){
            foreach($subjectTeacher as $teacher){
                $teacher = Teacher::find($teacher->teacher_id,['title','surname','firstname','middlename']);
                if(! is_null($teacher)) $teachers[] = $teacher;
            }
           
            return $teachers;
            
        }
        
        return null;
    }    

    public static function getStudentISSI($student_id)
    {
        $student = Student::find($student_id);
        if($student) return $student->regnum;
        return 'N/A';
    }

    public static function getExamType($type){
        if($type == 'entrance') return 'Entrance';

        if($type == 'pre_waec') return 'Pre Waec';

        if($type == 'jwaec') return 'Junior Waec';

        if($type == 'unity_exam') return 'Unity Exam';

        return 'Unknown';
    }

    public static function prepareSMSGateWay($senderName, $PhoneBook, $message)
    {
                
        $SMSGateWay =   "http://www.qultext.com/http/index.aspx";
        
        $SMSGateWay .=  "?cmd=sendquickmsg&username=ogooluwao@yahoo.co.uk&password=omoreghagideonogooluwa@1982";
        
        $SMSGateWay .=  "&message=".$message."&sender=".$senderName."&sendto=".$PhoneBook."&msgtype=0";
        
        $SMSChannel = curl_init();
        
        curl_setopt($SMSChannel, CURLOPT_URL, $SMSGateWay);
        
        curl_setopt($SMSChannel, CURLOPT_HEADER, 0);
        
        curl_setopt($SMSChannel, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec($SMSChannel);
        
        curl_close($SMSChannel);
        
        return $response;   
    }

    public static function getClassNameByClassID($class_id){

        $classes = Classes::find($class_id);
    
        $class_name = $classes ? $classes->class_name: 'N/A';
        return $class_name;
    
    }
    
    public static function getClassArmNameByClassArmID($classarm_id) {
    
        $classarm = ClassArms::find($classarm_id);

        $classarm_name = $classarm ? $classarm->class_arm : 'N/A';
    
        return $classarm->class_arm;
    }

    public static function nominalRoll(int $school_id, int $session, int $class_id, int $classarm_id, string $term)
    {
        $schoolData = School::find($school_id);

        $student = new Student;

        abort_if(is_null($schoolData), 400, 'School not found');

        $students = $student
        ->select('students.id', 'students.surname',
                'students.firstname','students.middlename',
                'students.regnum', 'students.passport',
                'students.parent_fullname','students.parent_phone', 'students.gender')
        ->join('classarm_student', 'students.id' , '=','classarm_student.student_id')
        ->where(['classarm_student.session' => $session,
                'classarm_student.class_id' => $class_id,
                'classarm_student.term' => $term,
                'classarm_student.classarm_id' => $classarm_id,
                'students.school_id' => $school_id
        ])
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->get();

        abort_if(count($students) == 0, 400, 'No students found');

        $lgas = NgStatesLGA::find($schoolData->lga_id);
        $school_lga = $lgas ? $lgas->name : 'N/A';
        $schoolLogo = env('BASE_PATH_2').str_replace(' ', '%20', $schoolData->logo);
        $class = static::getClassNameByClassID($class_id);
        $class_arm = static::getClassArmNameByClassArmID($classarm_id);
        $s = $session + 1;
        $session = "$s/$session";

        view()->share('schoolData', $schoolData);
        view()->share('school_lga', $school_lga);
        view()->share('schoolLogo', $schoolLogo);
        view()->share('class', $class);
        view()->share('class_arm', $class_arm);
        view()->share('students', $students);
        view()->share('session', $session);
        view()->share('term', $term);

        $pdf = PDF::loadView('school.pdf.norminal_roll');

        $filename = str_replace(' ', '-', $schoolData->name);
        $file_path = 'norminalRolls/'.$filename.'-SchoolNorminalRoll.pdf';

        $pdf->save($file_path);

        return env('BASE_PATH').$file_path;
    }

}