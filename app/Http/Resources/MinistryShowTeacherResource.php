<?php

namespace App\Http\Resources;
use App\Http\Helper\GeneralHelper;

use Illuminate\Http\Resources\Json\JsonResource;

class MinistryShowTeacherResource extends JsonResource
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
                'title' => $this->title,
                'surname' => $this->surname,
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'school_id' => $this->school_id,
                'staff_no' => $this->staff_no,
                'staff_no_digit' => $this->staff_no_digit,
                'qualification' => $this->qualification,
                'gender' => $this->gender,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'session' => $this->session,
                'state_id' => $this->state_id,
                'lga_id' => $this->lga_id,
                'next_of_kins' => $this->next_of_kins,
                'next_of_kins_address' => $this->next_of_kins_address,
                'next_of_kins_phone' => $this->next_of_kins_phone,
                'next_of_kins_email' => $this->next_of_kins_email,
                'health_status' => $this->health_status,
                'extra_curricular_activites' => $this->extra_curricular_activites,
                'health_status_desc' => $this->health_status_desc ,
                'marital_status' => $this->marital_status,
                'subjects' => GeneralHelper::getAssocSubject($this->id),
            
        ];
    }
}
