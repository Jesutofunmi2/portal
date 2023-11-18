<?php

namespace App\Exports;

use App\Models\Student\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommentsExport implements FromQuery, WithHeadings
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
            $this->data['comment'],
        ];

        return $heading;
    }
}