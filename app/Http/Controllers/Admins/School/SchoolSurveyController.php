<?php

namespace App\Http\Controllers\Admins\School;

use App\Http\Controllers\Controller;
use App\Http\Helper\ImageUploader;
use App\Http\Resources\MinistrySchoolResource;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\SchoolSurveyResource;
use App\Models\SchoolSurvey;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolSurveyController extends Controller
{
    /**
    * School Repository class
    * @var obj
    */
    protected $school;

    /**
    * Initialise Controller
    */
    public function __construct(SchoolRepositoryInterface $school) {
        $this->middleware('auth:school_api');

        $this->school = $school;
    }

    /**
    *
    * @return Resource 
     */
     public function index(Request $request): AnonymousResourceCollection
     {
        $user = Auth::guard('school_api')->user();
        $school_id = $user->school_id;

        $surveys = SchoolSurvey::where('school_id', $school_id)->paginate(20);

        return SchoolSurveyResource::collection($surveys);
    }

    public function show(Request $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer'
        ]);
        
        $survey = $this->getSurvey($request->survey);

        return new SchoolSurveyResource($survey);
   }

    /**
     * Create a new survey for the school
     */
    public function createSurvey(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'session' => 'required|integer'
        ]);

        $user = Auth::guard('school_api')->user();
        $school_id = $user->school_id;

        $session = $request->session;
        $session_2 = $session + 1;
        $full_session = $session.'/'.$session_2;

        $exist = SchoolSurvey::where(['school_id' => $school_id, 'session' => $session])->exists();

        abort_if($exist, 400, "Survey for $full_session is already created");

        $survey = SchoolSurvey::create([
            'school_id' => $school_id,
            'session' => $session,
        ]);

        return new SchoolSurveyResource($survey);
    }

    /**
     * save identities stage of a survey
     */
    public function identities(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
        ]);

        $survey = $this->getSurvey($request->survey);

        $identities = $request->only(['school_name', 'school_code', 'elevation', 'school_lat', 'school_long',
                                        'phone', 'address', 'lga_id', 'ward', 'town', 'email', 'lga_name']);

        $survey->identities = $identities;
        $survey->stage = 1;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save characteristics stage of a survey
     */
    public function characteristics(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $characteristics = $request->only(["est_year", "location_type", "share_facilities", "education_level", "school_type",
        "school_shift", "multi_grade", "facilities_sharing", "ave_distance", "spd", "student_boarding", "sbmc","pta",
        "last_inspect", "conditional_cash", "receive_grant", "security_gate", "school_owner", "long_distance",
        "inspect_number", "inspect_by"]);

        $survey->characteristic = $characteristics;
        $survey->stage = 2;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save enrollment stage of a survey
     */
    public function enrollment(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'enrollment' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->enrollments = $request->enrollment;
        $survey->stage = 3;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save staffs stage of a survey
     */
    public function staffs(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'staffs' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->staffs = $request->staffs;
        $survey->stage = 4;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save classrooms stage of a survey
     */
    public function classrooms(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'classrooms' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->class_rooms = $request->classrooms;
        $survey->stage = 5;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save facilities stage of a survey
     */
    public function facilities(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'facilities' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->facilities = $request->facilities;
        $survey->stage = 6;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save books stage of a survey
     */
    public function books(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'books' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->books = $request->books;
        $survey->stage = 7;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * save undertaking stage of a survey
     */
    public function undertaking(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer'
        ]);

        $undertaking = $request->only('attestation_head_teacher_name',
                                    'attestation_head_teacher_phone',
                                    'attestation_head_teacher_date',
                                    'attestation_head_teacher_signature',
                                    'attestation_enumerator_name',
                                    'attestation_enumerator_phone',
                                    'attestation_enumerator_date',
                                    'attestation_enumerator_position',
                                    'attestation_enumerator_signature',
                                    'attestation_supervisor_name',
                                    'attestation_supervisor_phone',
                                    'attestation_supervisor_date',
                                    'attestation_supervisor_position',
                                    'attestation_supervisor_signature');
        
        if ($request->hasFile('teacher_signature'))
        {
            $url = ImageUploader::saveSignatures($request, 'teacher_signature', 'images/signatures');
            $undertaking['attestation_head_teacher_signature'] = $url;
        }

        if ($request->hasFile('moderator_signature'))
        {
            $url = ImageUploader::saveSignatures($request, 'moderator_signature', 'images/signatures');
            $undertaking['attestation_enumerator_signature'] = $url;
        }

        if ($request->hasFile('supervisor_signature'))
        {
            $url = ImageUploader::saveSignatures($request, 'supervisor_signature', 'images/signatures');
            $undertaking['attestation_supervisor_signature'] = $url;
        }

        $survey = $this->getSurvey($request->survey);
        
        $survey->undertaking = $undertaking;
        $survey->stage = 8;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }

    /**
     * submit a survey
     */
    public function submit(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer'
        ]);

        $survey = $this->getSurvey($request->survey);

        abort_if($survey->submit_status, 400, 'Survey already submitted');
        
        $survey->submit_status = true;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }
    
    /**
     * save checked stage of a survey
     */
    public function checked(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer',
            'checked' => 'required|array'
        ]);

        $survey = $this->getSurvey($request->survey);
        
        $survey->checked_by = $request->checked;
        $survey->save();

        return new SchoolSurveyResource($survey);
    }
    
    protected function getSurvey($survey_id): SchoolSurvey
    {
        $user = Auth::guard('school_api')->user();
        $school_id = $user->school_id;

        $survey = SchoolSurvey::where(['school_id' => $school_id, 'id' => $survey_id])->first();
        
        abort_if(is_null($survey), 400, 'Survey not found for your school');

        return $survey;
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
