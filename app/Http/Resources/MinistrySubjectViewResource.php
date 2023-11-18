<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Helper\GeneralHelper;

class MinistrySubjectViewResource extends JsonResource
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
            'subject' => $this->subject_name,
            'class' => $this->class_category,
            'teachers' => GeneralHelper::getAssocTeacher($this->id),
        ];
    }
}
