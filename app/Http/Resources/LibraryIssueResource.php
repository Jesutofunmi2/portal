<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryIssueResource extends JsonResource
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
            'book_id' => $this->book_id,
            'issued_to' => $this->issued_to,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'return_date' => $this->return_date,
            'return_status' => $this->return_status,
            'issued_by' => $this->issued_by,
        ];
    }
}