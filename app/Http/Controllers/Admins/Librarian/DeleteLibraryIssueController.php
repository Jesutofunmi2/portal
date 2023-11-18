<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\LibraryIssueRepositoryInterface;
use Auth;
use Gate;

class DeleteLibraryIssueController extends Controller
{
    //
    protected $lib;

    public function __construct(LibraryIssueRepositoryInterface $lib)
    {

        $this->middleware('auth:school_api');

        $this->lib = $lib;

    }

    public function index($id = null)
    {
            
        $lib = $this->lib->find($id);

        $lib->delete();

        return response()->json([
            'data' => [
                'message' => 'Book Issue Record Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
