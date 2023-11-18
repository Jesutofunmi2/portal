<?php

namespace App\Http\Controllers\Teacher\Result;

use App\Exports\CommentsExport;
use App\Http\Controllers\Controller;
use App\Imports\CommentsImport;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UploadCommentController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher) 
    {

        $this->middleware('auth:teacher_api');

        $this->teacher = $teacher;

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
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $school_id = $this->teacher->find($teacher_id)->school_id;

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
            'comment' => 'required|in:comment_teacher',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'comment.required' => 'Please select a Comment type',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $school_id = $this->teacher->find($teacher_id)->school_id;

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
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}