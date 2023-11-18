<?php

namespace App\Http\Controllers\Ministry\Card;

use Auth;
use Gate;
use Response;
use Illuminate\Http\Request;
use App\Models\ExamsVouchers;
use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryExamScratchCardResource;

class ExamScratchCardController extends Controller
{
    protected $student_voucher;

    public function __construct( ) {

        $this->middleware('auth:ministry_api');
        $this->student_voucher = new ExamsVouchers;
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
            'category' => 'sometimes|string',
            'exam_type' => 'sometimes|string'
        ]);

        $vouchers = $this->student_voucher->query()
        ->when($request->category, function($query, $category){
            if($category == 'used') return $query->where('regnum', '!=', null);
            if($category == 'available') return $query->where('regnum', null);
        })
        ->when($request->exam_type, function($query, $exam_type){
            return $query->where('exam_type', $exam_type);
        })
        ->orderBy('id','desc')->paginate($request->per_page);

        return MinistryExamScratchCardResource::collection($vouchers);
    }

    public function generate(Request $request)
    {
        if($this->permissionDeny('create-scratch-card')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $voucher = $this->student_voucher;

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
                'serial' => $this->getSerialNumber(),
                'multiple' => $request->input('multiple'),
                'exam_type' => $request->input('exam_type'),
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
         
         
         $usedPins = $this->student_voucher->where('pin1', $pin1)
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

     	$usedPins = $this->student_voucher
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

       
        $this->student_voucher->whereIn('id',$request->ids)->delete();

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