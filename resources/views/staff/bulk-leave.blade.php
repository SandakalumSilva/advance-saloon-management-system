@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;

        $month = request('month', 3);
        $year = request('year', 2026);

        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

        $staffList = [
            [
                'id' => 1,
                'name' => 'Simon',
                'leaves' => [28],
            ],
            [
                'id' => 2,
                'name' => 'MImi',
                'leaves' => [4, 7, 28],
            ],
            [
                'id' => 3,
                'name' => 'Lily',
                'leaves' => [4, 5, 6, 8],
            ],
            [
                'id' => 4,
                'name' => 'Coco',
                'leaves' => [6, 28],
            ],
            [
                'id' => 5,
                'name' => 'Sasa',
                'leaves' => [1, 7],
            ],
            [
                'id' => 6,
                'name' => 'Alvin',
                'leaves' => [8, 28],
            ],
            [
                'id' => 7,
                'name' => 'Eric',
                'leaves' => [9, 25, 28],
            ],
            [
                'id' => 8,
                'name' => 'Daisy',
                'leaves' => [10, 24],
            ],
        ];

        $prevMonth = $date->copy()->subMonth();
        $nextMonth = $date->copy()->addMonth();
    @endphp



    <div class="container-fluid">
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-dark">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <h2 class="page-title mb-4">Off Day Schedule</h2>

        <div class="schedule-card">
            <div class="schedule-toolbar">
                <div>
                    <button class="btn btn-light border">This month</button>
                </div>

                <div class="month-nav">
                    <a href="{{ request()->fullUrlWithQuery(['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
                        class="btn btn-light border">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    <div class="month-label">
                        {{ $date->format('F Y') }}
                    </div>

                    <a href="{{ request()->fullUrlWithQuery(['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
                        class="btn btn-light border">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="d-flex gap-2">
                    <select class="form-select" style="min-width: 150px;">
                        <option selected>Month</option>
                        <option>Week</option>
                    </select>

                    <button class="btn btn-outline-secondary">Request</button>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-danger" id="cancelSelectionBtn">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveSelectionBtn">Save</button>
                </div>
            </div>

            <div class="bulk-action-bar">
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-success btn-sm" id="markSelectedLeave">
                        Mark Selected as Leave
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-sm" id="unmarkSelectedLeave">
                        Remove Leave
                    </button>
                </div>

                <div class="selected-count">
                    Selected cells: <span id="selectedCount">0</span>
                </div>
            </div>

            <form id="bulkLeaveForm">
                <div class="table-wrap">
                    <table class="table leave-table">
                        <thead>
                            <tr>
                                <th class="staff-col">Staff</th>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $current = Carbon::createFromDate($year, $month, $day);
                                    @endphp
                                    <th class="day-head">
                                        <div class="day-number">{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</div>
                                        <div class="day-name">{{ $current->format('D') }}</div>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allStaff as $staff)
                                <tr>
                                    <td class="staff-col">
                                        {{ $staff->user->name ?? 'N/A' }}
                                    </td>

                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        @php
                                            $isLeave = collect($staff->leaves)->contains(function ($leave) use ($day) {
                                                return \Carbon\Carbon::parse(
                                                    $leave->leave_date ?? ($leave->date ?? null),
                                                )->day == $day;
                                            });
                                        @endphp

                                        <td class="check-cell">
                                            <input type="checkbox" class="leave-checkbox"
                                                data-staff="{{ $staff->user->id ?? $staff->user_id }}"
                                                data-day="{{ $day }}"
                                                name="leave[{{ $staff->user->id ?? $staff->user_id }}][]"
                                                value="{{ $day }}" {{ $isLeave ? 'checked' : '' }}>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="legend">
                <div><span class="legend-box legend-leave"></span>Checked = Leave / Off Day</div>
                <div><span class="legend-box legend-working"></span>Unchecked = Working Day</div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/leave.js', 'resources/css/leave.css'])
@endsection
