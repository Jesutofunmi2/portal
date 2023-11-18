<?php

namespace App\Http\Controllers\Ministry\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use Auth;
use Gate;
use Excel;
use App\Http\Helper\ExcelHelper;
use Illuminate\Support\Carbon;
use App\Http\Resources\MinistrySubjectViewResource;

class SubjectController extends Controller
{
    //
    protected $subjects;

    public function __construct(SubjectRepositoryInterface $subjects) {
        $this->subjects = $subjects;

        $this->middleware('auth:ministry_api');
    }
  
    public function createSingleSubject(Request $request)
    {
        if($this->permissionDeny('create-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

    	$subjects = $this->subjects->setSubject();

        $this->validate($request, $subjects::$rules);

        $subjects->create([
            'subject_name' => $request->subject_name,
            'subject_code' => strtoupper(str_replace(' ', '-', $request->subject_code)),
            'class_category' => $request->class_category,
        ]);

        return response()->json([
            'data' => [
                'message' => 'Subject Registered Successfully'
            ]
        ]);

    }

    public function createBatchSubject(Request $request)
    {
        if($this->permissionDeny('create-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

    	$subjects = $this->subjects->setSubject();

        $this->validate($request, $subjects::$ruleBatch);

        $path = $request->file('batch_file')->getRealPath();

        $data = Excel::toCollection(new ExcelHelper ,$path);

        $insert = array();
        $duplicacy = array();

        if(!empty($data[0]) && $data[0]->count()){
            foreach ($data[0] as $key => $value) {

                $count = $subjects->where('subject_name',$value['subject_name'])
                                    ->orWhere('subject_code',$value['subject_code'])->exists();
                

                if(! $count){
                    $insert[] = [
                        'subject_name' => ucwords($value['subject_name']),
                        'subject_code' => strtoupper(str_replace(' ', '-', $value['subject_code'])),
                        'class_category' => $value['class_category'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                        ];
                } else{
                    $duplicacy[] = $value['subject_name'].' already exist';
                }
                
            }
        }

        $subjects->insert($insert);

        return response()->json([
            'data' => [
                'message' => 'Successfully inserted '.count($insert).' Subjects',
                'duplicacy' => $duplicacy
            ]
        ]);

    }

    public function updateSubject(Request $request)
    {
        if($this->permissionDeny('edit-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

    	$subjects = $this->subjects->setSubject();

        $subjects::$rules['id'] = 'required|integer';

        $this->validate($request, $subjects::$rules);

        $subjects->find($request->id)->update([
            'subject_name' => $request->subject_name,
            'subject_code' => strtoupper(str_replace(' ', '-', $request->subject_code)),
            'class_category' => $request->class_category,
        ]);

        return response()->json([
            'data' => [
                'message' => 'Subject Updated Successfully'
            ]
        ]);

    }

    public function deleteSubject($id = null)
    {
        if($this->permissionDeny('delete-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

    	$subjects = $this->subjects->setSubject();

        $subjects = $this->subjects->find($id);

        $subjects->delete();

        return response()->json([
            'data' => [
                'message' => 'Subject Deleted Successfully'
            ]
        ]);

    }

    public function viewSubject(Request $request)
    {
        if($this->permissionDeny('view-subject')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        $subjects = $this->subjects->setSubject();

        $subject = $subjects->paginate(20);

        return MinistrySubjectViewResource::collection($subject);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
