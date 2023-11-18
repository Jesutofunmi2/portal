<?php

namespace App\Imports;

use App\Models\Student\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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

class StudentsImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
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
        
        $regnum_digit = $this->data['regnum_digit'];

        // we add same school to second database, our new app make use of this database 
        $school_lga_id = $this->data['school_lga_id'] > 579 ? $this->data['school_lga_id'] - 569 : $this->data['school_lga_id'] - 568;

        $regnum = str_pad($school_lga_id, 2, "0", STR_PAD_LEFT).substr($this->data['session'], 2, 2).str_pad($this->data['school_id'], 3, "0", STR_PAD_LEFT).str_pad($regnum_digit, 3, "0", STR_PAD_LEFT);

        $blood_group = trim($row['blood_group']);
        if($blood_group == '' || empty($blood_group)) {
            $blood_group = "Unknown";
        }

        $state_id = 28;
        $lga_id = 237;

        $exist = Student::query()->join('classarm_student', 'students.id' , '=','classarm_student.student_id')
        ->where([
                'students.surname' => $row['surname'],
                'students.firstname' => $row['firstname'],
                'students.school_id' => $this->data['school_id'],
                'classarm_student.session' => $this->data['session'],
                'classarm_student.class_id' => $this->data['class_id'],
                'classarm_student.classarm_id' => $this->data['classarm_id']
        ])
        ->exists();

        if ($exist) {
            return null;
        }

        $student = Student::create([
            'regnum' => $regnum,
            'regnum_digit' => $regnum_digit,
            'surname' => $row['surname'],
            'firstname' => $row['firstname'],
            'middlename' => $row['middlename'],
            'phone' => $row['phone'],
            'gender' => $row['gender'],
            'country' => $row['country'],
            'address' => $row['address'],
            'parent_fullname' => $row['parent_fullname'],
            'parent_address' => $row['parent_address'],
            'parent_phone' => $row['parent_phone'],
            'parent_email' => $row['parent_email'],
            'blood_group' => $blood_group,
            'password' => Hash::make($row['password']),
            'session' => $this->data['session'],
            'school_id' => $this->data['school_id'],
            'lga_id' => $lga_id,
            'state_id' => $state_id,
            'status' => 0,
        ]);

        if ($student) {
            DB::table('classarm_student')->insert([
                'student_id' => $student->id,
                'classarm_id' => $this->data['classarm_id'],
                'session' => $this->data['session'],
                'term' => $this->data['term'],
                'class_id' => $this->data['class_id'],
            ]);

            $regnum_digit++;
            $this->data['regnum_digit'] = $regnum_digit;
        }
    }

    public function rules(): array
    {
        return [
            'surname' => 'required',
            'firstname' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'address' => 'required',
            'password' => 'required',
        ];
    }
}
