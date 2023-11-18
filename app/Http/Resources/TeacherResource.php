<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'title' => $this->title,
            'surname' => $this->surname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'qualification' => $this->qualification,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'session' => $this->session,
            'school_id' => $this->school_id,
            'staff_no' => $this->staff_no,
            'staff_no_digit' => $this->staff_no_digit,
            'qualification' => $this->qualification,
            'extra_curricular_activites' => $this->extra_curricular_activites,
            'state_id' => $this->state_id,
            'lga_id' => $this->lga_id,
            'next_of_kins' => $this->next_of_kins,
            'next_of_kins_address' => $this->next_of_kins_address,
            'next_of_kins_phone' => $this->next_of_kins_phone,
            'next_of_kins_email' => $this->next_of_kins_email,
            'health_status' => $this->health_status,
            'health_status_desc' => $this->health_status_desc
        ];
    }
}
