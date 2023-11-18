<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use function Clue\StreamFilter\append;

class DashboardController extends Controller
{
    //
    protected $school;
    protected $admin;
    protected $student;
    protected $ngstate_lgas;
    protected $teachers;
    protected $subjects;

    public function __construct(
        SchoolRepositoryInterface $school,
        AdminRepositoryInterface $admin,
        StudentRepositoryInterface $student,
        TeacherRepositoryInterface $teachers,
        SubjectRepositoryInterface $subjects
        )
    {

        $this->school = $school;
        $this->admin = $admin;
        $this->student = $student;
        $this->teachers = $teachers;
        $this->subjects = $subjects;

        $this->middleware('auth:school_api');
    }

    public function appStat()
    {
        $admin_id = Auth::guard('school_api')->id();

       $admin = $this->admin->setAdmin()->find($admin_id);
       $school = $admin->school;
       $schoolName = $school->name;
       $totalTeacher = $this->teachers->setTeacher()->where('school_id', $school->id)->count();
       $totalStudent = $this->student->setStudent()->where('school_id', $school->id)->count();
       $totalSchoolAdmin = $this->admin->setAdmin()->where('school_id', $school->id)->count();

       return response()->json(['data' => [
           'schoolName' => $schoolName,
           'totalTeacher' => $totalTeacher,
           'totalStudent' => $totalStudent,
           'totalSchoolAdmin' => $totalSchoolAdmin,
       ]]);
    }

    public function studentStat()
    {
        $admin = Auth::guard('school_api')->user();
        $session = env('CURRENT_SESSION');
        $school_id = $admin->school_id;

        $classes = Classes::where('school_id', $school_id)->orderBy('class_name', 'asc')->get();

        $labels = []; 
        $males_count = [];
        $females_count = [];
        $unknown_count = [];
        $class_count = [];

        $classes->each(function($clas) use (&$class_count, &$labels, &$males_count,
                                            &$females_count, &$unknown_count,
                                            $school_id, $session) {
            $labels[] = $clas->class_name;

            $class_count[] = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->where('classarm_student.class_id', $clas->id)
                        ->distinct('classarm_student.student_id')
                        ->count();
            
            $males_count[] = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->whereIn('students.gender', ['Male', 'male', 'M', 'm'])
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->where('classarm_student.class_id', $clas->id)
                        ->distinct('classarm_student.student_id')
                        ->count();

            $females_count[] = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->whereIn('students.gender', ['Female', 'female', 'F', 'f'])
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->where('classarm_student.class_id', $clas->id)
                        ->distinct('classarm_student.student_id')
                        ->count();

            $unknown_count[] = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->where('students.gender', null)
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->where('classarm_student.class_id', $clas->id)
                        ->distinct('classarm_student.student_id')
                        ->count();
        });

        $males = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->whereIn('students.gender', ['Male', 'male', 'M', 'm'])
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->distinct('classarm_student.student_id')
                        ->count();

        $females = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->whereIn('students.gender', ['Female', 'female', 'F', 'f'])
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->distinct('classarm_student.student_id')
                        ->count();

        $unknown = $this->student->setStudent()
                        ->where('students.school_id', $school_id)
                        ->where('students.gender', null)
                        ->rightJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
                        ->where('classarm_student.session', $session)
                        ->distinct('classarm_student.student_id')
                        ->count();

        return response()->json(['data' => [
                'labels' => $labels,
                'males_count' => $males_count,
                'females_count' => $females_count,
                'unknown_count' => $unknown_count,
                'gender_chart' => [$males, $females, $unknown],
                'class_chart' => $class_count,
                'session' => $session
        ]]);
    }

}
