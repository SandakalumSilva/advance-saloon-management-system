<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BranchFilter;

class Service extends Model
{
    use HasFactory,BranchFilter;

    protected $fillable = [
        'branch_id',
        'service_category_id',
        'name',
        'code',
        'description',
        'duration_minutes',
        'price',
        'cost',
        'commission_type',
        'commission_value',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'commission_value' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
