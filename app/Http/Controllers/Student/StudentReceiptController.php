<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DigitalPayment;
use App\Models\ResultVoucher;
use App\Models\Student\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReceiptController extends Controller
{
    protected $students;

    public function __construct(StudentRepositoryInterface $students) 
    {
        $this->students = $students;
    }

    public function index(Request $request)
    {
        $request->validate([
            'session' => 'required|integer',
            'type' => 'sometimes|integer',
            'student_id' => 'sometimes|integer',
        ]);

        if($request->has('type') && $request->type == 1) {
            $id = $request->student_id;
        }
        else {
            $id = Auth::guard('student_api')->id();
        }
       
        $studentData = $this->students->find($id);
        
        $session = $request->session;

        $student = Student::select('students.id', 'students.surname', 'students.firstname', 
                                        'students.middlename', 'students.regnum',
                                        'students.passport',
                                        'digital_payments.is_verified',
                                        'digital_payments.created_at'
                                        )
                                    ->where('students.id', $studentData->id)
                                    ->join('digital_payments', function($join) use ($session) {
                                        $join->on('students.id', '=', 'digital_payments.student_id')
                                        ->where('digital_payments.session', '=', $session)
                                        ->where('digital_payments.is_verified', '=', 1);
                                   })
                                    ->first();

        $student_voucher = ResultVoucher::where('student_id', '=', $studentData->id)
                                    ->where('session', $request->session)->first();

        if($student &&  $student_voucher) {

            if($request->has('type') && $request->type == 1) {
                return view('school.reciepts', compact('student', 'student_voucher'));
            }

            return response()->json([
                'data' => [
                    'status' => true,
                    'id' => $id,
                    'message' => 'Successful'
                ]
            ]);
        }

       return response()->json([
            'data' => [
                'status' => false,
                'id' => $id,
                'message' => 'Sorry, no payment found for this session'
            ]
       ]);
    }
}
