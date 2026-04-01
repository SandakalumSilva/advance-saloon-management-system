<?php

namespace App\Repositories;

use  App\Interfaces\StaffLeaveInterface;
use App\Models\Staff;
use App\Models\StaffLeave;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StaffLeaveRepository implements StaffLeaveInterface
{
    public function allStaffWIthLeave()
    {
        $allStaff = Staff::with('user', 'leaves')->branchFilter()->get();
        return $allStaff;
    }

   
   public function addLeave(array $data): int
{
    if (empty($data)) {
        return 0;
    }

    $rows = [];
    $now = now();

    foreach ($data as $item) {
        if (empty($item['staff_id']) || empty($item['day'])) {
            continue;
        }

        $rows[] = [
            'user_id'   => (int) $item['staff_id'],
            'leave_date' => Carbon::parse($item['day'])->format('Y-m-d'),
            'leave_type' => 'off_day',
            'duration'   => 'full_day',
            'reason'     => null,
            'is_paid'    => true,
            'status'     => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    if (empty($rows)) {
        return 0;
    }

    return DB::transaction(function () use ($rows) {
        StaffLeave::upsert(
            $rows,
            ['staff_id', 'leave_date'],
            ['leave_type', 'duration', 'reason', 'is_paid', 'status', 'updated_at']
        );

        return count($rows);
    });
}
}
