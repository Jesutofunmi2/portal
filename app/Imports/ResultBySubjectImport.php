<?php

namespace App\Imports;

use App\Models\StudentResult;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResultBySubjectImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $student_id = DB::table('students')
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->where('students.regnum', $row['regnum'])
        ->where('classarm_student.classarm_id', $this->data['classarm_id'])
        ->where('classarm_student.class_id', $this->data['class_id'])
        ->where('classarm_student.session', $this->data['session'])
        ->value('students.id');

        if (! is_null($student_id)) {
            if (isset($row['ca1']) && $row['ca1'] !== '' && isset($row['ca2']) && $row['ca2'] !== '' && isset($row['ca1']) && $row['exam'] !== '' && is_numeric($row['ca1']) && is_numeric($row['ca2']) && is_numeric($row['exam'])) {
                $weighted = (int)$row['ca1'] + (int)$row['ca2'] + (int)$row['exam'];
            } else {
                return null;
            }  
            
            $grade = DB::table('grade_config')
            ->where('class_type', $this->data['class_catg'])
            ->where('score_to', '>=', $weighted)
            ->where('score_from', '<=', $weighted)
            ->first(); 
            
            $result = StudentResult::updateOrCreate([
                'student_id' => $student_id,
                'session' => $this->data['session'],
                'term' => $this->data['term'],
                'class_id' => $this->data['class_id'],
                'classarm_id' => $this->data['classarm_id'],
                'subject_id' => $this->data['subject_id'],
                'school_id' => $this->data['school_id'],
            ],
            [
                'ca_score' => $row['ca1'],
                'ca2_score' => $row['ca2'],
                'exam_score' => $row['exam'],
                'weighted_average' => $weighted,
                'grade' => $grade->grade,
                'remarks' => $grade->remark,
                'promotion' => 0,
                'status' => 0,
            ]);
        } else {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'regnum' => 'required',
            'ca1' => 'required|integer',
            'ca2' => 'required|integer',
            'exam' => 'required|integer',
        ];
    }
}