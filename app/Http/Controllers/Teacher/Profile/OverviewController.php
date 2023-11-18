<?php

namespace App\Http\Controllers\Teacher\Profile;

use App\Http\Controllers\Controller;
use App\Models\AttendanceAnalytic;
use App\Models\SpecializationSubject;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class OverviewController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;

    }

    public function index()
    {
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();
        $overview = AttendanceAnalytic::where('teacher_id', $teach_id)->first();
        $specialization = SpecializationSubject::all(['subject_name']);

        return response()->json([
            'overview' => $overview,
            'specialization' => $specialization,
        ]);

    }

    public function update(Request $request)
    {
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();

        $setTeacher = $this->teach->find($teach_id);
        if($setTeacher) {

            $rules = [
                'teacher_type' => 'required|string',
                'teacher_description' => 'required|string',
                'teacher_date_of_birth' => 'required|date',
                'teacher_date_of_service' => 'required|date',
                'teacher_highest_qualification' => 'required|string',
                'teacher_subject_specialization_major' => 'required|string',
                'teacher_subject_specialization_minor' => 'required|string',
            ];
    
            $this->validate($request, $rules);

            $current_timestamp = Carbon::parse(Carbon::now());
            
            AttendanceAnalytic::updateOrCreate(['teacher_id' => $teach_id], [
                'teacher_type' => $request->teacher_type,
                'teacher_description' => $request->teacher_description,
                'teacher_date_of_birth' => $request->teacher_date_of_birth,
                'teacher_date_of_service' => $request->teacher_date_of_service,
                'teacher_highest_qualification' => $request->teacher_highest_qualification,
                'teacher_subject_specialization_major' => $request->teacher_subject_specialization_major,
                'teacher_subject_specialization_minor' => $request->teacher_subject_specialization_minor,
                'last_seen'=> $current_timestamp
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Overview updated successfully'
                ]
            ]);
        }

    }
}