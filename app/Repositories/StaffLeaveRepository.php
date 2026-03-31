<?php

namespace App\Repositories;

use  App\Interfaces\StaffLeaveInterface;
use App\Models\Staff;

class StaffLeaveRepository implements StaffLeaveInterface
{
    public function allStaffWIthLeave()
    {
        $allStaff = Staff::with('user', 'leaves')->branchFilter()->get();
        return $allStaff;
    }
}
