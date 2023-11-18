<?php

namespace App\Exports\Survey;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithProperties;

class SurveyExport implements WithMultipleSheets, WithProperties
{
    use Exportable;

    protected $surveys;
    protected $lgas;
    protected $session;

    public function __construct(Collection $surveys, Collection $lgas, $session)
    {
        $this->surveys = $surveys;
        $this->lgas = $lgas;
        $this->session = $session;
    }

    public function sheets(): array
    {
        $sheets = [
            new IdentitiesExport($this->surveys, $this->session),
            new TeachersExport($this->surveys, $this->lgas, $this->session),
            new NonTeachersExport($this->surveys, $this->lgas, $this->session),
            new SubjectQualifiedExport($this->surveys, $this->session),
            new FacilitiesExport($this->surveys, $this->session),
            new ClassroomsExport($this->surveys, $this->lgas, $this->session),
            new EnrollmentExport($this->surveys, $this->lgas, $this->session)
        ];

        return $sheets;
    }

    public function properties(): array
    {
        return [
            'creator'        => env('SITE_NAME'),
            'lastModifiedBy' => env('SITE_NAME'),
            'title'          => $this->session.' Surveys Summary',
            'description'    => $this->session.' Surveys Summary',
            'subject'        => 'Surveys Summary',
            'keywords'       => 'ondo,survey,summary',
            'category'       => 'Survey Summary',
            'manager'        => env('SITE_NAME'),
            'company'        => env('SITE_NAME'),
        ];
    }
}