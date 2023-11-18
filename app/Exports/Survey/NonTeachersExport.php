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

class NonTeachersExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $lgas;
    protected $session;
    protected $headings = ['State', 'LGA', 'School', 'Total Non-Teaching (M)', 'Total Non-Teaching (F)',
                            'Total Non-Teaching (T)'];
    public $lga_summary = [];
    public $non_teaching_male = 0;
    public $non_teaching_female = 0;
    public $non_teaching_total = 0;

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
            array_push($all, ['', '', 'TOTAL', $this->non_teaching_male, $this->non_teaching_female, $this->non_teaching_total]);
            array_push($all, ['']);
            array_push($all, ['']);
            array_push($this->lga_summary, ['', '', $lga_name, $this->non_teaching_male, $this->non_teaching_female, $this->non_teaching_total]);

            $this->non_teaching_male = 0;
            $this->non_teaching_female = 0;
            $this->non_teaching_total = 0;
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
        $non_teaching_male = $survey->staffs['non_teaching_staff_male'];
        $non_teaching_female = $survey->staffs['non_teaching_staff_female'];
        $non_teaching_total = $non_teaching_male + $non_teaching_female;
        
        $this->non_teaching_male += $non_teaching_male;
        $this->non_teaching_female += $non_teaching_female;
        $this->non_teaching_total += $non_teaching_total;

        return ['Ondo', $lga_name,
            strtoupper($survey->name),
            $non_teaching_male, $non_teaching_female, $non_teaching_total
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Non-Teachers';
    }
}