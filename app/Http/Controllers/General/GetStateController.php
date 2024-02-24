<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryLgaResource;
use App\Repositories\Interfaces\NgStatesLGARepositoryInterface;
use App\Repositories\Interfaces\NgStatesRepositoryInterface;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetStateController extends Controller
{
    //
    protected $ngstate;
    protected $ngstate_lgas;

    public function __construct(
        NgStatesRepositoryInterface $ngstate,
        NgStatesLGARepositoryInterface $ngstate_lgas
    )
    {
        //$this->middleware('auth:ministry_admin');

        $this->ngstate = $ngstate;
        $this->ngstate_lgas = $ngstate_lgas;
    }

    public function getState(Request $request)
    {
        $state = env('STATE_ID');
        //$ngstate =  $this->ngstate->find($state);
        $ngstate =  $this->ngstate->getAll(['id','name']);

        $user = Auth::guard('ministry_api')->user();

        if($user && $user->is_aeozeo) {
            $ngstate_lgas = $this->ngstate_lgas->setNgStatesLGA()->whereIn('id', $user->lgas)->get();
        }
        else {
            $ngstate_lgas = $this->ngstate_lgas->findWithStateId($state);
        }

        return MinistryLgaResource::collection($ngstate_lgas)->additional([
            'state' => $ngstate->name
        ]);
    }

    public function getAll(Request $request)
    {
        $ngstate =  $this->ngstate->getAll(['id','name']);
        
        return response()->json([
            'data' => [
                'states' => $ngstate,
            ]
        ]);
    }
    public function getLga(Request $request)
    {
        $this->validate($request,[
            'state_id' => 'required|integer',
        ]);
        $state_id = $request->state_id;

        $ngstate_lgas = $this->ngstate_lgas->findWithStateId($state_id);

        return MinistryLgaResource::collection($ngstate_lgas);
        
    }

}
