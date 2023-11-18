<?php

namespace App\Http\Controllers\Teacher\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class UpdateSignatureController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teacher = $teacher;

    }

    public function index()
    {
        //Get the school teacher id
        $teacher_id = Auth::guard('teacher_api')->id();
        $signature = $this->teacher->find($teacher_id)->signature;

        return response()->json([
            'data' => $signature,
        ]);

    }

    public function update(Request $request)
    {
        
        //Get the teacher id
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $teacher = $this->teacher->find($teacher_id);
        
        if($teacher) {

            $rules = [
                'image_uri' => 'required',
            ];
            $request->validate($rules);

            if( ! preg_match('/data:image/', $request->input('image_uri')))
            { 
                abort(422, "Incorrect signature file");
            }

            if (file_exists(public_path($teacher->signature))) {
                @unlink(public_path($teacher->signature));
            }

            $src = $request->input('image_uri');
            // get the mimetype
            preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
            $mimetype = $groups['mime'];

            // Generating a random filename
            $filename = uniqid();
            $filepath = "/images/signatures/$filename-".$teacher->surname.".$mimetype";
            $root = $_SERVER["DOCUMENT_ROOT"].'/public';
            // @see http://image.intervention.io/api/
            $image = Image::make($src)
              // resize if required
              ->resize(300, null, function($constraint)
                {
                    $constraint->aspectRatio();

                })
              ->encode($mimetype, 100)  // encode file to the specified mimetype
              ->save($root.$filepath);

              $teacher->signature = $filepath;

              $teacher->save();

            return response()->json([
                'data' => [
                    'message' => 'Teacher Signature updated successfully',
                    'signature' => $filepath
                ]
            ]);
        }

    }

    protected function permissionDeny($ability)
    {
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}