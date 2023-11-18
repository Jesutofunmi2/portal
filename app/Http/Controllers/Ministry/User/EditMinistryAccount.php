<?php

namespace App\Http\Controllers\Ministry\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryAdminResource;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EditMinistryAccount extends Controller
{
    protected $superadmin;

    public function __construct(SuperAdminRepositoryInterface $superadmin) {

        $this->superadmin = $superadmin;

        $this->middleware('auth:ministry_api');
    }

    public function index(Request $request)
    {
        $admins = $this->superadmin->setSuperAdmin();

        if( $request->isMethod('post')){
            
            if($request->has('id')) {
                $user_id = $request->id;
                $admin = $admins->find($user_id);
            }
            else {
                $admin = $admins->find( Auth::guard('ministry_api')->id());
            }
            $this->validate($request, $this->validationRules($admin->id));

            $admins->find($admin->id)->update($request->all());

            return Response::json([
                'data' => [
                    'message' => 'Profile Updated Successfully'
                ]
            ]);

        }

        if($request->has('admin_id')) {
            $request->validate(['admin_id' => 'required|integer']);

            $user_id = $request->admin_id;
            $admin = $admins->find($user_id);

            return MinistryAdminResource::make($admin);
        }
        else {
            $admin = $admins->find(Auth::guard('ministry_api')->id());
        }

        return Response::json([
            'data' => [
                'admin' => $admin
            ]
        ]);
    }

    public function aeozeoList(Request $request) {
        $users = $this->superadmin->setSuperAdmin()->where('is_aeozeo', true)->paginate(30);

        return MinistryAdminResource::collection($users);
    }

    public function casAdminList(Request $request) {
        $users = $this->superadmin->setSuperAdmin()->where('is_cas_admin', true)->paginate(30);

        return MinistryAdminResource::collection($users);
    }

    protected function validationRules($user_id): array
    {
        return [
            'id' => 'sometimes|integer',
            'fullname' => 'required|min:6',
            'username' => 'required|min:4|unique:super_admins,username,'.$user_id,
            'email' => 'required|email|unique:super_admins,email,'.$user_id,
            'phone' => 'required|min:4|unique:super_admins,phone,'.$user_id.'|regex:(234?)',
            'lgas' => 'sometimes|array|min:1'
        ];
    }
}
