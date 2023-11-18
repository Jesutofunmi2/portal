<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItems extends Model
{
    protected $table = 'payment_items';

    protected $fillable = ['item_name', 'item_code', 'cost'];

    public $timestamps	=	false;

}
