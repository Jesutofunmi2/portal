<?php

namespace App\Http\Controllers\Admins\SchoolID;

use Auth;
use Gate;
use Carbon\Carbon;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\DigitalPayment;
use App\Http\Helper\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StudentIDCardRequest;
use App\Http\Resources\ClassResource;
use App\Http\Resources\IdCardResource;
use App\Http\Resources\StudentCollection;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentIdCardController extends Controller
{
    //
    protected $admin;

    protected $student;

    /**
    * Class Repository class
    * @var obj
    */
    protected $clas;

    public function __construct(AdminRepositoryInterface $admin,
                            StudentRepositoryInterface $student,
                            ClassRepositoryInterface $clas)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->student = $student;
        $this->clas = $clas;

    }

    public function create(Request $request)
    {  
        $this->validate($request, [
            'ids' => 'required|array',
            'session' => 'required|integer'
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

        $message = [];
        $data = [];
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $session = $request->session;
        $counter = 0;

        $students = $this->student->setStudent()
            ->select('students.id', 'students.surname', 'students.firstname',
                    'student_id_card_requests.admin_id',
                    'student_id_card_requests.is_verified',
                    'student_id_card_requests.created_at'
                    )
            ->selectRaw('digital_payments.is_verified as payment')
            ->where([
                    'students.school_id' => $school_id,
                    ])
            ->whereIn('students.id', $request->ids)
            ->leftJoin('student_id_card_requests', function($join) use ($session){
                $join->on('students.id', '=', 'student_id_card_requests.student_id')
                ->where('student_id_card_requests.session', '=', $session);
            })
            ->leftJoin('digital_payments', function($join) use ($session) {
                 $join->on('students.id', '=', 'digital_payments.student_id')
                 ->where('digital_payments.session', '=', $session);
            })
            ->get();

        $idss = $students->each(function($student) use ($session, $now, $admin_id, $school_id, &$message, &$data, &$counter){
            if (is_null($student->admin_id) && is_null($student->is_verified) && !is_null($student->payment) && ($student->payment == 1)) {
                $data[] = [
                    'school_id'=> $school_id,
                    'student_id' => $student->id,
                    'admin_id' => $admin_id,
                    'session' => $session,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $counter++;
            }
            elseif (!is_null($student->payment) && $student->payment == 0) {
                $message[] = $student->surname.' '.$student->firstname.' digital payment for this session has not been verify.';
            }
            elseif (is_null($student->payment)) {
                $message[] = $student->surname.' '.$student->firstname.' has not made the digital payment for this session';
            }
            elseif (! is_null($student->payment)) {
                $status = $student->is_verified ? "verified" : "pending";
                $message[] = 'A '.$status.' id card request was already made '.optional($student->created_at)->diffForHumans().' for '.$student->surname.' '.$student->firstname. ' this session';
            }
        });

        // save to database i.e send id request
        if(count($data)) StudentIDCardRequest::insert($data);
        
        if($counter) {
            $msg = urlencode(ucfirst($admin->school->name)." made ".$counter." ID Card Request just now");
            GeneralHelper::prepareSMSGateWay(urlencode('ODSGMOE'), urlencode(2348053081549), $msg);
        }
        
        return response()->json([
            'count' => $counter,
            'message' => $message
        ]);
    }

    public function approved(Request $request)
    { 
        $request->validate(['session' => ['required', 'integer']]);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

        $students = StudentIDCardRequest::query()
        ->select('students.id', 'students.surname',
                    'students.firstname', 'students.regnum',
                    'students.middlename', 'students.passport',
                    'student_id_card_requests.created_at',
                    'student_id_card_requests.updated_at'
                    )
        ->where([
                'student_id_card_requests.school_id' => $school_id,
                'student_id_card_requests.is_verified' => true,
                'student_id_card_requests.session' => $request->session
                ])
        ->join('students', 'students.id', '=', 'student_id_card_requests.student_id')
        ->get();

        return IdCardResource::collection($students);
    }

    public function pending(Request $request)
    { 
        $request->validate(['session' => ['required', 'integer']]);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

        $students = StudentIDCardRequest::query()
            ->select('students.id', 'students.surname',
                        'students.firstname', 'students.regnum',
                        'students.middlename', 'students.passport',
                        'student_id_card_requests.created_at',
                        )
            ->where([
                    'student_id_card_requests.school_id' => $school_id,
                    'student_id_card_requests.is_verified' => false,
                    'student_id_card_requests.session' => $request->session
                    ])
            ->join('students', 'students.id', '=', 'student_id_card_requests.student_id')
            ->get();

        return IdCardResource::collection($students);
    }

    public function cancel(Request $request)
    {
        $this->validate($request, [
            'ids' => ['required', 'array'],
            'session' => ['required', 'integer']
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

        $students = StudentIDCardRequest::query()
            ->where([
                    'school_id' => $school_id,
                    'session' => $request->session,
                    ])
            ->whereIn('student_id', $request->ids)
            ->delete();

        return response()->json([
            'message' => 'Request Cancelled Successfully'
        ]);
    }

    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
