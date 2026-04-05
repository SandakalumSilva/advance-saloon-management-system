<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\BranchFilter;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, SoftDeletes, BranchFilter;

    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'branch_id',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'notes',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
