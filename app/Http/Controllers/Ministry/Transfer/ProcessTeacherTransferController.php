<?php
namespace App\Http\Controllers\Ministry\Transfer;

use App\Http\Controllers\Controller;
use App\Models\TransferTeacher;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProcessTeacherTransferController extends Controller
{
    //
    protected $teacher;

    protected $admin;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:ministry_api');

        $this->teacher = $teacher;
    }

    public function index($id=null)
    {    
        if($this->permissionDeny('new-teacher-transfer')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $teacher = $this->teacher->setTeacher()
        ->select('teachers.id as id', 'teachers.surname as surname', 'teachers.firstname as firstname', 'teachers.middlename as middlename', 'teachers.passport as passport', 'teachers.staff_no as staff_no', 'transfers_teacher.new_school as new_school', 'transfers_teacher.session as session', 'transfers_teacher.reason_for_transfer as reason_for_transfer', 'transfers_teacher.term as term', 'transfers_teacher.transfer_status')
        ->leftJoin('transfers_teacher', 'teachers.id', '=', 'transfers_teacher.teacher_id')
        ->where(['teachers.id' => $id, 'transfers_teacher.transfer_status' => 0])
        ->first();

        if (!is_null($teacher->new_school)) {
            $lga_id = DB::table('schools_new')
            ->where('id', $teacher->new_school)
            ->value('lga_id');
        } else {
            $lga_id = null;
        }

        return response()->json([
            'data' => [
                'teacher' => $teacher,
                'lga_id' => $lga_id,
            ]
        ]);

    }

    public function update(Request $request, $id=null)
    {
        if($this->permissionDeny('new-teacher-transfer')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $setTeacher = $this->teacher->find($id);
        if($setTeacher) {
            //Get the school_id
            $school_id = $setTeacher->school_id;

            $messages = [
                'school_id.required' => 'The School field is required.',
                'school_id.integer' => 'Please select an existing School.',
                'school_id.not_in' => 'You must select another School.',
                'session.integer' => 'Please select an exisiting Session.',
                'term.regex' => 'Please select a relevant term.',
            ];
    
            $rules = [
                'session' => 'required|integer',
                'term' => ['required','regex:/^(First|Second|Third)/'],
                'reason_for_transfer' => 'required|string',
                'former_staff_no' => 'required',
                'school_id' => 'required|integer|not_in:'.$school_id,
            ];
    
            $this->validate($request, $rules, $messages);

            DB::table('transfers_teacher')
            ->updateOrInsert(
                [
                    'teacher_id' => $id, 
                    'session' => $request->input('session'),
                    'term' => $request->input('term'),
                    'former_staff_no' => $request->input('former_staff_no'),
                    'former_school' => $school_id,
                ],
                [
                    'reason_for_transfer' => $request->input('reason_for_transfer'),
                    'new_school' => $request->input('school_id'),
                    'transfer_status' => $request->input('transfer_status'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            return response()->json([
                'data' => [
                    'message' => 'Teacher transfer request submitted successfully'
                ]
            ]);
        }
    }

    public function confirmTransfer(Request $request) 
    {
        if($this->permissionDeny('confirm-teacher-transfer')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rule = [
            'id' => 'required|integer',
        ];

        $this->validate($request, $rule);

        $id = $request->input('id');

        $transfer = DB::table('transfers_teacher')->where('id', $id)->first();

        $teacher_id = $transfer->teacher_id;
        $session = $transfer->session;
        $school_id = $transfer->new_school;

        if ($transfer && $teacher_id && $session && $school_id) {
            $state_id = env('STATE_ID');
            $state = DB::table('states')
            ->where('id', $state_id)
            ->value('name');

            //Generate new staff no
            $staff_no_digit = $this->teacher->getNextStaffDigit($session, $school_id);
            $staff_no = strtoupper($state).'/'.str_pad($school_id, 4, 0, STR_PAD_LEFT).'/STAFF/'.$session.'/'.str_pad($staff_no_digit, 4, "0", STR_PAD_LEFT);

            $teacher = $this->teacher->find($teacher_id);

            DB::beginTransaction();

            try {

                if ($teacher) {
                    $teacher->staff_no_digit = $staff_no_digit;
                    $teacher->staff_no = $staff_no;
                    $teacher->school_id = $school_id;
                    $teacher->session = $session;

                    $teacher->save();

                    $teacher->subjects()->detach();
	            	$teacher->permission_classes()->detach();
                    $teacher->houses()->detach();
                    $teacher->classarms()->detach();
	            	$teacher->counsellors()->detach();
                }

                //Approve Teacher's Transfer
                DB::table('transfers_teacher')
                ->where('id', $id)
                ->update([
                    'transfer_status' => 1,
                    'new_staff_no' => $staff_no, 
                ]);

                DB::commit();

                return response()->json([
                    'data' => [
                        'message' => 'Transfer successfully confirmed',
                    ]
                ]);
        
            } catch (Exception $e) {

                DB::rollBack();

                return response()->json([
                    'message' => 'The transfer was not confirmed, please try again later',
                ], 400);

            }
        } else {
            return response()->json([
                'message' => 'The transfer was not confirmed, please try again later',
            ], 400);
        }
    }

    public function deleteTransfer(Request $request)
    {
        if($this->permissionDeny('confirm-teacher-transfer')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rule = [
            'id' => 'required|integer',
        ];

        $this->validate($request, $rule);

        $id = $request->input('id');

        $transfer = TransferTeacher::query()->where('id', $id)->first();
        

        if(is_null($transfer)) {
            return response()->json([
                'message' => 'Transfer not found',
            ], 400);
        }

        if($transfer->transfer_status == 1) {
            return response()->json([
                'message' => 'Transfer has already been approved',
            ], 400);
        }
 
        $transfer->delete();

        return response()->json([
            'message' => 'Transfer request deleted successfully',
        ], 200);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}