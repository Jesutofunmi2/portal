<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PDF;

class ViewBroadsheetController extends Controller
{
    //
    protected $admin;

    protected $student;

    protected $school;

    public function __construct(AdminRepositoryInterface $admin, StudentRepositoryInterface $student,
    SchoolRepositoryInterface $school)
    {
        $this->admin = $admin;

        $this->student = $student;

        $this->school = $school;
    }

    public function termSheets(Request $request)
    {
        if($this->permissionDeny('view-result')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
            'term'         => ['required','regex:/(First|Second|Third)/'],
        ]);

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        
        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;

        $school = $this->school->find($school_id);

        $school_name = $school->name;
        $lga = $school->statesLGA->name;
        $state = env('STATE_NAME', 'ONDO');
        $logo = str_replace(' ', '%20', $school->logo);

        $clas = DB::table('classes')
        ->select('classes.class_name as class_name', 'class_arms.class_arm as arm')
        ->join('class_arms', 'classes.id', '=', 'class_arms.class_id')
        ->where('classes.school_id', $school_id)
        ->where('classes.id', $class_id)
        ->where('class_arms.id', $classarm_id)
        ->first();

        $class_name = $clas->class_name.' '.$clas->arm;

        $subjects = DB::table('subjects')
        ->select('subjects.id as id', 'subjects.subject_code as code', 'subjects.class_category as class_type')
        ->join('classarm_subject', 'subjects.id', '=', 'classarm_subject.subject_id')
        ->where('classarm_subject.classarm_id', $classarm_id)
        ->orderBy('subjects.subject_code', 'asc')
        ->groupBy('subjects.id')
        ->get();

        $subject_count = $subjects->count();

        abort_if($subject_count == 0, 400, 'No subject found for this class arm');

        $class_type = $subjects->first()->class_type;

        if ($class_type == 'JSS') {
            $category = 'JUNIOR SECONDARY SCHOOLS'; 
        } elseif ($class_type == 'SSS') {
            $category = 'SENIOR SECONDARY SCHOOLS';
        }
        
        $grades = DB::table('grade_config')
                    ->where('class_type', $class_type)
                    ->get();

        $students = $this->student->setStudent()
        ->select(DB::raw('MAX(students.id) as id'), 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->where('students.school_id', $school_id)
        ->where('classarm_student.classarm_id', $classarm_id)
        ->where('classarm_student.class_id', $class_id)
        ->where('classarm_student.session', $session)
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->groupBy('students.surname', 'students.firstname', 'students.middlename')
        ->get();

        $results[] = [];
        foreach ($students as $stud) {
            $scores = DB::table('student_results')
            ->select('weighted_average', 'subject_id')
            ->where('student_id', $stud->id)
            ->where('class_id', $class_id)
            ->where('classarm_id', $classarm_id)
            ->where('session', $session)
            ->where('term', $term)
            ->where('school_id', $school_id)
            ->get();

            $count = 0;
            $passes = 0;
            $total = 0;
            foreach ($scores as $sco) {
                $results['id_'.$stud->id]['subj_'.$sco->subject_id] = $sco->weighted_average;
                $total += $sco->weighted_average;
                if ($sco->weighted_average > 50) {
                    $passes++;
                }
                $count++;
            }
            if ($count > 0) {
                $results['id_'.$stud->id]['avg'] = (int)round($total/$count);
                foreach ($grades as $grade) {
                    if ($results['id_'.$stud->id]['avg'] >= $grade->score_from && $results['id_'.$stud->id]['avg'] <= $grade->score_to) {
                        $results['id_'.$stud->id]['grade'] = $grade->grade;
                        break;
                    }
                    else {
                        $results['id_'.$stud->id]['grade'] = 'N/A';
                    }
                }
                $results['id_'.$stud->id]['passes'] = $passes;
            } else {
                $results['id_'.$stud->id]['avg'] = 0;
                $results['id_'.$stud->id]['passes'] = 0;
                $results['id_'.$stud->id]['grade'] = '';
            }            
        }

        $pdf = PDF::loadView('school.pdf.termbroadsheet', ['students' => $students, 'subjects' => $subjects, 'subject_count' => $subject_count, 'results' => $results, 'term' => $term, 'session' => $session, 'category' => $category, 'lga' => $lga, 'school' => $school_name, 'logo' => $logo, 'class_name' => $class_name, 'state' => $state])
        ->setPaper('a4', 'landscape');

        $filename = 'generatedPdf/'.str_replace(' ', '-', $school_name).'-'.str_replace(' ', '-', $class_name).'-TermBroadsheet.pdf';

        $pdf->save($filename);
        // return $pdf->download($filename);

        return response()->json([
            'url' => env('BASE_PATH').$filename
        ]);
    }

