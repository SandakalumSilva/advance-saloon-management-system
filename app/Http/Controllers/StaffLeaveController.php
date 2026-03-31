<?php

namespace App\Http\Controllers;

use App\Interfaces\StaffLeaveInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StaffLeaveController extends Controller
{

    protected StaffLeaveInterface $staffLeaveRepository;

    public function __construct(StaffLeaveInterface $staffLeaveRepository)
    {
        $this->staffLeaveRepository = $staffLeaveRepository;
    }
    public function index()
    {
        $allStaff = $this->staffLeaveRepository->allStaffWIthLeave();
        Log::info($allStaff);
        return view('staff.bulk-leave', ['allStaff' => $allStaff]);
    }
}
