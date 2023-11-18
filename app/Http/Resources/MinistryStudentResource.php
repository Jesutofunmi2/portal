<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Helper\GeneralHelper;

class MinistryStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->surname.' '.$this->firstname.' '.$this->middlename,
            'ossi' => $this->regnum,
            'gender' => $this->gender ?? 'Unknown',
            'passport' => $this->passport,
            'school' => GeneralHelper::getSchool($this->school_id),
        ];
    }
}