    public function sessionSheets(Request $request)
    {
        if($this->permissionDeny('view-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }
 
        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
        ]);
 
        $session = $request->input('session');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        
        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;

        $school = $this->school->find($school_id);

        $school_name = $school->name;
        $lga = $school->statesLGA->name;
        $state = env('STATE_NAME', 'ONDO');
        $logo = str_replace(' ', '%20', $school->logo);

        $clas = DB::table('classes')
        ->select('classes.class_name as class_name', 'class_arms.class_arm as arm')
        ->join('class_arms', 'classes.id', '=', 'class_arms.class_id')
        ->where('classes.school_id', $school_id)
        ->where('classes.id', $class_id)
        ->where('class_arms.id', $classarm_id)
        ->first();

        $class_name = $clas->class_name.' '.$clas->arm;

        $subjects = DB::table('subjects')
        ->select('subjects.id as id', 'subjects.subject_code as code', 'subjects.class_category as class_type')
        ->join('classarm_subject', 'subjects.id', '=', 'classarm_subject.subject_id')
        ->where('classarm_subject.classarm_id', $classarm_id)
        ->orderBy('subjects.subject_code', 'asc')
        ->groupBy('subjects.id')
        ->get();

        $subject_count = $subjects->count();

        abort_if($subject_count == 0, 400, 'No subject found for this class arm');

        $class_type = $subjects->first()->class_type;
 
        if ($class_type == 'JSS') {
            $category = 'JUNIOR SECONDARY SCHOOLS'; 
        } elseif ($class_type == 'SSS') {
            $category = 'SENIOR SECONDARY SCHOOLS';
        }
        
        $grades = DB::table('grade_config')
                    ->where('class_type', $class_type)
                    ->get();
 
        $students = $this->student->setStudent()
        ->select(DB::raw('MAX(students.id) as id'), 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->where('students.school_id', $school_id)
        ->where('classarm_student.classarm_id', $classarm_id)
        ->where('classarm_student.class_id', $class_id)
        ->where('classarm_student.session', $session)
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->groupBy('students.surname', 'students.firstname', 'students.middlename')
        ->get();

        $results[] = [];
        foreach ($students as $stud) {
            $scores = DB::table('student_results')
            ->select('weighted_average', 'subject_id', 'term')
            ->where('student_id', $stud->id)
            ->where('class_id', $class_id)
            ->where('classarm_id', $classarm_id)
            ->where('session', $session)
            ->where(function ($query) {
                $query->where('term', 'First')
                ->orWhere('term', 'Second')
                ->orWhere('term', 'Third');
            })
            ->where('school_id', $school_id)
            ->orderBy('subject_id', 'asc')
            ->orderBy('term', 'asc')
            ->get();

            $subjIds = $scores->pluck('subject_id');
 
            $count = 0;
            $passes = 0;
            $total = 0;
            foreach ($scores as $sco) {
                if ($sco->term == 'First') {
                    $results['id_'.$stud->id]['subj_1_'.$sco->subject_id] = $sco->weighted_average;
                } elseif ($sco->term == 'Second') {
                    $results['id_'.$stud->id]['subj_2_'.$sco->subject_id] = $sco->weighted_average;
                } elseif ($sco->term == 'Third') {
                    $results['id_'.$stud->id]['subj_3_'.$sco->subject_id] = $sco->weighted_average;
                }              
            }

            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $v1 = 0;
            $v2 = 0;
            $v3 = 0;
            $count = 0;
            $passes = 0;
            $total = 0;
            foreach ($subjIds as $subj) {
                if (isset($results['id_'.$stud->id]['subj_1_'.$subj])) {
                    $t1 = 1;
                    $v1 = $results['id_'.$stud->id]['subj_1_'.$subj];
                } 
                if (isset($results['id_'.$stud->id]['subj_2_'.$subj])) {
                    $t2 = 1;
                    $v2 = $results['id_'.$stud->id]['subj_2_'.$subj];
                } 
                if (isset($results['id_'.$stud->id]['subj_3_'.$subj])) {
                    $t3 = 1;
                    $v3 = $results['id_'.$stud->id]['subj_3_'.$subj];
                }

                if ($t1 == 0 && $t2 == 0 && $t3 == 0) {
                    continue; 
                } else {
                    $results['id_'.$stud->id]['subj_'.$subj] = (int)round(($v1 * $t1 + $v2 * $t2 + $v3 * $t3) / ($t1 + $t2 + $t3));
                }            

                $total += $results['id_'.$stud->id]['subj_'.$subj];
                if ($results['id_'.$stud->id]['subj_'.$subj] > 50) {
                    $passes++;
                }
                $count++;

                $t1 = 0;
                $t2 = 0;
                $t3 = 0;
            }

            if ($count > 0) {
                $results['id_'.$stud->id]['avg'] = (int)round($total/$count);
                foreach ($grades as $grade) {
                    if ($results['id_'.$stud->id]['avg'] >= $grade->score_from && $results['id_'.$stud->id]['avg'] <= $grade->score_to) {
                        $results['id_'.$stud->id]['grade'] = $grade->grade;
                        break;
                    }
                    else {
                        $results['id_'.$stud->id]['grade'] = 'N/A';
                    }
                }
                $results['id_'.$stud->id]['passes'] = $passes;
            } else {
                $results['id_'.$stud->id]['avg'] = 0;
                $results['id_'.$stud->id]['passes'] = 0;
                $results['id_'.$stud->id]['grade'] = '';
            }            
        }
 
        $pdf = PDF::loadView('school.pdf.sessionbroadsheet', ['students' => $students, 'subjects' => $subjects, 'subject_count' => $subject_count, 'results' => $results, 'session' => $session, 'category' => $category, 'lga' => $lga, 'school' => $school_name, 'logo' => $logo, 'class_name' => $class_name, 'state' => $state])
        ->setPaper('a4', 'landscape');

        $filename = 'generatedPdf/'.str_replace(' ', '-', $school_name).'-'.str_replace(' ', '-', $class_name).'-TermBroadsheet.pdf';

        $pdf->save($filename);
        // return $pdf->download($filename);

        return response()->json([
            'url' => env('BASE_PATH').$filename
        ]);
    }

    public function summary(Request $request)
    {
        $this->validate($request, [
            'class_id'     => 'required|int',
            'classarm_id'  => 'required|int',
            'session'      => 'required|int',
            'status'      => 'required|int',
            'school_id'      => 'sometimes|int',
        ]);
 
        $session = $request->input('session');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        $term = 'Third';
        $status = $request->input('status');
        
        if ($request->has('school_id')) {
            $school_id = $request->input('school_id');
        }
        else {
             //Get the school admin id
            $admin = Auth::guard('school_api')->user();
            //Get the school_id
            $school_id = $admin->school_id;
        }

        $student_results_count = DB::table('student_results')
                            ->where('session', $session)
                            ->where('class_id', $class_id)
                            ->where('classarm_id', $classarm_id)
                            ->where('term', $term)
                            ->where('school_id', $school_id)
                            ->groupBy('student_id')
                            ->count();

        abort_if($student_results_count == 0, 400, 'No third term result found for this classarm');

        $school = $this->school->find($school_id);

        $school_name = $school->name;
        $lga = $school->statesLGA->name;
        $state = env('STATE_NAME', 'ONDO');
        $logo = str_replace(' ', '%20', $school->logo);

        $clas = DB::table('classes')
                ->select('classes.class_name as class_name', 'class_arms.class_arm as arm')
                ->join('class_arms', 'classes.id', '=', 'class_arms.class_id')
                ->where('classes.school_id', $school_id)
                ->where('classes.id', $class_id)
                ->where('class_arms.id', $classarm_id)
                ->first();

        $class_name = $clas->class_name.' '.$clas->arm;

        $studIDs = DB::table('classarm_student')
                        ->where('classarm_id', $classarm_id)
                        ->where('class_id', $class_id)
                        ->where('session', $session)
                        ->where('term', $term)
                        ->pluck('student_id');
        
        $data = $this->student->setStudent()->query()
                    ->with(['studentResults' => function ($query) use($classarm_id, $term, $school_id, $class_id, $session) {
                        $query->where('class_id', $class_id)
                        ->where('classarm_id', $classarm_id)
                        ->where('session', $session)
                        ->where('term', $term)
                        ->where('school_id', $school_id)
                        ->groupBy('student_id');
                    }])
                    ->select(DB::raw('MAX(id) as id'), 'surname', 'firstname', 'middlename', 'regnum', 'gender')
                    ->whereIn('id', $studIDs)
                    ->where('school_id', $school_id)
                    ->orderBy('surname','asc')
                    ->orderBy('firstname','asc')
                    ->orderBy('middlename','asc')
                    ->groupBy('surname', 'firstname', 'middlename')
                    ->get();

        $students = [];
        $total_students = count($data);
        $promoted_count = 0;
        $promoted_on_trial_count = 0;
        $to_repeat_count = 0;
        $withdraw_count = 0;
        $no_result_count = 0;
        $no_stamp_count = 0;
        
        $data->map(function($student) use (&$students, $status, &$no_stamp_count, &$promoted_count, &$promoted_on_trial_count,
                                        &$to_repeat_count, &$withdraw_count, &$no_result_count)
            {
                if(count($student->studentResults) > 0) {
                    if($student->studentResults[0]->promotion == 1) $no_stamp_count++;
                    if($student->studentResults[0]->promotion == 2) $promoted_count++;
                    if($student->studentResults[0]->promotion == 3) $to_repeat_count++;
                    if($student->studentResults[0]->promotion == 4) $withdraw_count++;
                    if($student->studentResults[0]->promotion == 5) $promoted_on_trial_count++;
                    if($student->studentResults[0]->promotion == $status) $students[] = $student;
                }
                else {
                    $no_result_count++;
                }
            });

        switch ($status) {
            case '2':
                $status_text = 'Promoted';
                break;
            case '3':
                $status_text = 'To Repeat';
                break;
            case '4':
                $status_text = 'Withdraw';
                break;
            case '5':
                $status_text = 'Promoted on trial';
                break;
            default:
                $status_text = 'Not-Available';
                break;
        }

        $pdf = PDF::loadView('school.pdf.result_summary', [
            'students' => $students,
            'total_students' => $total_students,
            'promoted_count' => $promoted_count,
            'to_repeat_count' => $to_repeat_count,
            'withdraw_count' => $withdraw_count,
            'promoted_on_trial_count' => $promoted_on_trial_count,
            'no_result_count' => $no_result_count,
            'no_stamp_count' => $no_stamp_count,
            'session' => $session,
            'lga' => $lga,
            'school' => $school_name,
            'logo' => $logo,
            'class_name' => $class_name,
            'status_text' => $status_text,
            'state' => $state]
            )->setPaper('a4', 'landscape');

        $filename = 'generatedPdf/'.str_replace(' ', '-', $school_name).'-'.str_replace(' ', '-', $class_name).'-ResultSummary.pdf';
        $pdf->save($filename);

        return response()->json([
            'url' => env('BASE_PATH').$filename
        ]);
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}