<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $table = 'library';

    protected $fillable = ['school_id', 'cat_id', 'title', 'sub_title', 'author', 'publisher', 'subject', 'descrip', 'location', 'isbn', 'serial_no', 'copies', 'available', 'posted_by'];

}
