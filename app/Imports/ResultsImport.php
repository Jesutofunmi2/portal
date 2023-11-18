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

class ResultsImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
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
            foreach ($this->data['subjects'] as $subj) {
                $subject_code = $subj->code;
                $subject_id = $subj->id;
                $class_catg = $subj->catg;
                $code = strtolower(str_replace('-', '_', $subject_code));
                $ca1_score = 'ca1_'.$code;
                $ca2_score = 'ca2_'.$code;
                $exam_score = 'exam_'.$code;

                $not_offering = DB::table('student_subject_unoffered')
                ->where('subject_id', $subject_id)
                ->where('classarm_id', $this->data['classarm_id'])
                ->where('session', $this->data['session'])
                ->count();

                if ($not_offering > 0) {
                    continue;
                }

                if (isset($row[$ca1_score]) && $row[$ca1_score] !== '' && isset($row[$ca2_score]) && $row[$ca2_score] !== '' && isset($row[$exam_score]) && $row[$exam_score] !== '' && is_numeric($row[$ca1_score]) && is_numeric($row[$ca2_score]) && is_numeric($row[$exam_score])) {
                    $weighted = (int)$row[$ca1_score] + (int)$row[$ca2_score] + (int)$row[$exam_score];
                } else {
                    continue;
                }  

                $grade = DB::table('grade_config')
                        ->where('class_type', $class_catg)
                        ->where('score_to', '>=', $weighted)
                        ->where('score_from', '<=', $weighted)
                        ->first();

                $result = StudentResult::updateOrCreate([
                    'student_id' => $student_id,
                    'session' => $this->data['session'],
                    'term' => $this->data['term'],
                    'class_id' => $this->data['class_id'],
                    'classarm_id' => $this->data['classarm_id'],
                    'subject_id' => $subject_id,
                    'school_id' => $this->data['school_id'],
                ],
                [
                    'ca_score' => $row[$ca1_score],
                    'ca2_score' => $row[$ca2_score],
                    'exam_score' => $row[$exam_score],
                    'weighted_average' => $weighted,
                    'grade' => $grade->grade ?? 'N/A',
                    'remarks' => $grade->remark ?? 'N/A',
                    'promotion' => 0,
                    'status' => 0,
                ]);
            }
        } else {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'regnum' => 'required',
        ];
    }
}