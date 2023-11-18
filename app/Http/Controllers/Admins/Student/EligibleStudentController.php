<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\DigitalPayment;
use App\Models\NgStatesLGA;
use App\Models\School;
use App\Models\Student\Student;
use App\Models\Transfer;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PDF;

class EligibleStudentController extends Controller
{
    //
    protected $student;

    protected $clas;

    public function __construct(StudentRepositoryInterface $student)
    {
        $this->student = $student;
    }

    public function getClasses(Request $request): JsonResponse
    {
        $request->validate([
            'school_id' => 'sometimes|integer'
        ]);

        if($request->has('school_id') && $request->school_id != null) {
            $school_id = $request->school_id;
        }
        else {
            //Get the school admin id
            $admin = Auth::guard('school_api')->user();
            $school_id = $admin->school_id;
        }

        $JSS3 = Classes::whereSchoolId($school_id)->where('class_name', 'like', 'J%')
                            ->where(function($query) {
                                return $query->where('class_name', 'like', '%3%')
                                        ->orWhere('class_name', 'like', '%three%')
                                        ->orWhere('class_name', 'like', '%III');
                            })->get();

        $JSS3 = $JSS3->map(function($cl) {
            return [
                'id' => $cl->id,
                'class_name' => $cl->class_name,
                'cat' => 'JSS3'
            ];
        })->toArray();

        $SSS2 = Classes::whereSchoolId($school_id)
                        ->where('class_name', 'like', 'S%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%2%')
                                        ->orWhere('class_name', 'like', '%two%')
                                        ->orWhere('class_name', 'like', '%II');
                        })->get();

        $SSS2 = $SSS2->map(function($cl) {
            return [
                'id' => $cl->id,
                'class_name' => $cl->class_name,
                'cat' => 'SSS2'
            ];
        })->toArray();

        $SSS3 = Classes::whereSchoolId($school_id)
                        ->where('class_name', 'like', 'S%')
                        ->where(function($query) {
                            return $query->where('class_name', 'like', '%3%')
                                        ->orWhere('class_name', 'like', '%three%')
                                        ->orWhere('class_name', 'like', '%III');;
                        })->get();

        $SSS3 = $SSS3->map(function($cl) {
            return [
                'id' => $cl->id,
                'class_name' => $cl->class_name,
                'cat' => 'SSS3'
            ];
        })->toArray();

        $classe = array_merge([], $JSS3);
        $classe = array_merge($classe, $SSS2);
        $classe = array_merge($classe, $SSS3);
        
        return response()->json([
            'data' => $classe
        ]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'class_cat' => 'required|string',
            'session' => 'required|integer',
            'school_id' => 'sometimes|integer',
            'type' => 'required|string'
        ]);

        if($request->has('school_id') && $request->school_id != null) {
            $school_id = $request->school_id;
        }
        else {
            //Get the school admin id
            $admin = Auth::guard('school_api')->user();
            $school_id = $admin->school_id;
        }

        $response = null;

        if($request->class_cat == 'JSS3') {
            $response = $this->processJss3($school_id, $request->class_id, $request->session, $request->type);
        }

        if($request->class_cat == 'SSS2') {
            $response = $this->processSss2($school_id, $request->class_id, $request->session, $request->type);
        }

        if($request->class_cat == 'SSS3') {
            $response = $this->processSss3($school_id, $request->class_id, $request->session, $request->type);
        }

        abort_if(is_null($response), 400, 'Unable to process eligible students');


        return response()->json([
            'data' => $response
        ]);
    }

    protected function processJss3($school_id, $class_id, $session, $type)
    {
        $students = Student::query()
            ->select(DB::raw('MAX(students.id) as id, MAX(students.regnum) as regnum, MAX(students.passport) as passport,
                                MAX(classes.class_name) as clas, MAX(class_arms.class_arm) as arm'),
                                'students.surname as surname', 'students.firstname as firstname',
                                'students.middlename as middlename', 'students.created_at as reg_date')
            ->where('students.school_id', $school_id)
            ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('classes', 'class_arms.class_id', '=', 'classes.id')
            ->where('classarm_student.class_id', $class_id)
            ->where('classarm_student.session', $session)
            ->orderBy('students.surname','asc')
            ->orderBy('students.firstname','asc')
            ->orderBy('students.middlename','asc')
            ->groupBy('students.id')
            ->groupBy('students.surname', 'students.firstname', 'students.middlename')
            ->get();
        
        if($students->count() == 0) {
            abort(400, 'No students found');
        }

        $ids = $students->pluck('id')->toArray();

        $first_session = $session;
        $second_session = $session - 1;
        $third_session = $session - 2;

        $first_session_payments = DigitalPayment::where('session', $first_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

        $second_session_payments = DigitalPayment::where('session', $second_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

        $third_session_payments = DigitalPayment::where('session', $third_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();
  
        $transfers = Transfer::where('student_new_school', $school_id)->whereIn('student_new_id', $ids)->get();

        $first_session_total = 0;
        $first_session_debt = 0;
        $first_session_paid = 0;

        $second_session_total = 0;
        $second_session_debt = 0;
        $second_session_paid = 0;

        $third_session_total = 0;
        $third_session_debt = 0;
        $third_session_paid = 0;

        $data = $students->map(function($student) use ($first_session_payments, 
                                                        $second_session_payments,
                                                        $third_session_payments,
                                                        $transfers,$first_session,
                                                        $second_session,$third_session,
                                                        &$first_session_total, &$first_session_debt,
                                                        &$first_session_paid, &$second_session_total,
                                                        &$second_session_debt, &$second_session_paid,
                                                        &$third_session_total, &$third_session_debt,
                                                        &$third_session_paid)
                {
                    $first_payment = $first_session_payments->firstWhere('student_id', $student->id);
                    $first_payment = $first_payment ? true : false;

                    if(! $first_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $first_payment = DigitalPayment::where('session', $first_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $first_payment ? $first_session_paid += 1 : $first_session_debt += 1;
                    $first_session_total += 1; 

                    $second_payment = $second_session_payments->firstWhere('student_id', $student->id);
                    $second_payment = $second_payment ? true : false;

                    if(! $second_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $second_payment = DigitalPayment::where('session', $second_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $second_payment ? $second_session_paid += 1 : $second_session_debt += 1;
                    $second_session_total += 1;

                    $third_payment = $third_session_payments->firstWhere('student_id', $student->id);
                    $third_payment = $third_payment ? true : false;

                    if(! $third_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $third_payment = DigitalPayment::where('session', $third_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $third_payment ? $third_session_paid += 1 : $third_session_debt += 1;
                    $third_session_total += 1;

                    $remark = '-';
                    $is_tranfer = $transfers->firstWhere('student_new_id', $student->id);

                    $reg_date = date('Y',strtotime($student->reg_date));

                    $is_tranfer = $transfers->firstWhere('student_new_id', $student->id);

                    if(is_null($is_tranfer) && $third_session != $reg_date) {
                        $is_tranfer = true;
                    }
                    $is_tranfer =  $is_tranfer ? 'TRANSFER' : 'DIRECT';

                    if($first_payment && $second_payment && $third_payment) {
                        $remark = 'Cleared';
                    }
                    
                    return [
                        'fullname' => strtoupper($student->surname).' '.strtoupper($student->firstname).' '.strtoupper($student->middlename),
                        'regnum' => $student->regnum,
                        'class' => strtoupper($student->clas).' ('.strtoupper($student->arm).')',
                        'passport' => $student->passport,
                        'reg_date' =>  $reg_date,
                        'first_payment' => $first_payment ? 'PAID' : 'NO RECORD',
                        'second_payment' => $second_payment ? 'PAID' : 'NO RECORD',
                        'third_payment' => $third_payment ? 'PAID' : 'NO RECORD',
                        'remark' => $remark,
                        'admission_mode' => $is_tranfer
                    ];
                });

            $first_session_b = $first_session + 1;
            $second_session_b = $second_session + 1;
            $third_session_b = $third_session + 1;
            $all_session = [
                'first' => 'JSS 3 ('.$first_session.'/'.$first_session_b.')',
                'second' => 'JSS 2 ('.$second_session.'/'.$second_session_b.')',
                'third' => 'JSS 1 ('.$third_session.'/'.$third_session_b.')',
            ];

        if($type == 'show') {
            return [
                'students' => $data,
                'session' => $all_session
            ];
        }

        if($type == 'print') {
            $schoolData = School::find($school_id);

            abort_if(is_null($schoolData), 400, 'School data not found');

            $amount = DB::table('payment_items')->first()->cost;

            $first_session_total = $amount * $first_session_total;
            $first_session_debt = $amount * $first_session_debt;
            $first_session_paid = $amount * $first_session_paid;

            $second_session_total = $amount * $second_session_total;
            $second_session_debt = $amount * $second_session_debt;
            $second_session_paid = $amount * $second_session_paid;

            $third_session_total = $amount * $third_session_total;
            $third_session_debt = $amount * $third_session_debt;
            $third_session_paid = $amount * $third_session_paid;

            $total = $first_session_total + $second_session_total + $third_session_total;
            $paid = $first_session_paid + $second_session_paid + $third_session_paid;
            $debt = $first_session_debt + $second_session_debt + $third_session_debt;

            $schoolLogo = env('BASE_PATH_2').str_replace(' ', '%20', $schoolData->logo);

            $state = env('STATE_NAME', 'ONDO');
            $lgas = NgStatesLGA::find($schoolData->lga_id);
            $school_lga = $lgas ? $lgas->name : 'N/A';

            $pdf = PDF::loadView('school.pdf.eligible', 
                            ['students' => $data,
                            'schoolLogo' => $schoolLogo, 
                            'schoolData' => $schoolData,
                            'school_lga' => $school_lga,
                            'state' => $state,
                            'sessions' => $all_session,
                            'total' => number_format($total),
                            'paid' => number_format($paid),
                            'debt' => number_format($debt),
                            'first_session_total' => number_format($first_session_total),
                            'first_session_debt' => number_format($first_session_debt),
                            'first_session_paid' => number_format($first_session_paid),
                            'second_session_total' => number_format($second_session_total),
                            'second_session_debt' => number_format($second_session_debt),
                            'second_session_paid' => number_format($second_session_paid),
                            'third_session_total' => number_format($third_session_total),
                            'third_session_debt' => number_format($third_session_debt),
                            'third_session_paid' => number_format($third_session_paid),
                            'student_class' => 'JSS 3',
                            ])
            ->setPaper('a4', 'landscape');
            
            $filename = 'generatedPdf/'.str_replace([' ', '/'], '-', $schoolData->name).'-Jss3_eligible_students.pdf';
    
            $pdf->save($filename);
            // return $pdf->download($filename);
    
            return [
                'url' => env('BASE_PATH').$filename
            ];
        }
    }

    protected function processSss3($school_id, $class_id, $session, $type)
    {
        $students = Student::query()
            ->select(DB::raw('MAX(students.id) as id, MAX(students.regnum) as regnum, MAX(students.passport) as passport,
                                MAX(classes.class_name) as clas, MAX(class_arms.class_arm) as arm'),
                                'students.surname as surname', 'students.firstname as firstname',
                                'students.middlename as middlename', 'students.created_at as reg_date')
            ->where('students.school_id', $school_id)
            ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('classes', 'class_arms.class_id', '=', 'classes.id')
            ->where('classarm_student.class_id', $class_id)
            ->where('classarm_student.session', $session)
            ->orderBy('students.surname','asc')
            ->orderBy('students.firstname','asc')
            ->orderBy('students.middlename','asc')
            ->groupBy('students.id')
            ->groupBy('students.surname', 'students.firstname', 'students.middlename')
            ->get();
        
        if($students->count() == 0) {
            abort(400, 'No students found');
        }

        $ids = $students->pluck('id')->toArray();

        $first_session = $session;
        $second_session = $session - 1;
        $third_session = $session - 2;

        $first_session_payments = DigitalPayment::where('session', $first_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

        $second_session_payments = DigitalPayment::where('session', $second_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

        $third_session_payments = DigitalPayment::where('session', $third_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();
  
        $transfers = Transfer::where('student_new_school', $school_id)->whereIn('student_new_id', $ids)->get();

        $first_session_total = 0;
        $first_session_debt = 0;
        $first_session_paid = 0;

        $second_session_total = 0;
        $second_session_debt = 0;
        $second_session_paid = 0;

        $third_session_total = 0;
        $third_session_debt = 0;
        $third_session_paid = 0;

        $data = $students->map(function($student) use ($first_session_payments, 
                                                        $second_session_payments,
                                                        $third_session_payments,
                                                        $transfers,$first_session,
                                                        $second_session,$third_session,
                                                        &$first_session_total, &$first_session_debt,
                                                        &$first_session_paid, &$second_session_total,
                                                        &$second_session_debt, &$second_session_paid,
                                                        &$third_session_total, &$third_session_debt,
                                                        &$third_session_paid)
                {
                    $first_payment = $first_session_payments->firstWhere('student_id', $student->id);
                    $first_payment = $first_payment ? true : false;

                    if(! $first_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $first_payment = DigitalPayment::where('session', $first_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $first_payment ? $first_session_paid += 1 : $first_session_debt += 1;
                    $first_session_total += 1; 

                    $second_payment = $second_session_payments->firstWhere('student_id', $student->id);
                    $second_payment = $second_payment ? true : false;

                    if(! $second_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $second_payment = DigitalPayment::where('session', $second_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $second_payment ? $second_session_paid += 1 : $second_session_debt += 1;
                    $second_session_total += 1; 

                    $third_payment = $third_session_payments->firstWhere('student_id', $student->id);
                    $third_payment = $third_payment ? true : false;

                    if(! $third_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $third_payment = DigitalPayment::where('session', $third_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $third_payment ? $third_session_paid += 1 : $third_session_debt += 1;
                    $third_session_total += 1; 

                    $remark = '-';
                    $is_tranfer = $transfers->firstWhere('student_new_id', $student->id);

                    $reg_date = date('Y',strtotime($student->reg_date));

                    $is_tranfer = $transfers->firstWhere('student_new_id', $student->id);

                    if(is_null($is_tranfer) && $third_session != $reg_date) {
                        $is_tranfer = true;
                    }

                    $is_tranfer =  $is_tranfer ? 'TRANSFER' : 'DIRECT';

                    if($first_payment && $second_payment && $third_payment) {
                        $remark = 'Cleared';
                    }
                    
                    return [
                        'fullname' => strtoupper($student->surname).' '.strtoupper($student->firstname).' '.strtoupper($student->middlename),
                        'regnum' => $student->regnum,
                        'class' => strtoupper($student->clas).' ('.strtoupper($student->arm).')',
                        'passport' => $student->passport,
                        'reg_date' => $reg_date,
                        'first_payment' => $first_payment ? 'PAID' : 'NO RECORD',
                        'second_payment' => $second_payment ? 'PAID' : 'NO RECORD',
                        'third_payment' => $third_payment ? 'PAID' : 'NO RECORD',
                        'remark' => $remark,
                        'admission_mode' => $is_tranfer
                    ];
                });

            $first_session_b = $first_session + 1;
            $second_session_b = $second_session + 1;
            $third_session_b = $third_session + 1;
            $all_session = [
                'first' => 'SSS 3 ('.$first_session.'/'.$first_session_b.')',
                'second' => 'SSS 2 ('.$second_session.'/'.$second_session_b.')',
                'third' => 'SSS 1 ('.$third_session.'/'.$third_session_b.')',
            ];

        if($type == 'show') {
            return [
                'students' => $data,
                'session' => $all_session
            ];
        }

        if($type == 'print') {
            $schoolData = School::find($school_id);

            abort_if(is_null($schoolData), 400, 'School data not found');

            $amount = DB::table('payment_items')->first()->cost;

            $first_session_total = $amount * $first_session_total;
            $first_session_debt = $amount * $first_session_debt;
            $first_session_paid = $amount * $first_session_paid;

            $second_session_total = $amount * $second_session_total;
            $second_session_debt = $amount * $second_session_debt;
            $second_session_paid = $amount * $second_session_paid;

            $third_session_total = $amount * $third_session_total;
            $third_session_debt = $amount * $third_session_debt;
            $third_session_paid = $amount * $third_session_paid;

            $total = $first_session_total + $second_session_total + $third_session_total;
            $paid = $first_session_paid + $second_session_paid + $third_session_paid;
            $debt = $first_session_debt + $second_session_debt + $third_session_debt;

            $schoolLogo = env('BASE_PATH_2').str_replace(' ', '%20', $schoolData->logo);

            $state = env('STATE_NAME', 'ONDO');
            $lgas = NgStatesLGA::find($schoolData->lga_id);
            $school_lga = $lgas ? $lgas->name : 'N/A';


            $pdf = PDF::loadView('school.pdf.eligible', 
                            ['students' => $data,
                            'schoolLogo' => $schoolLogo, 
                            'schoolData' => $schoolData,
                            'school_lga' => $school_lga,
                            'state' => $state,
                            'sessions' => $all_session,
                            'total' => number_format($total),
                            'paid' => number_format($paid),
                            'debt' => number_format($debt),
                            'first_session_total' => number_format($first_session_total),
                            'first_session_debt' => number_format($first_session_debt),
                            'first_session_paid' => number_format($first_session_paid),
                            'second_session_total' => number_format($second_session_total),
                            'second_session_debt' => number_format($second_session_debt),
                            'second_session_paid' => number_format($second_session_paid),
                            'third_session_total' => number_format($third_session_total),
                            'third_session_debt' => number_format($third_session_debt),
                            'third_session_paid' => number_format($third_session_paid),
                            'student_class' => 'SSS 3',
                            ])
            ->setPaper('a4', 'landscape');
    
            $filename = 'generatedPdf/'.str_replace([' ', '/'], '-', $schoolData->name).'-SSS3_eligible_students.pdf';
    
            $pdf->save($filename);
    
            return [
                'url' => env('BASE_PATH').$filename
            ];
        }
    }

    protected function processSss2($school_id, $class_id, $session, $type)
    {
        $students = Student::query()
            ->select(DB::raw('MAX(students.id) as id, MAX(students.regnum) as regnum, MAX(students.passport) as passport,
                                MAX(classes.class_name) as clas, MAX(class_arms.class_arm) as arm'),
                                'students.surname as surname', 'students.firstname as firstname',
                                'students.middlename as middlename', 'students.created_at as reg_date')
            ->where('students.school_id', $school_id)
            ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
            ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
            ->join('classes', 'class_arms.class_id', '=', 'classes.id')
            ->where('classarm_student.class_id', $class_id)
            ->where('classarm_student.session', $session)
            ->orderBy('students.surname','asc')
            ->orderBy('students.firstname','asc')
            ->orderBy('students.middlename','asc')
            ->groupBy('students.id')
            ->groupBy('students.surname', 'students.firstname', 'students.middlename')
            ->get();
        
        if($students->count() == 0) {
            abort(400, 'No students found');
        }

        $ids = $students->pluck('id')->toArray();

        $first_session = $session;
        $second_session = $session - 1;

        $first_session_payments = DigitalPayment::where('session', $first_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

        $second_session_payments = DigitalPayment::where('session', $second_session)
                                        ->where('is_verified', true)
                                        ->whereIn('student_id', $ids)
                                        ->get();

  
        $transfers = Transfer::where('student_new_school', $school_id)->whereIn('student_new_id', $ids)->get();

        $first_session_total = 0;
        $first_session_debt = 0;
        $first_session_paid = 0;

        $second_session_total = 0;
        $second_session_debt = 0;
        $second_session_paid = 0;

        $data = $students->map(function($student) use ($first_session_payments, 
                                                        $second_session_payments,
                                                        $transfers, $first_session,
                                                        $second_session,
                                                        &$first_session_total, &$first_session_debt,
                                                        &$first_session_paid, &$second_session_total,
                                                        &$second_session_debt, &$second_session_paid) 
                {
                    $first_payment = $first_session_payments->firstWhere('student_id', $student->id);
                    $first_payment = $first_payment ? true : false;

                    if(! $first_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $first_payment = DigitalPayment::where('session', $first_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $first_payment ? $first_session_paid += 1 : $first_session_debt += 1;
                    $first_session_total += 1; 

                    $second_payment = $second_session_payments->firstWhere('student_id', $student->id);
                    $second_payment = $second_payment ? true : false;

                    if(! $second_payment && $transfers->count() > 0) {
                        $transfer = $transfers->firstWhere('student_new_id', $student->id);
                        
                        if($transfer) {
                            $second_payment = DigitalPayment::where('session', $second_session)
                                                        ->where('is_verified', true)
                                                        ->where('student_id', $transfer->student_former_id)
                                                        ->exists();
                        }
                    }

                    $second_payment ? $second_session_paid += 1 : $second_session_debt += 1;
                    $second_session_total += 1; 

                    
                    $remark = '-';

                    $reg_date = date('Y',strtotime($student->reg_date));

                    $is_tranfer = $transfers->firstWhere('student_new_id', $student->id);

                    if(is_null($is_tranfer) && $second_session != $reg_date) {
                        $is_tranfer = true;
                    }

                    $is_tranfer =  $is_tranfer ? 'TRANSFER' : 'DIRECT';

                    if($first_payment && $second_payment) {
                        $remark = 'Cleared';
                    }
                    
                    return [
                        'fullname' => strtoupper($student->surname).' '.strtoupper($student->firstname).' '.strtoupper($student->middlename),
                        'regnum' => $student->regnum,
                        'class' => strtoupper($student->clas).' ('.strtoupper($student->arm).')',
                        'passport' => $student->passport,
                        'reg_date' => $reg_date,
                        'first_payment' => $first_payment ? 'PAID' : 'NO RECORD',
                        'second_payment' => $second_payment ? 'PAID' : 'NO RECORD',
                        'remark' => $remark,
                        'admission_mode' => $is_tranfer
                    ];
                });

            $first_session_b = $first_session + 1;
            $second_session_b = $second_session + 1;
           
            $all_session = [
                'first' => 'SSS 2 ('.$first_session.'/'.$first_session_b.')',
                'second' => 'SSS 1 ('.$second_session.'/'.$second_session_b.')'
            ];

        if($type == 'show') {
            return [
                'students' => $data,
                'session' => $all_session
            ];
        }

        if($type == 'print') {
            $schoolData = School::find($school_id);

            abort_if(is_null($schoolData), 400, 'School data not found');

            $amount = DB::table('payment_items')->first()->cost;

            $first_session_total = $amount * $first_session_total;
            $first_session_debt = $amount * $first_session_debt;
            $first_session_paid = $amount * $first_session_paid;

            $second_session_total = $amount * $second_session_total;
            $second_session_debt = $amount * $second_session_debt;
            $second_session_paid = $amount * $second_session_paid;

            $total = $first_session_total + $second_session_total;
            $paid = $first_session_paid + $second_session_paid;
            $debt = $first_session_debt + $second_session_debt;

            $schoolLogo = env('BASE_PATH_2').str_replace(' ', '%20', $schoolData->logo);

            $state = env('STATE_NAME', 'ONDO');
            $lgas = NgStatesLGA::find($schoolData->lga_id);
            $school_lga = $lgas ? $lgas->name : 'N/A';


            $pdf = PDF::loadView('school.pdf.sss2eligible', 
                            ['students' => $data,
                            'schoolLogo' => $schoolLogo, 
                            'schoolData' => $schoolData,
                            'school_lga' => $school_lga,
                            'state' => $state,
                            'sessions' => $all_session,
                            'total' => number_format($total),
                            'paid' => number_format($paid),
                            'debt' => number_format($debt),
                            'first_session_total' => number_format($first_session_total),
                            'first_session_debt' => number_format($first_session_debt),
                            'first_session_paid' => number_format($first_session_paid),
                            'second_session_total' => number_format($second_session_total),
                            'second_session_debt' => number_format($second_session_debt),
                            'second_session_paid' => number_format($second_session_paid),
                            'student_class' => 'SSS 2',
                            ])
            ->setPaper('a4', 'landscape');
    
            $filename = 'generatedPdf/'.str_replace([' ', '/'], '-', $schoolData->name).'-SSS2_eligible_students.pdf';
    
            $pdf->save($filename);
    
            return [
                'url' => env('BASE_PATH').$filename
            ];
        }
    }

    // protected function getPreviouseClass($class_cat, $school_id): array
    // {
    //     if($class_cat == 'JSS3') {
    //         $JSS2 = Classes::whereSchoolId($school_id)->where('class_name', 'like', 'J%')
    //                         ->where(function($query) {
    //                             return $query->where('class_name', 'like', '%2%')
    //                                     ->orWhere('class_name', 'like', '%two%')
    //                                     ->orWhere('class_name', 'like', '%II');
    //                         })->first();

    //         $JSS1 = Classes::whereSchoolId($school_id)->where('class_name', 'like', 'J%')
    //                         ->where(function($query) {
    //                             return $query->where('class_name', 'like', '%1%')
    //                                     ->orWhere('class_name', 'like', '%one%')
    //                                     ->orWhere('class_name', 'like', '%I');
    //                         })->first();

    //         return [
    //             'JSS2' => $JSS2 ? $JSS2->id : false,
    //             'JSS1' => $JSS1 ? $JSS1->id : false,
    //         ];
    //     }

    //     if($class_cat == 'SSS2') {
    //         $SSS1 = Classes::whereSchoolId($school_id)
    //                         ->where('class_name', 'like', 'S%')
    //                         ->where(function($query) {
    //                             return $query->where('class_name', 'like', '%1%')
    //                                         ->orWhere('class_name', 'like', '%one%')
    //                                         ->orWhere('class_name', 'like', '%I');
    //                         })->first();

    //         return [
    //             'SSS1' => $SSS1 ? $SSS1->id : false
    //         ];
    //     }

    //     if($class_cat == 'SSS3') {

    //         $SSS2 = Classes::whereSchoolId($school_id)
    //                         ->where('class_name', 'like', 'S%')
    //                         ->where(function($query) {
    //                             return $query->where('class_name', 'like', '%2%')
    //                                         ->orWhere('class_name', 'like', '%two%')
    //                                         ->orWhere('class_name', 'like', '%II');
    //                         })->first();

    //         $SSS1 = Classes::whereSchoolId($school_id)
    //                         ->where('class_name', 'like', 'S%')
    //                         ->where(function($query) {
    //                             return $query->where('class_name', 'like', '%1%')
    //                                         ->orWhere('class_name', 'like', '%one%')
    //                                         ->orWhere('class_name', 'like', '%I');;
    //                         })->first();

    //         return [
    //             'SSS2' => $SSS2 ? $SSS2->id : false,
    //             'SSS1' => $SSS1 ? $SSS1->id : false,
    //         ];
    //     }
    // }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}