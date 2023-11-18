<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferTeacher extends Model
{
    protected $table = 'transfers_teacher';

    protected $fillable = ['teacher_id', 'former_staff_no', 'new_staff_no', 'former_school', 'new_school','transfer_status','session','term', 'reason_for_transfer'];
}
