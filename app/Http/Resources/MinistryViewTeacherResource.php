<?php

namespace App\Http\Resources;
use App\Http\Helper\GeneralHelper;

use Illuminate\Http\Resources\Json\JsonResource;

class MinistryViewTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'fullname' => $this->title.' '.$this->surname.' '.$this->firstname.' '.$this->middlename,
            'staff_no' => $this->staff_no,
            'passport' => $this->passport,
            'school' => GeneralHelper::getSchool($this->school_id),
            'subjects' => GeneralHelper::getAssocSubject($this->id),
            
        ];
    }
}
