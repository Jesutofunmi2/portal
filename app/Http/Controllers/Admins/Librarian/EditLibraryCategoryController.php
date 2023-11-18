<?php

namespace App\Http\Controllers\Admins\Librarian;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Http\Resources\LibraryCategoryResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class EditLibraryCategoryController extends Controller
{
    //
    protected $lib;

    protected $admin;

    public function __construct(LibraryCategoryRepositoryInterface $lib, AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->lib = $lib;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        
        $lib = $this->lib->find($id);

        return new LibraryCategoryResource($lib);

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

            $lib = $setLib->update([
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Library Category updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
