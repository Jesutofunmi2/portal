<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LibraryResource;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewBookController extends Controller
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
     LibraryRepositoryInterface $lib) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->lib = $lib;
    }

    /**
    * Retrieve all Library Books in a School
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
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where(function ($q) use ($query) { 
                $q->where('title', 'like', '%'.$query.'%')
                ->orWhere('author', 'like', '%'.$query.'%')
                ->orWhere('subject', 'like', '%'.$query.'%')
                ->orWhere('isbn', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('title', 'asc')
        ->paginate(20)
        ->appends($request->query());

        return LibraryResource::collection($books);
    }

    /**
    * Retrieve all Library Books in a School without pagination
    *
    * @return Resource 
    */
     public function getAll() {

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->lib->setData()->query();

        $books = $query
        ->where('school_id', $school_id)
        ->orderBy('title', 'asc')
        ->get();

        return LibraryResource::collection($books);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}