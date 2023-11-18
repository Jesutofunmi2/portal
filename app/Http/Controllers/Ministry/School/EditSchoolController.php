<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Http\Resources\MinistrySchoolResource;
use App\Http\Helper\ImageUploader;
use Illuminate\Support\Facades\File;

class EditSchoolController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;

    }


    public function index(Request $request,$schoolID)
    {
       
        if($this->permissionDeny('edit-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $schools = $this->school->setSchool()->where('id',$schoolID)->get();
        
        return MinistrySchoolResource::collection($schools);

    }

    public function update(Request $request)
    {
        if($this->permissionDeny('edit-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $setSchool = $this->school->find($request->input('id'));

        if ($request->hasFile('logo'))
        {
            $this->validate($request, $setSchool::$rules);

            $url = ImageUploader::saveImage($request,'images/school_logos');
            
            if(File::exists(public_path().$request->input('pre_logo'))){
                File::delete(public_path().$request->input('pre_logo'));
            }

            $root = $_SERVER["DOCUMENT_ROOT"].'/eportal/public';

            if(File::exists($root.$request->input('pre_logo'))){
                File::delete($root.$request->input('pre_logo'));
            }
        }
        else {
            $this->validate($request, $setSchool::$updateRules);
            $url = $request->input('pre_logo');
        }

        
        $school = $setSchool->update([
            'name' => $request->input('school'),
            'lga_id' => $request->input('lga_id'),
            'school_category' => $request->input('school_category'),
            'address' => $request->input('address'),
            'logo' => $url
        ]);

        return response()->json([
            'data' => [
                'message' => 'School updated successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
