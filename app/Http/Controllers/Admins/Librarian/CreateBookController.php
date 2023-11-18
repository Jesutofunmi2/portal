<?php

namespace App\Http\Controllers\Admins\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class CreateBookController extends Controller
{
    //
    protected $library;
    //
    protected $admin;

    public function __construct(LibraryRepositoryInterface $library, AdminRepositoryInterface $admin) {
        $this->middleware('auth:school_api');
        $this->lib = $library;
        $this->admin = $admin;
    }

    /**
    * Add Library Category
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
            'cat_id.required' => 'A category is required',
        ];
        
        $rules = [
            'cat_id' => 'required|int',
            'title' => 'required|string', 
            'sub_title' => 'nullable|string',
            'author' => 'required|string', 
            'publisher' => 'required|string', 
            'subject' => 'required|string', 
            'descrip' => 'nullable|string', 
            'location' => 'nullable|string', 
            'isbn' => 'nullable|string', 
            'serial_no' => 'nullable|string', 
            'copies' => 'required|int', 
            'available' => 'required|int', 
        ];

        $this->validate($request, $rules, $messages);
        
        $lib = $setLib->create([
            'school_id' => $school_id,
            'cat_id' => $request->input('cat_id'),
            'title' => $request->input('title'), 
            'sub_title' => $request->input('sub_title'),
            'author' => $request->input('author'), 
            'publisher' => $request->input('publisher'), 
            'subject' => $request->input('subject'), 
            'descrip' => $request->input('descrip'), 
            'location' => $request->input('location'), 
            'isbn' => $request->input('isbn'), 
            'serial_no' => $request->input('serial_no'), 
            'copies' => $request->input('copies'), 
            'available' => $request->input('available'), 
            'posted_by' => $admin_id,
        ]);

        return response()->json([
            'data' => [
                'message' => "Book successfully added to the library"
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
