<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryIssueRepositoryInterface;
use App\Http\Resources\LibraryIssueResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class EditLibraryIssueController extends Controller
{
    //
    protected $lib;

    protected $admin;

    public function __construct(LibraryIssueRepositoryInterface $lib, AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->lib = $lib;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        
        $lib = $this->lib->setData()
        ->select('library_issue.id as id', 'library_issue.issue_date as issue_date', 'library_issue.due_date as due_date', 'library_issue.return_date as return_date', 'library_issue.return_status as return_status', 'library.title as title', 'library.author as author', 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->leftJoin('library', 'library_issue.book_id', '=', 'library.id')
        ->leftJoin('students', 'library_issue.issued_to', '=', 'students.id')
        ->where('library_issue.id', $id)
        ->first();

        return response()->json([
            'data' => $lib,
        ]);

    }

    public function update(Request $request, $id = null)
    {
        $setLib = $this->lib->find($id);

        if($setLib){

            //Get the school admin id
            $admin_id = Auth::guard('school_api')->id();
            //Get the school_id
            $school_id = $this->admin->find($admin_id)->school_id;
    
            $messages = [
                'due_date.required' => 'A due date is required',
                'due_date.date_format' => 'The Due Date field does not match the format YYYY-mm-dd',
                'return_date.required' => 'A return date is required',
                'return_date.date_format' => 'The Return Date field does not match the format YYYY-mm-dd',
                'return_status.required' => 'The Return status field is required',
            ];
            
            $rules = [
                'due_date' => 'required|date_format:Y-m-d', 
                'return_date' => 'required|date_format:Y-m-d',
                'return_status' => 'required|int', 
            ];
    
            $this->validate($request, $rules, $messages);

            $lib = $setLib->update([
                'due_date' => $request->input('due_date'), 
                'return_date' => $request->input('return_date'), 
                'return_status' => $request->input('return_status'), 
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Book Issuance record updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
