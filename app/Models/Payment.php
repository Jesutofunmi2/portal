<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = ['school_id', 'payer_id', 'customer_id', 'item_id', 'session', 'payment_type', 'total_cost', 'recipient_count', 'pay_status', 'pay_channel', 'paygate_status_code', 'paygate_status_msg', 'order_date'];

    
}