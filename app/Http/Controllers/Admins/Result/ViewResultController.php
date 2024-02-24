<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\NgStatesLGA;
use App\Models\OndoLGA;
use App\Models\StudentHouse;
use App\Models\StudentResult;
use App\Models\Subject;
use App\Models\Teacher\Teacher;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentCommentsRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\DigitalPayment;
use PDF;

class ViewResultController extends Controller
{
    //
    protected $admin;
    protected $student;
    protected $classes;
    protected $school;
    protected $classarm;
    protected $student_comments;

    public function __construct(AdminRepositoryInterface $admin,
                                StudentRepositoryInterface $student,
                                ClassRepositoryInterface $classes,
                                SchoolRepositoryInterface $school,
                                ClassArmRepositoryInterface $classarm,
                                StudentCommentsRepositoryInterface $student_comments
                                )
    {

        $this->admin = $admin;
        $this->student = $student;
        $this->classes = $classes;
        $this->school = $school;
        $this->classarm = $classarm;
        $this->student_comments = $student_comments;
    }


    public function index(Request $request)
    {
        if($this->permissionDeny('view-result')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

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
        ->select(DB::raw('MAX(id) as id'), 'surname', 'firstname', 'middlename')
        ->whereIn('id', $studIDs)
        ->where('school_id', $school_id)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->get();

        return new StudentCollection($query);

    }

    public function printResult(Request $request)
    {
        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
            'student_id'     => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
            'print_type'     => 'required','regex:/(html|pdf)/'
        ]);

        // $payment = DigitalPayment::where([
        //     'student_id' => $request->student_id,
        //     'session' => $request->session
        //     ])
        //     ->first();

        $session = $request->session + 1;

        // if(! ($payment && $payment->is_verified == true)){
        //     return response()->json([
        //         'data' => [
        //             'status' => false,
        //             'message' => "This student have not make digital payment for $request->session/$session"
        //         ]
        //     ]);
        // }
        
        $student = $this->student->find($request->student_id);

        $school_id = $student->school_id;

        $student_results = $student->studentResults()
                            ->where('session', $request->session)
                            ->where('class_id', $request->class_id)
                            ->where('classarm_id', $request->classarm_id)
                            ->where('term', $request->term)
                            ->where('school_id', $school_id)
                            ->groupBy('subject_id')
                            ->get();
        
        // $student_practical_skill = $student->studentPracticalSkills()
        //                     ->where('session', $request->session)
        //                     ->where('class_id', $request->class_id)
        //                     ->where('classarm_id', $request->classarm_id)
        //                     ->where('term', $request->term)
        //                     ->where('school_id', $school_id)
        //                     ->get();

        $student_character_development = $student->studentCharacterAttitudes()
                            ->where('session', $request->session)
                            ->where('class_id', $request->class_id)
                            ->where('classarm_id', $request->classarm_id)
                            ->where('term', $request->term)
                            ->where('school_id', $school_id)
                            ->first();
        
            
        $class_data = $this->classes->find($request->class_id);
        $class_name = $class_data->class_name;
        $class_name_char = strtoupper(substr($class_name, 0, 1)); 

        $classarm_data = $this->classarm->find($request->classarm_id);

        $classarm_teacher_data = $classarm_data->teachers()
                                ->where('classarm_teacher.classarm_id', $request->classarm_id)
                                ->first();
        $teacher_signature = $classarm_teacher_data ? $classarm_teacher_data['signature'] : '';

        $classarm_counsellor_data = $classarm_data->counsellors()
                                ->where('classarm_counsellor.classarm_id', $request->classarm_id)
                                ->first();
        $counsellor_signature = $classarm_counsellor_data ? $classarm_counsellor_data['signature'] : 'N/A';  

        $house_master_signature = '';         
        $house_name = 'N/A';
        if(!empty($student->house_id)){
                $school_house = StudentHouse::find($student->house_id);
                
                if(!empty($school_house)){
                    $house_name = $school_house->name;
                    $house_master =  $school_house->house_masters()->first();
                    if(!empty($house_master)){
                        $house_master_signature = $house_master['signature'];
                    }
                }
        } 

        $schoolData = $this->school->find($school_id);

        $student_comments = $this->student_comments->setStudentComments()
                                ->where('student_id', $student->id)
                                ->where('school_id', $student->school_id)
                                ->where('classarm_id', $request->classarm_id)
                                ->where('session', $request->session)
                                ->where('term', $request->term)
                                ->first();

            $comment_teacher = (!empty($student_comments->comment_teacher)) ? $student_comments->comment_teacher: ''; 
            $comment_house = (!empty($student_comments->comment_house)) ? $student_comments->comment_house: ''; 
            $comment_guard = (!empty($student_comments->comment_guard)) ? $student_comments->comment_guard: ''; 
            $comment_principal = (!empty($student_comments->comment_principal)) ? $student_comments->comment_principal: '';

