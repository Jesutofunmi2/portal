<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinistrySchoolResource extends JsonResource
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
            'name' => $this->name,
            'lga' => optional($this->statesLGA)['name'],
            'lga_id' => $this->lga_id,
            'category' => $this->school_category,
            'logo' => $this->logo,
            'address' => $this->address,
            'time' => optional($this->created_at)->diffForHumans(),
        ];
    }
}
