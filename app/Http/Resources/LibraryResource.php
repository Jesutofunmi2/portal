<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResource extends JsonResource
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
            'cat_id' => $this->cat_id,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'subject' => $this->subject,
            'descrip' => $this->descrip,
            'location' => $this->location,
            'isbn' => $this->isbn,
            'serial_no' => $this->serial_no,
            'copies' => $this->copies,
            'available' => $this->available,
            'posted_by' => $this->posted_by,
        ];
    }
}