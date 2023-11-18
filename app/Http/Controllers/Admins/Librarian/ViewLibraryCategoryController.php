<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LibraryCategoryResource;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewLibraryCategoryController extends Controller
{
    /**
    * Library Category Repository class
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
     LibraryCategoryRepositoryInterface $lib) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->lib = $lib;
    }

    /**
    * Retrieve all Library Categories in a School
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

        $categories = $query
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where('name', 'like', '%'.$query.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate(20)
        ->appends($request->query());

        return LibraryCategoryResource::collection($categories);
    }

    /**
    * Retrieve all Library Categories in a School without pagination
    *
    * @param Request $request
    * @return Resource 
    */
    public function getAll(Request $request) {

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->lib->setData()->query();

        $categories = $query
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where('name', 'like', '%'.$query.'%');
        })
        ->orderBy('name', 'asc')
        ->get();

        return LibraryCategoryResource::collection($categories);
    }

    protected function permissionDeny($ability) {
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}