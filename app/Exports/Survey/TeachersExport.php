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

class TeachersExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $lgas;
    protected $session;
    protected $headings = ['School', 'NCE (M)', 'NCE (F)', 'PGDE (M)', 'PGDE (F)', 'B.Ed or Equivalent (M)', 'B.Ed or Equivalent (F)',
                            'M.Ed or Equivalent (M)', 'M.Ed or Equivalent (F)', 'Grade II or Equivalent (M)', 'Grade II or Equivalent (F)',
                            'None (M)', 'None (F)', 'Qualified Teachers (M)', 'Qualified Teachers (F)', 'Qualified Teachers (T)',
                            'UnQualified Teachers (M)', 'UnQualified Teachers (F)', 'UnQualified Teachers (T)', 'Total Teachers (M)',
                            'Total Teachers (F)', 'Total Teachers (T)'
                        ];

    public $lga_summary = [];
    public $nce_male = 0;
    public $nce_female = 0;
    public $pgde_male = 0;
    public $pgde_female = 0;
    public $b_edu_male = 0;
    public $b_edu_female = 0;
    public $m_edu_male = 0;
    public $m_edu_female = 0;
    public $grade2_male = 0;
    public $grade2_female = 0;
    public $none_male = 0;
    public $none_female = 0;
    public $qualified_male = 0;
    public $qualified_female = 0;
    public $qualified_total = 0;
    public $unqualified_male = 0;
    public $unqualified_female = 0;
    public $unqualified_total = 0;
    public $total_male = 0;
    public $total_female = 0;
    public $all_total = 0;


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

            array_push($all, ['LGA: '.strtoupper($lga->name)]);
            array_push($all, $this->headings);

            $data = collect($surveys)->map(function($survey) {
                return $this->getTeacherSurveyData($survey);
            });
            array_push($all, ...$data);
            array_push($all, ['TOTAL', $this->nce_male, $this->nce_female, $this->pgde_male, $this->pgde_female, $this->b_edu_male,
                    $this->b_edu_female, $this->m_edu_male, $this->m_edu_female, $this->grade2_male, $this->grade2_female, $this->none_male,
                    $this->none_female, $this->qualified_male, $this->qualified_female, $this->qualified_total, $this->unqualified_male, 
                    $this->unqualified_female, $this->unqualified_total, $this->total_male, $this->total_female, $this->all_total]
            );
            array_push($all, ['']);
            array_push($all, ['']);
            array_push($this->lga_summary, [strtoupper($lga->name), $this->nce_male, $this->nce_female, $this->pgde_male, $this->pgde_female, $this->b_edu_male,
            $this->b_edu_female, $this->m_edu_male, $this->m_edu_female, $this->grade2_male, $this->grade2_female, $this->none_male,
            $this->none_female, $this->qualified_male, $this->qualified_female, $this->qualified_total, $this->unqualified_male, 
            $this->unqualified_female, $this->unqualified_total, $this->total_male, $this->total_female, $this->all_total]);

            $this->nce_male = 0;
            $this->nce_female = 0;
            $this->pgde_male = 0;
            $this->pgde_female = 0;
            $this->b_edu_male = 0;
            $this->b_edu_female= 0;
            $this->m_edu_male = 0;
            $this->m_edu_female = 0;
            $this->grade2_male = 0;
            $this->grade2_female = 0;
            $this->none_male = 0;
            $this->none_female = 0;
            $this->qualified_male = 0;
            $this->qualified_female = 0;
            $this->qualified_total = 0;
            $this->unqualified_male = 0;
            $this->unqualified_female = 0;
            $this->unqualified_total = 0;
            $this->total_male = 0;
            $this->total_female = 0;
            $this->all_total = 0;
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

    public function getTeacherSurveyData(SchoolSurvey $survey)
    {
        $nce_male = 0;
        $nce_female = 0;
        $pgde_male = 0;
        $pgde_female = 0;
        $b_edu_male = 0;
        $b_edu_female = 0;
        $m_edu_male = 0;
        $m_edu_female = 0;
        $grade2_male = 0;
        $grade2_female = 0;
        $none_male = 0;
        $none_female = 0;

        $teachers = $survey->staffs['staff_data'];

        foreach ($teachers as $teacher) {
            if($teacher['t_qualification'] == 'NCE' && $teacher['gender'] == 'Male') $nce_male += 1;
            if($teacher['t_qualification'] == 'NCE' && $teacher['gender'] == 'Female') $nce_female += 1;
            if($teacher['t_qualification'] == 'PGDE' && $teacher['gender'] == 'Male') $pgde_male += 1;
            if($teacher['t_qualification'] == 'PGDE' && $teacher['gender'] == 'Female') $pgde_female += 1;
            if($teacher['t_qualification'] == 'B.Ed or Equivalent' && $teacher['gender'] == 'Male') $b_edu_male += 1;
            if($teacher['t_qualification'] == 'B.Ed or Equivalent' && $teacher['gender'] == 'Female') $b_edu_female += 1;
            if($teacher['t_qualification'] == 'M.Ed or Equivalent' && $teacher['gender'] == 'Male') $m_edu_male += 1;
            if($teacher['t_qualification'] == 'M.Ed or Equivalent' && $teacher['gender'] == 'Female') $m_edu_female += 1;
            if($teacher['t_qualification'] == 'Grade II or Equivalent' && $teacher['gender'] == 'Male') $grade2_male += 1;
            if($teacher['t_qualification'] == 'Grade II or Equivalent' && $teacher['gender'] == 'Female') $grade2_female += 1;
            if($teacher['t_qualification'] == 'none' && $teacher['gender'] == 'Male') $none_male += 1;
            if($teacher['t_qualification'] == 'none' && $teacher['gender'] == 'Female') $none_female += 1;
        }

        $qualified_male = $nce_male + $pgde_male + $b_edu_male + $m_edu_male + $grade2_male + $none_male;
        $qualified_female = $nce_female + $pgde_female + $b_edu_female + $m_edu_female + $grade2_female + $none_female;
        $qualified_total = $qualified_male + $qualified_female;
        $unqualified_male = 0;
        $unqualified_female = 0;
        $unqualified_total = $unqualified_male + $unqualified_female;

        $total_male = $qualified_male + $unqualified_male;
        $total_female = $qualified_female + $unqualified_female;
        $all_total = $total_male + $total_female;

        $this->nce_male += $nce_male;
        $this->nce_female += $nce_female;
        $this->pgde_male += $pgde_male;
        $this->pgde_female += $pgde_female;
        $this->b_edu_male += $b_edu_male;
        $this->b_edu_female += $b_edu_female;
        $this->m_edu_male += $m_edu_male;
        $this->m_edu_female += $m_edu_female;
        $this->grade2_male += $grade2_male;
        $this->grade2_female += $grade2_female;
        $this->none_male += $none_male;
        $this->none_female += $none_female;
        $this->qualified_male += $qualified_male;
        $this->qualified_female += $qualified_female;
        $this->qualified_total += $qualified_total;
        $this->unqualified_male += $unqualified_male;
        $this->unqualified_female += $unqualified_female;
        $this->unqualified_total += $unqualified_total;
        $this->total_male += $total_male;
        $this->total_female += $total_female;
        $this->all_total += $all_total;

        return [
            strtoupper($survey->name),
            $nce_male, $nce_female, $pgde_male, $pgde_female, $b_edu_male, $b_edu_female,
            $m_edu_male, $m_edu_female, $grade2_male, $grade2_female, $none_male, $none_female,
            $qualified_male, $qualified_female, $qualified_total, $unqualified_male,  $unqualified_female,
            $unqualified_total, $total_male, $total_female, $all_total 
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Teachers';
    }
}