<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRecipient extends Model
{
    protected $table = 'payment_recipient';

    protected $fillable = ['pay_id', 'student_id'];

    public $timestamps	=	false;

}
