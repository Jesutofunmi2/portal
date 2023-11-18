<?php

namespace App\Http\Controllers\Admins\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Resources\SchoolAdminResource;
use Auth;
use Gate;

class ViewAdminController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index(Request $request)
    {
        
        if($this->permissionDeny('view-school-admin')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        //Get the Logged in school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->admin->setAdmin()->query()
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('fullname', 'like', '%'.$query.'%')
                ->orWhere('username', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('username','asc')
        ->orderBy('fullname','asc')
        ->orderBy('email','asc')
        ->paginate(20)
        ->appends($request->query());

        return SchoolAdminResource::collection($query);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
