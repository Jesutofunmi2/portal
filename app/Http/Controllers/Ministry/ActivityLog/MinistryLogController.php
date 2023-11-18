<?php

namespace App\Http\Controllers\Ministry\ActivityLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryActivityResource;
use App\Models\ActivityLog;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MinistryLogController extends Controller
{
    //
    public $superadmin;
    public function __construct(SuperAdminRepositoryInterface $superadmin ) {
        $this->superadmin = $superadmin;

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
            'end_date' => ['date', 'after_or_equal:start_date', 'required_if:start_date, !=, null']
        ]);

        $logs = ActivityLog::select('activity_logs.*', 'super_admins.fullname')
                    ->where('super_admin_id', '!=', 0)->where('super_admin_id', '!=', null)
                    ->join('super_admins', 'activity_logs.super_admin_id', 'super_admins.id')
                    ->when($request->start_date, function($query, $date) use ($request) {
                        $query->whereBetween('activity_logs.created_at', [$request->start_date, $request->end_date])->orWhereDate('activity_logs.created_at', $request->start_date);
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

        $user = $this->superadmin->setSuperAdmin()->findOrFail($id);

        $logs = ActivityLog::select('activity_logs.*', 'super_admins.fullname')
                    ->where('super_admin_id', $id)
                    ->join('super_admins', 'activity_logs.super_admin_id', 'super_admins.id')
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
