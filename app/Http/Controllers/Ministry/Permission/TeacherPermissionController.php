<?php

namespace App\Http\Controllers\Ministry\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Http\Resources\MinistryViewTeacherResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class TeacherPermissionController extends Controller
{
    protected $teachers;

    protected $permission;

    public function __construct(TeacherRepositoryInterface $teachers,
                                PermissionRepositoryInterface $permission
        ) {

        $this->teachers = $teachers;

        $this->permission = $permission;

        $this->middleware('auth:ministry_api');
    }


    public function getTeachers(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
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
   
    
    protected function validateTopMinistryUser(): Bool
    {
        $ministry_admin_id = Auth::guard('ministry_api')->id();

        if($ministry_admin_id != 2){
            return false;
        }
        return true;
    }
}
