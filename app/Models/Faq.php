<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';

    protected $fillable = ['title', 'slug', 'content', 'image1', 'image2', 'image3'];
}
