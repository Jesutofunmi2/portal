<?php

namespace App\Exports;

use App\Models\Student\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultsExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    public function query()
    {
        return Student::query()
        ->select('students.surname', 'students.firstname', 'students.middlename', 'students.regnum as regnum')
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->where('students.school_id', $this->data['school_id'])
        ->where('classarm_student.classarm_id', $this->data['classarm_id'])
        ->where('classarm_student.class_id', $this->data['class_id'])
        ->where('classarm_student.session', $this->data['session'])
        ->where('classarm_student.term', $this->data['term'])
        ->distinct('regnum')
        ->orderBy('surname')
        ->orderBy('firstname')
        ->orderBy('middlename');
    }

    public function headings(): array
    {
        $heading = ['surname', 'firstname', 'middlename', 'regnum'];
        
        foreach ($this->data['subject_codes'] as $temp_code) {
            $code = str_replace('-', '_', $temp_code);
            $heading[] = 'ca1_'.strtolower($code);
            $heading[] = 'ca2_'.strtolower($code);
            $heading[] = 'exam_'.strtolower($code);
        }

        return $heading;
    }

    // public function query()
    // {
    //     return Student::query()
    //     ->select('students.regnum as ossi', 'students.surname', 'students.firstname', 'students.middlename', 'schools_new.name as school_name')
    //     ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
    //     ->join('schools_new', 'schools_new.id', '=', 'students.school_id')
    //     ->where('classarm_student.session', 2021)
    //     ->distinct('regnum')
    //     ->orderBy('surname')
    //     ->orderBy('firstname')
    //     ->orderBy('middlename');
    // }

    // public function headings(): array
    // {
    //     $heading = ['ossi', 'surname', 'firstname', 'middlename', 'school_name'];

    //     return $heading;
    // }
}