<?php

namespace App\Interfaces;

interface StaffLeaveInterface
{
    public function allStaffWIthLeave($month = null, $year = null);
    public function addLeave(array $data): int;
}
