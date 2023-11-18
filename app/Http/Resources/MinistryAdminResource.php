<?php

namespace App\Http\Resources;
use App\Http\Helper\GeneralHelper;
use App\Models\NgStatesLGA;
use Illuminate\Http\Resources\Json\JsonResource;

class MinistryAdminResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'lgas' => $this->when($this->is_aeozeo, $this->getLga($this->lgas))
        ];
    }

    public function getLga($lga_ids) {
        if(is_null($lga_ids)) return;
        
        $lgas = NgStatesLGA::whereIn('id', $lga_ids)->get();
        return LgaResource::collection($lgas);
    }
}
