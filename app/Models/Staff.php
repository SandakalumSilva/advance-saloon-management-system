<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BranchFilter;

class Staff extends Model
{
    use BranchFilter;

    protected $fillable = [
        'user_id',
        'branch_id',
        'employee_code',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'join_date',
        'basic_salary',
        'photo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function leaves()
    {
        return $this->hasMany(StaffLeave::class);
    }
}
