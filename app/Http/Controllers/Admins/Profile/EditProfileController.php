<?php

namespace App\Http\Controllers\Admins\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class EditProfileController extends Controller
{
    //
    protected $admin;
    protected $school;

    public function __construct(AdminRepositoryInterface $admin, SchoolRepositoryInterface $school)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->school = $school;

    }

    public function index()
    {
        
        if($this->permissionDeny('edit-user')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        
        $admin = $this->admin->setAdmin()
        ->find($admin_id);

        return response()->json([
            'data' => $admin,
        ]);

    }

    public function editSchool()
    {

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $school = $this->school->setSchool()
        ->find($school_id);

        return response()->json([
            'data' => $school,
        ]);

    }

    public function update(Request $request)
    {
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();

        $setAdmin = $this->admin->find($admin_id);
        if($setAdmin) {

            $rules = [
                'email' => 'required|email|unique:admins,email,'.$admin_id,
                'phone' => 'required|regex:(234?)|digits:13|unique:admins,phone,'.$admin_id,
            ];

            $this->validate($request, $rules);
    
            $setAdmin->update([
                    'fullname' => $request->input('fullname'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone')
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Profile updated successfully'
                ]
            ]);
        }

    }

    public function updateSchool(Request $request)
    {
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        //Get School Name
        $school_name = $this->school->setSchool()->query()
        ->where('id', $school_id)
        ->value('name');

        $setSchool = $this->school->find($school_id);
        if($setSchool) {

            $rules = [
                'name' => 'required|min:5',
                'lga_id' => 'required|integer',
                'school_category' => ['required','regex:/(unity|non_unity)/'],
                'address' => 'required|min:10',
            ];

            $request->validate($rules);
    
            $details = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'principal_name' => $request->input('principal_name'),
                'counsellor_name' => $request->input('counsellor_name'),
                'school_category' => $request->input('school_category'),
                'lga_id' => $request->input('lga_id'),
            ];

            $setSchool->update($details);

            return response()->json([
                'data' => [
                    'message' => 'School Profile '.$request->input('logo').' updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability) 
    {
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}