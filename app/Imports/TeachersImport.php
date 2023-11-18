<?php

namespace App\Imports;

use App\Models\Teacher\Teacher;
use Illuminate\Support\Facades\Hash;
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

class TeachersImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError
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
        
        $staff_no_digit = $this->data['staff_no_digit'];

        $staff_no = strtoupper($this->data['state']).'/'.str_pad($this->data['school_id'], 4, 0, STR_PAD_LEFT).'/STAFF/'.$this->data['session'].'/'.str_pad($staff_no_digit, 4, "0", STR_PAD_LEFT);

        $state_id = 28;
        $lga_id = 237;

        $teacher = Teacher::create([
            'staff_no' => $staff_no,
            'staff_no_digit' => $staff_no_digit,
            'title' => $row['title'],
            'surname' => $row['surname'],
            'firstname' => $row['firstname'],
            'middlename' => $row['middlename'],
            'email' => $row['email'],
            'gender' => $row['gender'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'qualification' => $row['qualification'],
            'health_status' => $row['health_status'],
            'health_status_desc' => $row['health_status_description'],
            'next_of_kins' => $row['next_of_kins'],
            'next_of_kins_address' => $row['next_of_kins_address'],
            'next_of_kins_email' => $row['next_of_kins_email'],
            'next_of_kins_phone' => $row['next_of_kins_phone'],
            'marital_status' => $row['marital_status'], 
            'extra_curricular_activites' => $row['extra_curricular_activities'],
            'state_id' => $state_id,
            'lga_id' => $lga_id,
            'password' => Hash::make($row['password']),
            'session' => $this->data['session'],
            'school_id' => $this->data['school_id'],
            'status' => 0,
        ]);

        if ($teacher) {
            $staff_no_digit++;
            $this->data['staff_no_digit'] = $staff_no_digit;
        }

    }

    public function rules(): array
    {
        return [
            'surname' => 'required',
            'firstname' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required',
            'password' => 'required',
        ];
    }
}
