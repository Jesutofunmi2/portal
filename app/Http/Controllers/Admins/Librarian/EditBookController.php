<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Http\Resources\LibraryResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class EditBookController extends Controller
{
    //
    protected $lib;

    protected $admin;

    public function __construct(LibraryRepositoryInterface $lib, AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->lib = $lib;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        
        $lib = $this->lib->find($id);

        return new LibraryResource($lib);

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

            $lib = $setLib->update([
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
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Book updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
