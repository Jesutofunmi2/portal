<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryIssueRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class CreateLibraryIssueController extends Controller
{
    //
    protected $library;
    //
    protected $admin;

    public function __construct(LibraryIssueRepositoryInterface $library, AdminRepositoryInterface $admin) {
        $this->middleware('auth:school_api');
        $this->lib = $library;
        $this->admin = $admin;
    }

    /**
    * Add Library Issue
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        
        $setLib = $this->lib->setData();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $messages = [
            'book_id.required' => 'A book selection is required',
            'issued_to.required' => 'The issued to field is required',
            'issue_date.required' => 'A date of issuance is required',
            'issue_date.date_format' => 'The Issuance Date field does not match the format YYYY-mm-dd',
            'due_date.required' => 'A due date is required',
            'due_date.date_format' => 'The Due Date field does not match the format YYYY-mm-dd',
        ];
        
        $rules = [
            'book_id' => 'required|int', 
            'issued_to' => 'required|int', 
            'issue_date' => 'required|date_format:Y-m-d', 
            'due_date' => 'required|date_format:Y-m-d', 
        ];

        $this->validate($request, $rules, $messages);
        
        $lib = $setLib->create([
            'school_id' => $school_id,
            'book_id' => $request->input('book_id'), 
            'issued_to' => $request->input('issued_to'), 
            'issue_date' => $request->input('issue_date'), 
            'due_date' => $request->input('due_date'), 
            'return_date' => $request->input('due_date'), 
            'return_status' => 0, 
            'issued_by' => $admin_id,
        ]);

        return response()->json([
            'data' => [
                'message' => "Book Issuance record successfully created"
            ]
        ]);
    }

    /**
    * Check for ability to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
