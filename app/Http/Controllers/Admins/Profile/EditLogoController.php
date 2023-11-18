<?php

namespace App\Http\Controllers\Admins\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Auth;
use Gate;

class EditLogoController extends Controller
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
        
        $logo = $this->school->setSchool()
        ->where('id', $school_id)
        ->value('logo');

        return response()->json([
            'data' => $logo,
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

            $rule = [
                'logo' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            ];

            $request->validate($rule);

            if ($request->hasFile('logo')) {
                $extension = $request->file('logo')->extension();
                $file_name = 'images/school_logos/'.bin2hex(random_bytes(16)).'-'.$school_name.'.'.$extension;
                $manager = new ImageManager(array('driver' => 'gd'));
                $image = $manager->make($_FILES['logo']['tmp_name']);
                // Resizing the images
                $image->resize(200,200)->encode(null,75);
                // Storing the images...
                $path = \Storage::put($file_name, (string) $image );
                // Getting the URL....
                $url =  '/'.$file_name;
                $details['logo'] = $url;
            }

            $setSchool->update($details);

            return response()->json([
                'data' => [
                    'message' => 'School Logo updated successfully'
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