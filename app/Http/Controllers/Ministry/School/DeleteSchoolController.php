<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Http\Resources\SchoolResource;
use App\Http\Helper\ImageUploader;
use Illuminate\Support\Facades\File;

class DeleteSchoolController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;

    }


    public function index($id=null)
    {
        if($this->permissionDeny('delete-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $setSchool = $this->school->find($id);

        if ($setSchool)
        {
            if(File::exists(public_path().$setSchool->logo)){
                File::delete(public_path().$setSchool->logo);
            }
            $this->school->find($id)->delete();

        }

        return response()->json([
            'data' => [
                'message' => 'School Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