            $promotion = $this->getStudentResultPromotion($student->id, $request->classarm_id, $request->class_id, $request->term, $request->session);
            $total_students = $this->getTotalNumberOfStudents($request->classarm_id, $request->class_id, $request->term, $request->session);      

            //$promotion = 0;
            $promotion_text = $promotion_img = '';


            if($promotion == 1){
                $promotion_text = 'REPEAT Current Class';
                $promotion_img = 'to_repeat.png';
            }
            elseif($promotion == 2){
                $promotion_text = 'PROMOTED to Next Class';
                $promotion_img = 'promoted.png';
            }
            elseif($promotion == 3){
                $promotion_text = 'REPEAT Current Class';
                $promotion_img = 'to_repeat.png';
            } 
            elseif($promotion == 4){
                $promotion_text = 'Advice to WITHDRAW';
                $promotion_img = 'withdraw.png';
            } 
            elseif($promotion == 5){
                $promotion_text = 'PROMOTED ON TRIAL';
                $promotion_img = 'promoted_on_trial.png';
            } 

            $lgas = NgStatesLGA::find($schoolData->lga_id);
            $school_lga = $lgas ? $lgas->name : 'N/A';
            $schoolLogo = env('BASE_PATH_2').str_replace(' ', '%20', $schoolData->logo);

            $class_type = $class_name_char == 'J' ? 'JSS' : 'SSS';

            $grades = DB::table('grade_config')
                            ->where('class_type', $class_type)
                            ->get(); 

            view()->share('school_id',$school_id);
            view()->share('schoolLogo',$schoolLogo);
            view()->share('school_lga',$school_lga);
            view()->share('schoolData',$schoolData);
            view()->share('student',$student);
            view()->share('class_name',$class_name);
            view()->share('classarm_name',$classarm_data->class_arm);
            view()->share('house_name',$house_name);
            view()->share('student_results',$student_results);
            // view()->share('student_practical_skill',$student_practical_skill);
            view()->share('student_character_development',$student_character_development);
            view()->share('logo', env('BASE_PATH').'images/logo-bg.png');
            view()->share('class_name_char',$class_name_char);
            view()->share('comment_teacher',$comment_teacher);
            view()->share('comment_house',$comment_house);
            view()->share('comment_guard',$comment_guard);
            view()->share('comment_principal',$comment_principal);

            view()->share('promotion_text',$promotion_text);
            view()->share('promotion_img', '/images/'.$promotion_img);

            view()->share('principal_sign',$schoolData->principal_sign);
            view()->share('counsellor_sign',$counsellor_signature);
            view()->share('teacher_signature',$teacher_signature);
            view()->share('house_master_signature',$house_master_signature);
            view()->share('next_session_date',$schoolData->next_session_date);

            view()->share('session_full', $request->session.'/'.($request->session + 1));
            view()->share('term',$request->term);
            view()->share('print_type',$request->print_type);
            view()->share('grades',$grades);
            view()->share('total_students', $total_students);

        $pdf = PDF::loadView('student.new-result-view');

        if($request->print_type == 'pdf') {
            $fullname = $student->surname.'-'.$student->firstname.'-'.$student->middlename;
            $filename = 'generatedResults/'.$fullname.'-SchoolResult.pdf';

            $pdf->save($filename);

            return response()->json([
                'url' => env('BASE_PATH').$filename
            ]);
        }

        return $pdf->download($student->surname.'_result.pdf');

