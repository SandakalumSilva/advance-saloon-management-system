<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    protected $fillable = [
        'staff_id',
        'leave_date',
        'leave_type',
        'duration',
        'reason',
        'is_paid',
        'status',
    ];

    protected $casts = [
        'leave_date' => 'date',
        'is_paid' => 'boolean',
        'status' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
