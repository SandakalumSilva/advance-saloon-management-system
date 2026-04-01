<?php

namespace App\Interfaces;

interface StaffLeaveInterface
{
    public function allStaffWIthLeave();
    public function addLeave(array $data): int;
}