        //return $pdf->stream('pdfview.pdf');
    }

    public function printResultCheck(Request $request)
    {
        if($this->permissionDeny('view-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'session'      => 'required|int',
            'student_id'     => 'required|int',
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
        ]);

        // $payment = DigitalPayment::where([
        //     'student_id' => $request->student_id,
        //     'session' => $request->session
        //     ])
        //     ->first();

        $session = $request->session + 1;

        // if(! ($payment && $payment->is_verified == true)){
        //     return response()->json([
        //         'data' => [
        //             'status' => false,
        //             'message' => "This student have not make digital payment for $request->session/$session"
        //         ]
        //     ]);
        // }

        $student = $this->student->find($request->student_id);
        $school_id = $student->school_id;

        $student_results = $student->studentResults()
                            ->select('status')
                            ->where('session', $request->session)
                            ->where('class_id', $request->class_id)
                            ->where('classarm_id', $request->classarm_id)
                            ->where('term', $request->term)
                            ->where('school_id', $school_id)
                            ->get();
                
        if(! count($student_results)) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "No result record found"
                ]
            ]);
        }

        if(count($student_results) && $student_results->first(function($student_result) {
            return $student_result->status == 0;
        })) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "This result is locked"
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'status' => true,
                'message' => "This student have make digital payment for $request->session/$session"
            ]
        ]);
    }

    function getStudentResultPromotion($student_id, $classarm_id, $class_id, $term, $session){

        $student_result = StudentResult::where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('student_id', $student_id)
                                            ->where('session', $session)
                                            ->where('term', $term)
                                            ->first(['promotion']);
        
    
        return $student_result ? $student_result['promotion'] : '';
    }

    public static function getSubjectWeightedAvgScore($student_id, $classarm_id, $class_id, $subject_id,$term, $session){

        $subject_average = StudentResult::where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('subject_id', $subject_id)
                                            ->where('student_id', $student_id)
                                            ->where('session', $session)
                                            ->where('term', $term)
                                            ->first(['weighted_average']);
    
        return $subject_average ? $subject_average->weighted_average : '0';
    
    }

    public static function getSubjectCummulative($classarm_id, $class_id, $subject_id,$term, $session, $student_id, $current){
        if($current){
            switch ($term) {
                case 'First':
                        $data = ['First'];
                break;
    
                case 'Second':
                        $data = ['First', 'Second'];
                break;
    
                case 'Third':
                        $data = ['First', 'Second', 'Third'];
                break;
            }
    
        }else{
            switch ($term) {
                case 'First':
                        $data = ['Not Allowed'];
                break;
    
                case 'Second':
                        $data = ['First'];
                break;
    
                case 'Third':
                        $data = ['First', 'Second'];
                break;
            }
        }
        $subject_average = StudentResult::where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('subject_id', $subject_id)
                                            ->where('student_id', $student_id)
                                            ->where('session', $session)
                                            ->whereRaw("`term` IN ('".implode('\', \'', $data)."')")
                                            ->get(['weighted_average']);
    
        $weighted_average = $subject_average->avg('weighted_average');
    
        return ($weighted_average > 0) ? number_format($weighted_average, 1): $weighted_average;
    
    }

    public static function getSubjectNameBySubjectID($subject_id){
        return Subject::find($subject_id)->subject_name;
    }
    
    public static function getSubjectCodeBySubjectID($subject_id){
        return Subject::find($subject_id)->subject_code;
    }

    public static function getSubjectAverageScore($classarm_id, $class_id, $subject_id,$term, $session){

        $subject_average = StudentResult::where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('subject_id', $subject_id)
                                            ->where('session', $session)
                                            ->where('term', $term)
                                            ->get(['weighted_average']);
    
        return $subject_average->avg('weighted_average');
    }

    public static function getClassSubjectPosition($classarm_id, $class_id, $subject_id,$term, $session, $student_id){

        $subject_score = StudentResult::where('classarm_id', $classarm_id)
                                            ->where('class_id', $class_id)
                                            ->where('subject_id', $subject_id)
                                            ->where('session', $session)
                                            ->where('term', $term)
                                            ->groupBy('student_id')
                                            ->orderBy('weighted_average', 'desc')
                                            ->get(['student_id', 'weighted_average']);
        $position = 'N/A';
        if($subject_score->count()) {
            $count = 1;
            foreach ($subject_score as $subject) {
               if($subject->student_id == $student_id) {
                $position = $count;
                break;
               }
               $count++;
            }
        }
        return $position;
    }

    public static function getSubjectTeacherName($subject_id,$classarm_id ){
        $subject = DB::table('classarm_subject')->select('teacher_id')->whereRaw("`classarm_id` = ".$classarm_id." AND `subject_id` = ".$subject_id )->first();
        if(!empty($subject)){
           $teacher = Teacher::find($subject->teacher_id);
            if($teacher){
                return strtolower("$teacher->title $teacher->surname $teacher->firstname $teacher->middlename");                   
            }        
        }
        return '';    
    }

    public function getTotalNumberOfStudents($classarm_id, $class_id, $term, $session){
        return DB::table('classarm_student')
                        ->where('classarm_id', $classarm_id)
                        ->where('class_id', $class_id)
                        ->where('session', $session)
                        ->where('term', $term)
                        ->count();
    }

    public static function getSubjectTeacherSignature($subject_id,$classarm_id ){
        $subject = DB::table('classarm_subject')->select('teacher_id')->whereRaw("`classarm_id` = ".$classarm_id." AND `subject_id` = ".$subject_id )->first();
        if(!empty($subject)){
           $teacher = Teacher::find($subject->teacher_id);
            if($teacher) {
                return env('BASE_PATH_2').str_replace(' ', '%20', $teacher->signature);                  
            }        
        }
        return '';    
    }
    
    public static function limitLongText ($strValue, $limitDigit, $add_dot = false){       
        if(strlen($strValue) > $limitDigit){
            $getStrVal = substr($strValue, 0, $limitDigit);
            $getStrVal .= ($add_dot == 1) ? '...': '';
        }
        else{
            $getStrVal = $strValue;
        }
        return $getStrVal;
    }// End function
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
