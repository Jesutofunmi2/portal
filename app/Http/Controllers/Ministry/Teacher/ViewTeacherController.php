<?php

namespace App\Http\Controllers\Ministry\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Http\Resources\MinistryViewTeacherResource;
use Auth;
use Gate;


class ViewTeacherController extends Controller
{
    protected $teachers;

    public function __construct(TeacherRepositoryInterface $teachers) 
    {
        $this->teachers = $teachers;

        $this->middleware('auth:ministry_api');
    }

    public function index(Request $request)
    {
        if($this->permissionDeny('view-teacher')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request,[
            'school_id' => 'sometimes|integer',
        ]);

        $teachers = $this->teachers->setTeacher()->query()
            ->when($request->school_id,function($query,$id){
                return $query->where('school_id',$id);
            })
            ->orderBy('id','desc')->paginate(40);

        return MinistryViewTeacherResource::collection($teachers);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
