@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;

        $month = request('month', now()->month);
        $year = request('year', now()->year);

        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

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
            <div class="schedule-toolbar d-flex align-items-center">
                <div class="flex-fill"></div>

                <div class="month-nav d-flex justify-content-center align-items-center gap-2 flex-fill">
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

                <div class="d-flex justify-content-end flex-fill">
                    <button type="button" class="btn btn-primary" id="saveSelectionBtn">Save</button>
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
