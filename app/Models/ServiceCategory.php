<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BranchFilter;

class ServiceCategory extends Model
{
    use HasFactory,BranchFilter;

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
