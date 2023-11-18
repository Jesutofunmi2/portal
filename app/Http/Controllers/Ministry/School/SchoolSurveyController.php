<?php

namespace App\Http\Controllers\Ministry\School;

use App\Exports\Survey\SurveyExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolSurveyResource;
use App\Models\NgStatesLGA;
use App\Models\SchoolSurvey;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SchoolSurveyController extends Controller
{
    //
    protected $school;

    public function __construct() {

        $this->middleware('auth:ministry_api');
    }


    public function index(Request $request)
    {
        $this->validate($request,[
            'school_id' => 'required|integer',
            'session' => 'sometimes|string'
        ]);

        $surveys = SchoolSurvey::query()
        ->where('school_id',$request->query('school_id'))
        ->when($request->query('session'), function ($q, $session) { 
            return $q->where('session', $session);})
        ->orderBy('id','desc')->paginate(20);

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
     * approve a survey
     */
    public function approve(Request  $request): SchoolSurveyResource
    {
        $request->validate([
            'survey' => 'required|integer'
        ]);

        $survey = $this->getSurvey($request->survey);

        abort_if($survey->approve_status, 400, 'Survey already approved');
        abort_if(is_null($survey->identities), 400, 'Survey identities stage record not found');
        abort_if(is_null($survey->characteristic), 400, 'Survey characteristic stage record not found');
        abort_if(is_null($survey->enrollments), 400, 'Survey enrollments stage record not found');
        abort_if(is_null($survey->staffs), 400, 'Survey staffs stage record not found');
        abort_if(is_null($survey->class_rooms), 400, 'Survey class rooms stage record not found');
        abort_if(is_null($survey->facilities), 400, 'Survey facilities stage record not found');
        abort_if(is_null($survey->books), 400, 'Survey books stage record not found');
        abort_if(is_null($survey->undertaking), 400, 'Survey undertaking stage record not found');
        abort_if(is_null($survey->checked_by), 400, 'Survey checked record not found');
        
        $survey->approve_status = true;
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
        $survey = SchoolSurvey::where(['id' => $survey_id])->first();
        
        abort_if(is_null($survey), 400, 'Survey not found');

        return $survey;
    }

    protected function print(Request $request)
    {
        $request->validate([
            'survey' => 'required|integer'
        ]);

        $survey = SchoolSurvey::where(['id' => $request->survey])->first();
        
        abort_if(is_null($survey), 400, 'Survey not found');

        view()->share('survey', $survey);
        $pdf = PDF::loadView('survey')->setPaper('a4', 'landscape')->setWarnings(false);

        $filename = 'generatedResults/'.$survey->school_id.'_survey.pdf';
        $pdf->save($filename);

        return response()->json(
            ['url' => env('BASE_PATH').$filename]
        );
    }

    public function export(Request  $request)
    {
        $request->validate([
            'session' => 'required|integer'
        ]);

        $surveys = SchoolSurvey::query()->select('school_surveys.*', 'schools_new.*', 'lgas.name as lga_name')
                    ->where(['session' => $request->session,
                                        // 'submit_status' => True,
                                        // 'approve_status' => True
                    ])
                    ->leftJoin('schools_new', 'schools_new.id', '=', 'school_surveys.school_id')
                    ->leftJoin('lgas', 'lgas.id', '=', 'schools_new.lga_id')
                    ->orderBy('lga_name', 'desc')
                    ->get();

        abort_if($surveys->count() == 0, 400, 'No survey found for this session');
        
        $lgas = NgStatesLGA::where('state_id', 28)->orderBy('name', 'asc')->get();

        $filename = 'surveys/'.$request->session.'_survey_summary.xlsx';

        Excel::store(new SurveyExport($surveys, $lgas, $request->session), $filename);

        return response()->json(
            ['url' => env('BASE_PATH3').$filename]
        );
    }
  
}
