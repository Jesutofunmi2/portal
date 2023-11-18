<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinistryWalletResource extends JsonResource
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
            'session' => $this->session,
            'balance' => is_null($this->available_balance) ? $this->available_balance : number_format($this->available_balance, 2),
            'wallet_id' => $this->wallet_id,
        ];
    }
}
