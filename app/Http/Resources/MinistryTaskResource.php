<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MinistryTaskResource extends JsonResource
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
            'department_id' => $this->department_id,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'due_date' => $this->due_date,
            'descrip' => $this->descrip,
            'department' => $this->department ? $this->department['name'] : 'N/A',
            'status_label' => $this->getStatus($this->task_status),
            'approval_label' => $this->approval == 1 ? 'Unapprove' : 'Approved',
        ];
    }

    public function getStatus($status) {
        if($status == 1) return 'Pending';

        if($status == 2) return 'In-Progress';

        if($status == 3) return 'Completed';

        if($status == 4) return 'Abandoned';

        return 'Unknown';
    }
}
