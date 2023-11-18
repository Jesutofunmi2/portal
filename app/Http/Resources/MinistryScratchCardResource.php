<?php

namespace App\Http\Resources;

use App\Http\Helper\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MinistryScratchCardResource extends JsonResource
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
            'serial' => $this->serial,
            'pin' => $this->pin,
            'student_id' => $this->student_id ? GeneralHelper::getStudentISSI($this->student_id) : 'available',
            'is_delete' => false,
        ];
    }
}
