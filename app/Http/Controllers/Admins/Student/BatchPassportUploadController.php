<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Auth;
use Gate;

class BatchPassportUploadController extends Controller
{
    //
    protected $admin;

    protected $student;

    public function __construct(StudentRepositoryInterface $student, AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->student = $student;

    }

    public function index(Request $request)
    {
        
        if($this->permissionDeny('edit-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $messages = [
            'passport.required' => 'You must upload at least one passport image',
            'passport.*.image' => 'The uploaded passport must be an image',
        ];

        $rules = [
            'passport' => 'required',
            'passport.*' => 'image',
        ];

        $request->validate($rules, $messages);

        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;
        //Get School Name
        $school = DB::table('schools_new')->where('id', $school_id)->first();
        $school_name = $school->name;
        $school_lga_id = $school->lga_id;

        $ext = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];

        if ($request->hasFile('passport')) {

            $count = 0;
            $issues = [];

            foreach ($request->file('passport') as $passport) {
                $mime = $_FILES['passport']['type'][$count];
                $extension = $ext[$mime];
                $file_name = 'images/passports/students/'.$school_name.'/'.bin2hex(random_bytes(16)).'.'.$extension;
                $manager = new ImageManager(array('driver' => 'gd'));
                $image = $manager->make($_FILES['passport']['tmp_name'][$count]);
                // Resizing the images
                $image->resize(200,200)->encode(null,75);
                // Storing the images...
                $path = \Storage::put($file_name, (string) $image );
                // Getting the URL....
                $url =  '/'.$file_name;
                
                $name_ext = explode('.', $_FILES['passport']['name'][$count]);
                $regnum = $name_ext[0];
                
                if (is_numeric($regnum)) {
                    $student = $this->student->setStudent()
                    ->where('regnum', $regnum)
                    ->first();
                } else {
                    $student = '';
                }                

                if ($student) {
                    $student->passport = $url;
                    $student->save();
                } else {
                    $issues[] = 'Student with regnum-'.$regnum.' was not found';
                }
                
                $count++;
            }

            return response()->json([
                'data' => [
                    'message' => 'Passports uploaded successfully',
                    'issues' => $issues,
                ]
            ]);

        } else {
            return response()->json([
                'data' => [
                    'message' => 'Passports not uploaded'
                ]
            ]);
        }
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
