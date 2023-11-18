<?php

namespace App\Exports;

use App\Models\Student\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultsBySubjectExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    public function query()
    {
        $not_offering = DB::table('student_subject_unoffered')
        ->where('classarm_id', $this->data['classarm_id'])
        ->where('subject_id', $this->data['subject_id'])
        ->where('session', $this->data['session'])
        ->pluck('student_id');

        return Student::query()
        ->select('students.surname', 'students.firstname', 'students.middlename', 'students.regnum as regnum')
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->where('students.school_id', $this->data['school_id'])
        ->where('classarm_student.classarm_id', $this->data['classarm_id'])
        ->where('classarm_student.class_id', $this->data['class_id'])
        ->where('classarm_student.session', $this->data['session'])
        ->where('classarm_student.term', $this->data['term'])
        ->whereNotIn('students.id', $not_offering)
        ->distinct('regnum')
        ->orderBy('surname')
        ->orderBy('firstname')
        ->orderBy('middlename');
        
    }

    public function headings(): array
    {
        $heading = [
            'surname',
            'firstname',
            'middlename',
            'regnum',
            'ca1',
            'ca2',
            'exam',
        ];

        return $heading;
    }
}