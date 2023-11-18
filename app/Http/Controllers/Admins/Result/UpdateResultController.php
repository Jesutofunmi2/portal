<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use App\Models\StudentResult;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UpdateResultController extends Controller
{
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin) {

        $this->middleware('auth:school_api');

        $this->admin = $admin;
    }

    /**
    * Update Result
    *
    * @param Request $request
    * @return json
    */
    public function index(Request $request)
    {
        if($this->permissionDeny('edit-student-result')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $rules = [
            'result_id' => 'required|integer',
            'value' => 'required|integer',
            'score_type' => 'required|string|in:ca_score,ca2_score,exam_score',
        ];

        $this->validate($request, $rules);

        $id = $request->input('result_id');
        $type = $request->input('score_type');
        $value = $request->input('value');

        $result = StudentResult::find($id);

        $result->$type = $value;
        $result->save();
        
        $weighted_average = $result->ca_score + $result->ca2_score + $result->exam_score;

        $class_catg = DB::table('subjects')
        ->where('id', $result->subject_id)
        ->value('class_category');

        $school_id = Auth::guard('school_api')->user()->school_id;

        $grade = DB::table('grade_config')
            ->where('class_type', $class_catg)
            ->where('score_to', '>=', $weighted_average)
            ->where('score_from', '<=', $weighted_average)
            ->first(); 

        $result->weighted_average = $weighted_average;
        $result->grade = $grade->grade;
        $result->remarks = $grade->remark;
        $result->save();

        if ($result) {
            return response()->json([
                'data' => [
                    'message' => 'Result updated successfully'
                ]
            ]);
        }
    }

    /**
    * Check for avility to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}