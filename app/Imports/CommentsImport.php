<?php

namespace App\Imports;

use App\Models\StudentComments;
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

class CommentsImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
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

        if ($student_id) {

            $count = StudentComments::query()
            ->where('student_comments.classarm_id', $this->data['classarm_id'])
            ->where('student_comments.class_id', $this->data['class_id'])
            ->where('student_comments.session', $this->data['session'])
            ->where('student_comments.term', $this->data['term'])
            ->where('student_comments.student_id', $student_id)
            ->count();

            if ($count > 0) {
                $result = StudentComments::query()
                ->where('student_id', $student_id)
                ->where('session', $this->data['session'])
                ->where('term', $this->data['term'])
                ->where('class_id', $this->data['class_id'])
                ->where('classarm_id', $this->data['classarm_id'])
                ->where('school_id', $this->data['school_id'])
                ->update([
                    $this->data['comment'] => $row[$this->data['comment']],
                ]);
            } else {
                $result = StudentComments::create([
                    'student_id' => $student_id,
                    'session' => $this->data['session'],
                    'term' => $this->data['term'],
                    'class_id' => $this->data['class_id'],
                    'classarm_id' => $this->data['classarm_id'],
                    'school_id' => $this->data['school_id'],
                    $this->data['comment'] => $row[$this->data['comment']],
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