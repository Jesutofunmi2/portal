<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class CreateLibraryCategoryController extends Controller
{
    //
    protected $library;
    //
    protected $admin;

    public function __construct(LibraryCategoryRepositoryInterface $library, AdminRepositoryInterface $admin) {
        $this->middleware('auth:school_api');
        $this->library = $library;
        $this->admin = $admin;
    }

    /**
    * Add Library Category
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        
        $setLib = $this->library->setData();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $messages = [
                'name.required' => 'A Category name is required.',
                'name.unique' => 'This Category already exists.',
        ];
        
        $rules = [
                'name' => [ 'required', Rule::unique('library_category')->where(function ($query) use ($school_id) {
                    return $query->where('school_id', $school_id);
                })
            ]
        ];

        $this->validate($request, $rules, $messages);
        
        $lib = $setLib->create([
            'name' => $request->input('name'),
            'school_id' => $school_id,
        ]);

        return response()->json([
            'data' => [
                'message' => "Library Category created successfully"
            ]
        ]);
    }

    /**
    * Check for avility to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
