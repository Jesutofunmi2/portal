<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Helper\GeneralHelper;

class MinistrySchoolAdminResource extends JsonResource
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
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'username' => $this->username,
            'school_name' => GeneralHelper::getSchool($this->school_id),
            'school_id' => $this->school_id ?? '',
            'phone' => $this->phone,
        ];
    }
}
