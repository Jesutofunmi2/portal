<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClassResource;

class StudentResource extends JsonResource
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
            'surname' => $this->surname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'regnum' => $this->regnum,
            'regnum_digit' => $this->regnum_digit,
            'school_id' => $this->school_id,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'country' => $this->country,
            'address' => $this->address,
            'state_id' => $this->state_id,
            'lga_id' => $this->lga_id,
            'religion' => $this->religion,
            'phone' => $this->phone,
            'passport' => $this->passport,
            'parent_fullname' => $this->parent_fullname,
            'parent_address' => $this->parent_address,
            'parent_email' => $this->parent_email,
            'parent_phone' => $this->parent_phone,
            'session' => $this->session,
            'house_id' => $this->house_id,
            'blood_group' => $this->blood_group,
        ];
    }
}
