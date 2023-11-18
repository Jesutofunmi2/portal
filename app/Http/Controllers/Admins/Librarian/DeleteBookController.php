<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use Auth;
use Gate;

class DeleteBookController extends Controller
{
    //
    protected $lib;

    public function __construct(LibraryRepositoryInterface $lib)
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
                'message' => 'Book Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
