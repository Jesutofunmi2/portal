<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'school_id' => $this->school_id,
            'title' => $this->title,
            'description' => $this->description,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'paidAt' => optional($this->updated_at)->diffForHumans(),
        ];
    }
}
