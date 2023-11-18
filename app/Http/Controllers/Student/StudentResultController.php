<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DigitalPayment;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentResultController extends Controller
{
    protected $students;

    public function __construct(StudentRepositoryInterface $students) 
    {
        $this->middleware('auth:student_api');

        $this->students = $students;
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'session'      => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
        ]);
        
        $user = Auth::guard('student_api')->user();

        return response()->json([
                'data' => [
                    'message' => 'Your initial transfer request has been updated'
                ]
        ]);
    }

    public function printResultCheck(Request $request)
    {  
        $this->validate($request, [
            'session'      => 'required|int'
        ]);

        $user = Auth::guard('student_api')->user();

        $payment = DigitalPayment::where([
            'student_id' => $user->id,
            'session' => $request->session
            ])
            ->first();

        $session = $request->session + 1;

        if(! ($payment && $payment->is_verified == true)){
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "Sorry, you have not make digital payment for $request->session/$session"
                ]
            ]);
        }

        $student_class = DB::table('classarm_student')
                                ->where('student_id', $user->id)
                                ->where('session', $request->session)
                                ->where('term', $request->term)
                                ->first();
                            
        if(is_null($student_class)) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "Sorry, you don't have session record for $request->session/$session ($request->term) term."
                ]
            ]);
        }

        $student = $this->students->find($user->id);
        $school_id = $student->school_id;

        $student_results = $student->studentResults()
                            ->select('status')
                            ->where('session', $request->session)
                            ->where('class_id', $student_class->class_id)
                            ->where('classarm_id', $student_class->classarm_id)
                            ->where('term', $student_class->term)
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
                    'message' => "Sorry, This result is locked"
                ]
            ]);
        }
   
        return response()->json([
            'data' => [
                'status' => true,
                'message' => "You have make digital payment for $request->session/$session",
                'student' => $student_class
            ]
        ]);
    }

    public function studentSession()
    {
        $user = Auth::guard('student_api')->user();

        $student_class = DB::table('classarm_student')
                                ->select('session')
                                ->where('student_id', $user->id)
                                ->groupBy('session')
                                ->orderBy('session', 'desc')
                                ->get();

        if(! count($student_class)) {
            abort(400, 'Sorry, No session record found');
        }
      
        return response()->json([
            'data' => [
                'sessions' => $student_class->pluck('session')
            ]
       ]);
    }
}
