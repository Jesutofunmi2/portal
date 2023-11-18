<?php

namespace App\Http\Controllers\Ministry\Card;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ResultVoucherRepositoryInterface;
use Auth;
use Gate;
use Response;
use App\Http\Resources\MinistryScratchCardResource;

class ResultScratchCardController extends Controller
{
    protected $student_voucher;

    public function __construct(ResultVoucherRepositoryInterface $student_voucher) {

        $this->student_voucher = $student_voucher;

        $this->middleware('auth:ministry_api');
        
    }

    public function view(Request $request)
    {
        if($this->permissionDeny('view-scratch-card')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'per_page' => 'required|integer',
            'page' => 'required|integer',
            'category' => 'sometimes|string'
        ]);

        $vouchers = $this->student_voucher->setResultVoucher()->query()
        ->when($request->category, function($query, $category){
            if($category == 'used') return $query->where('student_id', '!=', null);
            if($category == 'available') return $query->where('student_id', null);
        })->orderBy('id','desc')->paginate($request->per_page);

        return MinistryScratchCardResource::collection($vouchers);
    }

    public function generate(Request $request)
    {
        if($this->permissionDeny('create-scratch-card')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $voucher = $this->student_voucher->setResultVoucher();

        $this->validate($request, $voucher::$rules);

        $quantity = $request->input('quantity');

        $insert = array();

        for ($i=1; $i <= $quantity; $i++)
        {                 
            list($pin1, $pin2, $pin3, $pin4) = $this->getRandomVoucher($quantity);

            $insert[] = array(
                'pin1' => $pin1,
                'pin2' => $pin2,
                'pin3' => $pin3,
                'pin4' => $pin4,
                'pin' => $pin1 . $pin2 . $pin3 . $pin4,
            'serial' => $this->getSerialNumber()
            );
        }

        $voucher->insert($insert);

        return Response::json([
            'data' => [
                'message' => $quantity.' scratch card generated successfully',
            ]
        ]);

    }

    private function getRandomVoucher($iteration)
     {
         $pin1 = rand(1111,9999);
         $pin2 = rand(1111,9999);
         $pin3 = rand(1111,9999);
         $pin4 = rand(1111,9999);
         
         
         $usedPins = $this->student_voucher->setResultVoucher()->where('pin1', $pin1)
                                ->where('pin2', $pin2)
                                ->where('pin3', $pin3)
                                ->where('pin4', $pin4)->exists();
                                
         if ($usedPins)
         {
             return $this->getRandomVoucher($iteration);
             
         }
         else
         { 
            return array($pin1, $pin2, $pin3, $pin4);
         }
           
     }

     private function getSerialNumber(){
     	$serial = 'SN'.rand(11111111, 99999999);

     	$usedPins = $this->student_voucher->setResultVoucher()
                                ->where('serial', $serial)->exists();
                                
         if ($usedPins)
         {
             return $this->getSerialNumber();
             
         }
         else
         { 
            return $serial;
         }
     }

    public function deleteOne($id = null){
        if($this->permissionDeny('delete-scratch-card')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
        
        if( ! is_numeric($id)){
            return Response::json([
                'data' => [
                    'message' => 'Error Occur',
                ]
            ]);
        }

        $this->student_voucher->find($id)->delete();
        return Response::json([
            'data' => [
                'message' => 'Scratch card deleted successfully',
            ]
        ]);
    }

    public function deleteAll(Request $request){
        if($this->permissionDeny('delete-scratch-card')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, ['ids' => 'required|array']);

       
        $this->student_voucher->setResultVoucher()->whereIn('id',$request->ids)->delete();

        return Response::json([
            'data' => [
                'message' => 'Scratch card deleted successfully',
            ]
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}