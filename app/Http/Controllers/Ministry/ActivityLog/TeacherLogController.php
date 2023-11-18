<?php

namespace App\Http\Controllers\Ministry\ActivityLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryActivityResource;
use App\Models\ActivityLog;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TeacherLogController extends Controller
{
    public $teacher;
    public function __construct(TeacherRepositoryInterface $teacher ) {
        $this->teacher = $teacher;

        $this->middleware('auth:ministry_api');
    }

    public function index(Request $request)
    {
        if($this->permissionDeny('view-activity-log')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $request->validate([
            'start_date' => ['date', 'before_or_equal:end_date'],
            'end_date' => ['date', 'after_or_equal:start_date', 'required_if:start_date, !=, null'],
            'school_id' => ['integer'],
        ]);

        $logs = ActivityLog::select('activity_logs.*', 'teachers.title', 'teachers.surname', 'teachers.firstname', 'teachers.middlename', 'teachers.passport')
                    ->where('teacher_id', '!=', 0)->where('teacher_id', '!=', null)
                    ->join('teachers', 'activity_logs.teacher_id', 'teachers.id')
                    ->when($request->start_date, function($query, $date) use ($request) {
                        $query->whereBetween('activity_logs.created_at', [$request->start_date, $request->end_date])->orWhereDate('activity_logs.created_at', $request->start_date);
                    })
                    ->when($request->school_id, function($query, $school_id) {
                        $query->where('activity_logs.school_id', $school_id);
                    })
                    ->orderBy('activity_logs.created_at', 'desc')
                    ->paginate(40);

        return MinistryActivityResource::collection($logs);
    }

    public function getLogs(Request $request, $id)
    {
        if($this->permissionDeny('view-activity-log')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $request->validate([
            'start_date' => ['date', 'before_or_equal:end_date'],
            'end_date' => ['date', 'after_or_equal:start_date', 'required_if:start_date, !=, null']
        ]);

        $user = $this->teacher->setteacher()->findOrFail($id);

        $logs = ActivityLog::select('activity_logs.*', 'teachers.title', 'teachers.surname', 'teachers.firstname', 'teachers.middlename', 'teachers.passport')
                    ->where('teacher_id', $id)
                    ->join('teachers', 'activity_logs.teacher_id', 'teachers.id')
                    ->when($request->start_date, function($query, $date) use ($request) {
                        $query->whereBetween('activity_logs.created_at', [$request->start_date, $request->end_date])->orWhereDate('activity_logs.created_at', $request->start_date);
                    })
                    ->orderBy('activity_logs.created_at', 'desc')
                    ->paginate(40);

        return MinistryActivityResource::collection($logs)->additional([
            'fullname' => $user->fullname
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
