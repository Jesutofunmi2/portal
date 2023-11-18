<?php

namespace App\Http\Controllers\Admins\Result;

use App\Exports\ResultsBySubjectExport;
use App\Exports\ResultsExport;
use App\Http\Controllers\Controller;
use App\Imports\ResultBySubjectImport;
use App\Imports\ResultsImport;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UploadResultController extends Controller
{
    //
    protected $admin;

    protected $student;

    public function __construct(AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index(Request $request)
    {
        if($this->permissionDeny('batch-upload-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ];

        $messages = [
            'file.required' => 'Please upload an appropriate file',
            'file.file' => 'Please upload an appropriate file',
            'file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'subject_id.required' => 'Please select a Subject',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        $subject_id = $request->input('subject_id');
        $class_catg = DB::table('subjects')
        ->where('id', $subject_id)
        ->value('class_category');

        if ($request->hasFile('file')) {

            $data = [
                'session' => $session,
                'term' => $term,
                'class_id' => $class_id,
                'classarm_id' => $classarm_id,
                'subject_id' => $subject_id,
                'school_id' => $school_id,
                'class_catg' => $class_catg,
            ];

            $import = new ResultBySubjectImport($data);
            $import->import(request()->file('file'));

            $failures[] = [];
            $row = 0;
            foreach ($import->failures() as $failure) {
                $failures[$row]['row'] = $failure->row(); // row that went wrong
                $failures[$row]['attrib'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failures[$row]['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                $row++;
           }

            $errors = $import->errors();

            return response()->json([
                'data' => [
                    'message' => 'Batch Result Update complete',
                    'failures' => $failures,
                    'errors' => $errors,
                ]
            ]);
            
        }
    }

    public function downloadSubjectBatchFile(Request $request) 
    {
        $rules = [
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'subject_id.required' => 'Please select a Subject',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        $subject_id = $request->input('subject_id');

        $data = [
            'session' => $session,
            'term' => $term,
            'class_id' => $class_id,
            'classarm_id' => $classarm_id,
            'school_id' => $school_id,
            'subject_id' => $subject_id,
        ];
            
        return (new ResultsBySubjectExport($data))->download('studentResultBySubject.xls');
    }

    public function downloadBatchFile(Request $request) 
    {
        $rules = [
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');

        $subject_codes = DB::table('subjects')
        ->join('classarm_subject', 'subjects.id', '=', 'classarm_subject.subject_id')
        ->where('classarm_subject.classarm_id', $classarm_id)
        ->orderBy('subjects.subject_name')
        ->groupBy('subjects.id')
        ->pluck('subjects.subject_code');

        $data = [
            'session' => $session,
            'term' => $term,
            'class_id' => $class_id,
            'classarm_id' => $classarm_id,
            'school_id' => $school_id,
            'subject_codes' => $subject_codes,
        ];
            
        return (new ResultsExport($data))->download('student_result_all_subject.xls');
    }

    public function uploadAll(Request $request)
    {
        if($this->permissionDeny('batch-upload-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
        ];

        $messages = [
            'file.required' => 'Please upload an appropriate file',
            'file.file' => 'Please upload an appropriate file',
            'file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');

        if ($request->hasFile('file')) {

            $subjects = DB::table('subjects')
            ->select('subjects.id as id', 'subjects.subject_code as code', 'subjects.class_category as catg')
            ->join('classarm_subject', 'subjects.id', '=', 'classarm_subject.subject_id')
            ->where('classarm_subject.classarm_id', $classarm_id)
            ->orderBy('subjects.subject_name')
            ->get();

            $data = [
                'session' => $session,
                'term' => $term,
                'class_id' => $class_id,
                'classarm_id' => $classarm_id,
                'school_id' => $school_id,
                'subjects' => $subjects,
            ];

            $import = new ResultsImport($data);
            $import->import(request()->file('file'));

            $failures[] = [];
            $row = 0;
            foreach ($import->failures() as $failure) {
                $failures[$row]['row'] = $failure->row(); // row that went wrong
                $failures[$row]['attrib'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failures[$row]['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                $row++;
           }

            $errors = $import->errors();

            return response()->json([
                'data' => [
                    'message' => 'Batch Result Update complete',
                    'failures' => $failures,
                    'errors' => $errors,
                ]
            ]);
            
        }
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}