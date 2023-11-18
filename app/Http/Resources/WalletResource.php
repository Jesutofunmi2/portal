<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'cleared_balance' => $this->cleared_balance,
            'available_balance' => $this->available_balance,
            'last_payment' => $this->last_payment,
            'account_balance' => $this->account_balance,
        ];
    }
}
