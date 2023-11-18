<?php

namespace App\Http\Controllers\Ministry\ActivityLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryActivityResource;
use App\Models\ActivityLog;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolLogController extends Controller
{
    public $admin;
    public function __construct(AdminRepositoryInterface $admin ) {
        $this->admin = $admin;

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

        $logs = ActivityLog::select('activity_logs.*', 'admins.fullname', 'schools.logo')
                    ->where('admin_id', '!=', 0)->where('admin_id', '!=', null)
                    ->join('admins', 'activity_logs.admin_id', 'admins.id')
                    ->join('schools', 'activity_logs.school_id', 'schools.id')
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

        $user = $this->admin->setAdmin()->findOrFail($id);

        $logs = ActivityLog::select('activity_logs.*', 'admins.fullname', 'schools.logo')
                    ->where('admin_id', $id)
                    ->join('admins', 'activity_logs.admin_id', 'admins.id')
                    ->join('schools', 'activity_logs.school_id', 'schools.id')
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
