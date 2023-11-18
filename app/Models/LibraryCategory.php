<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryCategory extends Model
{
    protected $table = 'library_category';

    protected $fillable = ['school_id', 'name'];

}
