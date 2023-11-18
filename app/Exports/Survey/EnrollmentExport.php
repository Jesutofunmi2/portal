<?php

namespace App\Exports\Survey;

use App\Models\SchoolSurvey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnrollmentExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $lgas;
    protected $session;
    protected $headings = ['State', 'LGA', 'School', 'Kindergateen 1 (M)', 'Kindergateen 1 (F)', 'Kindergateen 2 (M)', 'Kindergateen 2 (F)',
                        'Nursery 1 (M)', 'Nursery 1 (F)', 'Nursery 2 (M)', 'Nursery 2 (F)', 'Nursery 3 (M)', 'Nursery 3 (F)'];
    public $lga_summary = [];
    
    public $kindergateen_one_male = 0;
    public $kindergateen_one_female = 0;
    public $kindergateen_two_male = 0;
    public $kindergateen_two_female = 0;
    public $nursery_one_male = 0;
    public $nursery_one_female = 0;
    public $nursery_two_male = 0;
    public $nursery_two_female = 0;
    public $nursery_three_male = 0;
    public $nursery_three_female = 0;

    public function __construct(Collection $surveys, Collection $lgas, $session)
    {
        $this->surveys = $surveys;
        $this->lgas = $lgas;
        $this->session = $session;
    }

    public function array(): array
    {
        $all = [
            ['Census Year', $this->session],
            ['Sector', 'Public'],
            ['Level', 'Contains Nursery and Primary'],
            ['Print Date', Carbon::now()],
            [''],
        ];

        $this->lgas->map(function($lga) use (&$all) {
            $surveys = $this->surveys->filter(function($survey) use ($lga) {return $survey->lga_id == $lga->id;})->all();
            $lga_name = strtoupper($lga->name);
            array_push($all, ['LGA: '.$lga_name]);
            array_push($all, $this->headings);

            $data = collect($surveys)->map(function($survey) use ($lga_name) {
                return $this->getTeacherSurveyData($survey, $lga_name);
            });
            array_push($all, ...$data);
            array_push($all, ['', '', 'TOTAL', $this->kindergateen_one_male, $this->kindergateen_one_female, $this->kindergateen_two_male, $this->kindergateen_two_female,
                                 $this->nursery_one_male, $this->nursery_one_female, $this->nursery_two_male,
                                $this->nursery_two_female,  $this->nursery_three_male, $this->nursery_three_female]);
            array_push($all, ['']);
            array_push($all, ['']);
            array_push($this->lga_summary, ['', '', $lga_name, $this->kindergateen_one_male, $this->kindergateen_one_female, $this->kindergateen_two_male, $this->kindergateen_two_female,
                        $this->nursery_one_male, $this->nursery_one_female, $this->nursery_two_male,
                    $this->nursery_two_female,  $this->nursery_three_male, $this->nursery_three_female]
                    );

            $this->kindergateen_one_male = 0;
            $this->kindergateen_one_female = 0;
            $this->kindergateen_two_male = 0;
            $this->kindergateen_two_female = 0;
            $this->nursery_one_male = 0;
            $this->nursery_one_female = 0;
            $this->nursery_two_male = 0;
            $this->nursery_two_female = 0;
            $this->nursery_three_male = 0;
            $this->nursery_three_female = 0;
        });

        array_push($all, ...$this->lga_summary);
        
       return $all;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            6    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function getTeacherSurveyData(SchoolSurvey $survey, $lga_name)
    {
        $kindergateen_one_male = $survey->enrollments['ecde_enroll_total_kd_one_male'];
        $kindergateen_one_female = $survey->enrollments['ecde_enroll_total_kd_one_female'];
        $kindergateen_two_male = $survey->enrollments['ecde_enroll_total_kd_two_male'];
        $kindergateen_two_female = $survey->enrollments['ecde_enroll_total_kd_two_female'];
        $nursery_one_male = $survey->enrollments['ecde_enroll_total_nus_one_male'];
        $nursery_one_female = $survey->enrollments['ecde_enroll_total_nus_one_female'];
        $nursery_two_male = $survey->enrollments['ecde_enroll_total_nus_two_male'];
        $nursery_two_female = $survey->enrollments['ecde_enroll_total_nus_two_female'];
        $nursery_three_male = $survey->enrollments['ecde_enroll_total_nus_three_male'];
        $nursery_three_female = $survey->enrollments['ecde_enroll_total_nus_three_female'];

        $this->kindergateen_one_male += $kindergateen_one_male;
        $this->kindergateen_one_female += $kindergateen_one_female;
        $this->kindergateen_two_male += $kindergateen_two_male;
        $this->kindergateen_two_female += $kindergateen_two_female;
        $this->nursery_one_male += $nursery_one_male;
        $this->nursery_one_female += $nursery_one_female;
        $this->nursery_two_male += $nursery_two_male;
        $this->nursery_two_female += $nursery_two_female;
        $this->nursery_three_male += $nursery_three_male;
        $this->nursery_three_female += $nursery_three_female;

        return ['Ondo', $lga_name,
            strtoupper($survey->name),
            $kindergateen_one_male, $kindergateen_one_female, $kindergateen_two_male, $kindergateen_two_female,
            $nursery_one_male, $nursery_one_female, $nursery_two_male, $nursery_two_female,
            $nursery_three_male, $nursery_three_female
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Enrollment(Summary)';
    }
}