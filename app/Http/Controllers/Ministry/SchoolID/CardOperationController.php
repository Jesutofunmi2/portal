<?php

namespace App\Http\Controllers\Ministry\SchoolID;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\StudentIDCardRequest;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CardOperationController extends Controller
{
    protected $students;
    public function __construct(StudentRepositoryInterface $students)
    {
        $this->students = $students;
        $this->middleware('auth:ministry_api');
    }

    // approve id card request
    public function approve(Request $request)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate([
            'ids' => ['required', 'array'],
            'session' => ['required', 'integer']
        ]);
        
        $total = count($request->ids);

        $students = StudentIDCardRequest::where([
                            'is_verified' => false,
                            'session' => $request->session
                            ])
                            ->whereIn('student_id', $request->ids)
                            ->update(['is_verified' => true]);

        $successful = $students;
        $failed = $total - $successful;

        return response()->json([
            'data' => [
                'successful' => $successful,
                'failed' => $failed,
                'total' => $total
            ]
        ]);
    }

    // unapprove id card request
    public function unApprove(Request $request)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate([
            'ids' => ['required', 'array'],
            'session' => ['required', 'integer']
        ]);
        
        $total = count($request->ids);

        $students = StudentIDCardRequest::where([
                        'is_verified' => true,
                        'session' => $request->session
                        ])  
                    ->whereIn('student_id', $request->ids)
                    ->update(['is_verified' => false]);

        $successful = $students;
        $failed = $total - $successful;

        return response()->json([
            'data' => [
                'successful' => $successful,
                'failed' => $failed,
                'total' => $total
            ]
        ]);
    }

    // download/print id card request
    public function download(Request $request)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $request->validate([
            'ids' => ['required', 'array'],
            'school_id' => ['required', 'integer'],
            'session' => ['required', 'integer']
        ]);
        
        $students = StudentIDCardRequest::query()
            ->select('students.id', 'student_id_card_requests.is_downloaded')
            ->where([
                    'student_id_card_requests.is_verified' => true,
                    'student_id_card_requests.session' => $request->session,
                    ])
            ->whereIn('student_id', $request->ids)
            ->join('students', 'students.id', '=', 'student_id_card_requests.student_id')
            ->get();

        $students = $students->map(function ($student) {
            $is_downloaded = $student->is_downloaded;
            $student = $this->students->find($student->id);

            $student_class =  optional($student->classarms()->wherePivot('session', '=', $student->session)
                ->orderBy('term', 'desc')
                ->first())->class_id;

            // class id is found
            if ($student_class) {
                $class = optional(Classes::find($student_class))->class_name;

                //class name is found
                if(! is_null($class)) {
                    if(strtolower($class)[0] == 'j') $level = "JUNIOR";
                    if(strtolower($class)[0] == 's') $level = "SENIOR";
                    $exp = $this->getExpireDate($class);
                    $e = $exp + 1;
                    $expire = $exp.'/'. $e;
                }
            }
            else {
                $level = "N/A";
                $expire = "N/A";
            }

            return [
                'id' => $student->id,
                'fullname' => strtoupper("$student->surname $student->firstname $student->middlename"),
                'parent_phone' => $student->parent_phone,
                'passport' => $student->passport,
                'regnum' => $student->regnum,
                'gender' => strtoupper($student->gender),
                'level' => $level,
                'expire' => $expire,
                'is_downloaded' => $is_downloaded
            ];
        });

        $school_data = School::find($request->school_id, ['name', 'logo']);
        $state_name = config('app.state_name');
        $id_card_abbr = config('app.id_card_abbr');
        $public_url = 'https://odsgmoest.org.ng/eportal/public';
        $site_logo_url = config('app.site_logo_url');

        //StudentIDCardRequest::where('is_verified', true)->whereIn('student_id', $request->ids)
        //            ->update(['is_downloaded' => true]);


        return response()->json([
            'data' => [
                'students' => $students,
                'school_data' => $school_data,
                'state_name' => $state_name,
                'id_card_abbr' => $id_card_abbr,
                'public_url' => $public_url,
                'site_logo_url' => $site_logo_url
            ]
        ]);
    }

    public function downloaded(Request $request)
    { 
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate([
            'ids' => ['required', 'array'],
            'session' => ['required', 'integer']
        ]);
  
        StudentIDCardRequest::where([
                        'is_verified' => true,
                        'session' => $request->session
                    ])
                    ->whereIn('student_id', $request->ids)
                   ->update(['is_downloaded' => true]);


        return response()->json([
            'data' => [
                'message' => 'Updated Successfuly',
            ]
        ]);
    }

    protected function getExpireDate($class)
    {
        $year = date('Y');
        $class = strtolower($class);
        
        $first_letter = $class[0];
        $exp = null;
        $length = strlen($class);
        
        if ($first_letter == 'j') {
            
            for($i = 0; $i < $length; $i++) {
            
                if ($class[$i] == 1) {
                    $exp = $year + 5;
                    break;
                }
                
                if ($class[$i] == 2) {
                    $exp = $year + 4;
                    break;
                }
                
                if ($class[$i] == 3) {
                    $exp = $year + 3;
                    break;
                }
                
                if ($i >= 3) {
                    $c = substr($class, $i -2, $i);
                    
                    if($c == 'one') {
                        $exp = $year + 5;
                        break;
                    }
                    
                    if($c == 'two') {
                        $exp = $year + 4;
                        break;
                    }
                    
                    if($c == 'three') {
                        $exp = $year + 3;
                        break;
                    }
                    
                }
            }
             
            if ($length >= 3) {
                
                 for($i = 2; $i >= 0; $i--) {
                    $lower = $length - 1 - $i;
                    $c = substr($class, $lower, $length);
                   
                   if ($c == 'iii') {
                        $exp = $year + 3;
                        break;
                   }
                   
                   if ($c == 'ii') {
                        $exp = $year + 4;
                        break;
                   }
                   
                   if ($c == 'i') {
                        $exp = $year + 5;
                        break;
                   }
                }  
            }
        }
        
        else if ($first_letter == 's') {
                  
            for($i = 0; $i < $length; $i++) {
            
                if ($class[$i] == 1) {
                    $exp = $year + 2;
                    break;
                }
                
                if ($class[$i] == 2) {
                    $exp = $year + 1;
                    break;
                }
                
                if ($class[$i] == 3) {
                    $exp = $year;
                    break;
                }
                
                if ($i >= 3) {
                    $c = substr($class, $i -2, $i);
                    
                    if($c == 'one') {
                        $exp = $year + 2;
                        break;
                    }
                    
                    if($c == 'two') {
                        $exp = $year + 1;
                        break;
                    }
                    
                    if($c == 'three') {
                        $exp = $year;
                        break;
                    }
                    
                }
            }
             
            if ($length >= 3) {
                
                 for($i = 2; $i >= 0; $i--) {
                    $lower = $length - 1 - $i;
                    $c = substr($class, $lower, $length);
                   
                   if ($c == 'iii') {
                        $exp = $year;
                        break;
                   }
                   
                   if ($c == 'ii') {
                        $exp = $year + 1;
                        break;
                   }
                   
                   if ($c == 'i') {
                        $exp = $year + 2;
                        break;
                   }
                }  
            }
        }
        return $exp;
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}