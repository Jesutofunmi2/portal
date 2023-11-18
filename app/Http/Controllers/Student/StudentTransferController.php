<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DebtorPenalty;
use App\Models\ResultVoucher;
use App\Models\Student\Student;
use App\Models\Transfer;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentTransferController extends Controller
{
    protected $students;

    public function __construct(StudentRepositoryInterface $students) 
    {
        $this->middleware('auth:student_api');

        $this->students = $students;
    }

    public function index(Request $request)
    {
        $request->validate([
            'school_id' => 'required|integer',
            'reason' => 'required|string',
        ]);
        
        $user = Auth::guard('student_api')->user();

        $student_current_class = DB::table('classarm_student')
                                ->where('student_id', $user->id)
                                ->orderBy('session', 'desc')
                                ->first();

        if(is_null($student_current_class)) {
            abort(400, 'Student current class not found');
        }
                                
        $transfer = new Transfer;

        $student_transfer =  $transfer->where('student_former_school', $user->school_id)
                                      ->where('student_former_id', $user->id)
                                      ->where('session', $student_current_class->session)
                                      ->first();

        $debtor = DebtorPenalty::where('student_id', $user->id)
                                ->where('status', 0)
                                ->first();

       if(is_null($student_transfer)) {

            $transfer->create([
                        'student_former_id' => $user->id,
                        'student_former_school' =>  $user->school_id,
                        'student_new_school' => $request->input('school_id'),
                        'session' => $student_current_class->session,
                        'class_id' => $student_current_class->class_id,
                        'term' => $student_current_class->term,
                        'classarm_id' => $student_current_class->classarm_id,
                        'reason_for_transfer' => $request->input('reason'),
                        'debtor_id' => $debtor ? $debtor->id : NULL
                    ]);

            return response()->json([
                'data' => [
                    'message' => 'You have successfully created a transfer request'
                ]
            ]);
        }
        else {
            $student_transfer->update([
                    'student_new_school' => $request->input('school_id'),
                    'session' => $student_current_class->session,
                    'class_id' => $student_current_class->class_id,
                    'term' => $student_current_class->term,
                    'classarm_id' => $student_current_class->classarm_id,
                    'reason_for_transfer' => $request->input('reason'),
                    'debtor_id' => $debtor ? $debtor->id : NULL
            ]);

            return response()->json([
                    'data' => [
                        'message' => 'Your initial transfer request has been updated'
                    ]
            ]);
       }
    }

    public function currentSchool()
    {
        $id = Auth::guard('student_api')->id();
      
        $studentData = $this->students->find($id);

        return response()->json([
            'data' => [
                'school_name' => $studentData->school->name,
                'school_id' => $studentData->school_id
            ]
       ]);
    }
}
