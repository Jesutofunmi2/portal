<?php

namespace App\Http\Controllers\Ministry\Task;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryTaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Auth;
use Gate;

class TaskController extends Controller
{
    public $task;

    public function __construct(TaskRepositoryInterface $task) {
        $this->task = $task;

        $this->middleware('auth:ministry_api');
    }

    public function create(Request $request): JsonResponse
    {
        if ($this->permissionDeny('create-task')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, $this->task->setData()::$rules);
        
        $ministry_admin_id = Auth::guard('ministry_api')->id();

        $task = $this->task->setData()->create([
            'title' => $request->title,
            'department_id' => $request->department_id,
            'descrip' => $request->descrip,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'task_status' => 1,
            'approval' => 1,
            'posted_by' => $ministry_admin_id,
        ]);
        
        return response()->json([
            'data' => [
                'message' => 'Task created successfully'
            ]
        ]);
        
    }

    public function  view(Request $request, $task = null)
    {
        if ($this->permissionDeny('view-task')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $task = $this->task->find($task);;

       return new MinistryTaskResource($task);
    }

    public function get(Request $request)
    {
        if ($this->permissionDeny('view-task')){
            return response()->json([
            'message' => 'Permission Denied'
            ],403);
        }

        $task = $this->task->setdata()->orderBy('id','desc')->paginate(40);

        return MinistryTaskResource::collection($task);
    }

    public function update(Request $request, $task = null): JsonResponse
    {
        if ($this->permissionDeny('edit-task')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, $this->task->setData()::$rules);
        
        $this->task->find($task)->update($request->all());

        return response()->json([
            'data' => [
                'message' => 'Task Updated successfully'
            ]
        ]);
        
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
