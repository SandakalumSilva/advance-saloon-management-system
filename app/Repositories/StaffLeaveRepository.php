<?php

namespace App\Repositories;

use  App\Interfaces\StaffLeaveInterface;
use App\Models\Staff;
use App\Models\StaffLeave;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffLeaveRepository implements StaffLeaveInterface
{

    public function allStaffWIthLeave($month = null, $year = null)
    {
        $month ??= now()->month;
        $year ??= now()->year;
        $branchId = Auth::user()->branch_id;

        $date = Carbon::create($year, $month, 1);

        return Staff::query()
            ->with([
                'user',
                'leaves' => fn($query) => $query
                    ->where('branch_id', $branchId)
                    ->whereBetween('leave_date', [
                        $date->copy()->startOfMonth()->toDateString(),
                        $date->copy()->endOfMonth()->toDateString(),
                    ]),
            ])
            ->branchFilter()
            ->get();
    }


    public function addLeave(array $data): int
    {
        if (empty($data)) {
            return 0;
        }

        $rows = [];
        $userIds = [];
        $now = now();
        $monthStart = null;
        $monthEnd = null;

        foreach ($data as $item) {
            if (empty($item['staff_id']) || empty($item['day'])) {
                continue;
            }

            $date = Carbon::parse($item['day']);
            $userId = (int) $item['staff_id'];

            if ($monthStart === null) {
                $monthStart = $date->copy()->startOfMonth()->toDateString();
                $monthEnd   = $date->copy()->endOfMonth()->toDateString();
            }

            $userIds[] = $userId;

            $rows[] = [
                'user_id'    => $userId,
                'branch_id' => Auth::user()->branch_id,
                'leave_date' => $date->toDateString(),
                'leave_type' => 'off_day',
                'duration'   => 'full_day',
                'reason'     => null,
                'is_paid'    => true,
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (empty($rows) || $monthStart === null || $monthEnd === null) {
            return 0;
        }

        $userIds = array_values(array_unique($userIds));


        return DB::transaction(function () use ($rows, $monthStart, $monthEnd) {
            StaffLeave::query()
                ->where('branch_id', Auth::user()->branch_id)
                ->whereBetween('leave_date', [$monthStart, $monthEnd])
                ->delete();

            StaffLeave::insert($rows);

            return count($rows);
        });
    }
}
