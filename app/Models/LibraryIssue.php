<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LibraryIssue extends Model
{
    protected $table = 'library_issue';

    protected $fillable = ['school_id', 'book_id', 'issued_to', 'issue_date', 'due_date', 'return_date', 'return_status', 'issued_by'];

}
