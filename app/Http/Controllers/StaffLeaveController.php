<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffLeaveController extends Controller
{
    public function index(){
        return view('staff.bulk-leave');
    }
}
