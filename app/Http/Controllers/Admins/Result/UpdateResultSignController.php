<?php

namespace App\Http\Controllers\Admins\Result;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Auth;
use Gate;

class UpdateResultSignController extends Controller
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
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $school = $this->school->setSchool()
        ->select('id', 'principal_sign', 'next_session_date', 'principal_name')
        ->where('id', $school_id)
        ->first();

        return response()->json([
            'data' => $school,
        ]);

    }

    public function update(Request $request)
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

            $messages = [
                'next_session_date.date_format' => 'The Next Session Resumption Date does not match the format YYYY-mm-dd',
            ];

            $rules = [
                'principal_name' => 'required',
                'next_session_date' => 'required|date_format:Y-m-d',
            ];

            if ($request->hasFile('principal_sign')) {
                $rules['principal_sign'] = 'image|max:1024';
            }

            $request->validate($rules, $messages);

            $details = [
                'principal_name' => $request->input('principal_name'),
                'next_session_date' => $request->input('next_session_date'),
            ];

            if ($request->hasFile('principal_sign')) {
                $extension = $request->file('principal_sign')->extension();
                $file_name = 'images/signatures/principal_'.$school_id.'_'.bin2hex(random_bytes(16)).'.'.$extension;
                $manager = new ImageManager(array('driver' => 'gd'));
                $image = $manager->make($_FILES['principal_sign']['tmp_name']);
                // Resizing the images
                $image->resize(200,200)->encode(null,75);
                // Storing the images...
                $path = \Storage::put($file_name, (string) $image );
                // Getting the URL....
                $url =  '/'.$file_name;
                $details['principal_sign'] = $url;
            }

            $setSchool->update($details);

            return response()->json([
                'data' => [
                    'message' => 'Result Signatures updated successfully'
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