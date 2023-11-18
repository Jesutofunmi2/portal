<?php

namespace App\Http\Resources;

use App\Http\Helper\GeneralHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MinistryExamScratchCardResource extends JsonResource
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
            'regnum' => $this->regnum ?? 'available',
            'exam_type' => GeneralHelper::getExamType($this->exam_type) ,
            'multiple' => $this->multiple,
            'is_delete' => false,
        ];
    }
}
