<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BranchFilter
{
    public function scopeBranchFilter(Builder $query): Builder
    {
        $user = Auth::user();

        if (!$user) {
            return $query;
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $query->where('branch_id', $user->branch_id);
    }
}
