<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Imports\CommentsImport;
use App\Exports\CommentsExport;
use Auth;
use Gate;

class UploadCommentController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index(Request $request)
    {

        $rules = [
            'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'comment' => 'required|in:comment_teacher,comment_house,comment_guard,comment_principal',
        ];

        $messages = [
            'file.required' => 'Please upload an appropriate file',
            'file.file' => 'Please upload an appropriate file',
            'file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'comment.required' => 'Please select a Comment Type',
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
        $comment = $request->input('comment');

        if ($request->hasFile('file')) {

            $data = [
                'session' => $session,
                'term' => $term,
                'class_id' => $class_id,
                'classarm_id' => $classarm_id,
                'comment' => $comment,
                'school_id' => $school_id,
            ];

            $import = new CommentsImport($data);
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
                    'message' => 'Batch Comment Update complete',
                    'failures' => $failures,
                    'errors' => $errors,
                ]
            ]);
            
        }
    }

    public function downloadBatchFile(Request $request) 
    {
        $rules = [
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'comment' => 'required|in:comment_teacher,comment_house,comment_guard,comment_principal',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'comment.required' => 'Please select a Comment type',
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
        $comment = $request->input('comment');

        $data = [
            'session' => $session,
            'term' => $term,
            'class_id' => $class_id,
            'classarm_id' => $classarm_id,
            'school_id' => $school_id,
            'comment' => $comment,
        ];
            
        return (new CommentsExport($data))->download('StudentResultCommentTemplate.xls');
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}