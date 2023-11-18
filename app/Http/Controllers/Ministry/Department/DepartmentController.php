<?php

namespace App\Http\Controllers\Ministry\Department;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryDepartmentResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\Interfaces\MinistryDepartmentRepositoryInterface;
use Auth;
use Gate;

class DepartmentController extends Controller
{
    public $ministryDepartment;

    public function __construct(MinistryDepartmentRepositoryInterface $ministryDepartment) {
        $this->ministryDepartment = $ministryDepartment;

        $this->middleware('auth:ministry_api');
    }

    public function create(Request $request)
    {
        if($this->permissionDeny('create-ministry-department')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, $this->ministryDepartment->setData()::$rules);
        
        $department = $this->ministryDepartment->setData()->create($request->all());
        
        return new MinistryDepartmentResource($department);
        
    }

    public function get(Request $request)
    {
        if($this->permissionDeny('view-ministry-department')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

       $departments = $this->ministryDepartment->setdata()->orderBy('id','desc')->paginate(40);

       return MinistryDepartmentResource::collection($departments);
    }

    public function getAll(Request $request)
    {
        if($this->permissionDeny('view-ministry-department')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
       $departments = $this->ministryDepartment->setdata()->orderBy('id','desc')->get();

       return MinistryDepartmentResource::collection($departments);
    }

    public function update(Request $request, $department = null): JsonResponse
    {
        if($this->permissionDeny('edit-ministry-department')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'name' => 'required|string|unique:ministry_department,name,'.$department,
        ]);
        
        $department = $this->ministryDepartment->find($department)->update($request->all());

        return response()->json([
            'data' => [
                'message' => 'Department Updated successfully'
            ]
        ]);
        
    }

    public function delete(TaskRepositoryInterface $task, $department = null): JsonResponse
    {
        if($this->permissionDeny('delete-ministry-department')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $task = $task->setData();

        if($task->where('department_id',$department)->exists()){
            abort(400, 'Request aborted! Selected Department has at least one Ministry Account anchored to it');
        }

        $department = $this->ministryDepartment->find($department)->delete();
        
        return response()->json([
            'data' => [
                'message' => 'Department deleted successfully'
            ]
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
