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
        $month = request('month', now()->month);
        $year  = request('year', now()->year);

        $allStaff = $this->staffLeaveRepository->allStaffWIthLeave($month, $year);
        return view('staff.bulk-leave', ['allStaff' => $allStaff]);
    }

    public function addLeave(Request $request)
    {
        // dd($request->all());
        $count = $this->staffLeaveRepository->addLeave($request->input('data', []));
        return response()->json([
            'message' => 'Leaves saved successfully.',
            'count' => $count,
        ]);
    }
}
