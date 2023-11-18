<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LibraryIssueCollection;
use App\Repositories\Interfaces\LibraryIssueRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewLibraryIssueController extends Controller
{
    /**
    * Book Repository class
    * @var obj
    */
    protected $lib;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin,
     LibraryIssueRepositoryInterface $lib) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->lib = $lib;
    }

    /**
    * Retrieve all Library Book Issuance Records in a School
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->lib->setData()->query();

        $books = $query
        ->where('library_issue.school_id', $school_id)
        ->select('library_issue.id as id', 'library_issue.issue_date as issue_date', 'library_issue.due_date as due_date', 'library_issue.return_date as return_date', 'library_issue.return_status as return_status', 'library.title as title', 'library.author as author', 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->leftJoin('library', 'library_issue.book_id', '=', 'library.id')
        ->leftJoin('students', 'library_issue.issued_to', '=', 'students.id')
        ->when($request->query('query'), function ($q, $query) {
            return $q->where(function ($q) use ($query) { 
                $q->where('library.title', 'like', '%'.$query.'%')
                ->orWhere('library.author', 'like', '%'.$query.'%')
                ->orWhere('students.surname', 'like', '%'.$query.'%')
                ->orWhere('students.firstname', 'like', '%'.$query.'%')
                ->orWhere('students.middlename', 'like', '%'.$query.'%')
                ->orWhere('library_issue.issue_date', 'like', '%'.$query.'%')
                ->orWhere('library_issue.due_date', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('library_issue.issue_date', 'asc')
        ->paginate(20)
        ->appends($request->query());

        return new LibraryIssueCollection($books);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}