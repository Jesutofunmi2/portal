<?php

namespace App\Exports\Survey;

use App\Models\SchoolSurvey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubjectQualifiedExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $session;

    public function __construct(Collection $surveys, $session)
    {
        $this->surveys = $surveys;
        $this->session = $session;
    }

    public function array(): array
    {
       return [
        ['Census Year', $this->session],
        ['Sector', 'Public'],
        ['Level', 'Contains Nursery and Primary'],
        ['Print Date', Carbon::now()],
        [''],
        [''],
        ['State', 'LGA', 'School Name', 'School Code',
        'Number of Male Teachers that teach Subject of Qualification',
        'Number of Female Teachers that teach Subject of Qualification',
        'Total Teachers Teaching Subj of Qualification',
        'Total Male Teachers', 'Total Female Teachers', 'Total Teachers',
        '% of Male Teachers that Teach subject of Qualification',
        '% of Female Teachers that Teach subject of Qualification',
        '% of Teachers that Teach subject of Qualification'],

        $this->surveys->map(function($survey) {
            $teach_subject_qualification_male = 0;
            $teach_subject_qualification_female = 0;
            $total_teacher_male = 0;
            $total_teacher_female = 0;

            $teachers = $survey->staffs['staff_data'];

            foreach ($teachers as $teacher) {
                if($teacher['gender'] == 'Male')  $total_teacher_male += 1;
                if($teacher['gender'] == 'Female')  $total_teacher_female += 1;
                if($teacher['main_subject'] == $teacher['area_specialization'] && $teacher['gender'] == 'Male') $teach_subject_qualification_male += 1;
                if($teacher['main_subject'] == $teacher['area_specialization'] && $teacher['gender'] == 'Female') $teach_subject_qualification_female += 1;
            }
            
            $teach_subject_qualification = $teach_subject_qualification_male + $teach_subject_qualification_female;
            $total_teacher = $total_teacher_male + $total_teacher_female;
            $qualification_male_percentage = ($teach_subject_qualification_male / $total_teacher_male) * 100;
            $qualification_female_percentage = ($teach_subject_qualification_female / $total_teacher_female) * 100;
            $qualification_total_percentage = ($teach_subject_qualification / $total_teacher) * 100;

            return [
                'Ondo',
                strtoupper($survey->lga_name),
                strtoupper($survey->name),
                strtoupper($survey->identities['school_code']),
                $teach_subject_qualification_male, $teach_subject_qualification_female, $teach_subject_qualification,
                $total_teacher_male, $total_teacher_female, $total_teacher, round($qualification_male_percentage, 2),
                round($qualification_female_percentage ,2), round($qualification_total_percentage, 2)
            ];
        })
       ];
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Subject Qualified';
    }
}