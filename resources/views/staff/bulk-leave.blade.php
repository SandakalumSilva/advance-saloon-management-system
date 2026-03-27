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

<style>
    .page-title {
        font-size: 2rem;
        font-weight: 700;
    }

    .schedule-card {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
    }

    .schedule-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .month-nav {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .month-label {
        font-size: 1.5rem;
        font-weight: 600;
        min-width: 180px;
        text-align: center;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #dee2e6;
        background: #fff;
    }

    .leave-table {
        min-width: 1400px;
        margin-bottom: 0;
        vertical-align: middle;
        text-align: center;
    }

    .leave-table th,
    .leave-table td {
        border: 1px solid #dee2e6;
        padding: 8px;
        white-space: nowrap;
    }

    .leave-table thead th {
        background: #f1f3f5;
        font-weight: 700;
    }

    .staff-col {
        min-width: 140px;
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 2;
        text-align: left !important;
        font-weight: 600;
    }

    .leave-table thead .staff-col {
        background: #f1f3f5;
        z-index: 3;
        text-align: center !important;
    }

    .day-head {
        min-width: 58px;
    }

    .day-number {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .day-name {
        font-size: 0.85rem;
        color: #444;
    }

    .bulk-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .selected-count {
        font-weight: 600;
        color: #0d6efd;
    }

    .check-cell input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .legend {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        margin-top: 14px;
        font-size: 14px;
    }

    .legend-box {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 3px;
        margin-right: 6px;
        vertical-align: middle;
    }

    .legend-leave {
        background: #0d6efd;
    }

    .legend-working {
        background: #ffffff;
        border: 1px solid #999;
    }
</style>

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
                            @for($day = 1; $day <= $daysInMonth; $day++)
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
                        @foreach($staffList as $staff)
                            <tr>
                                <td class="staff-col">{{ $staff['name'] }}</td>

                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $isLeave = in_array($day, $staff['leaves']);
                                    @endphp
                                    <td class="check-cell">
                                        <input
                                            type="checkbox"
                                            class="leave-checkbox"
                                            data-staff="{{ $staff['id'] }}"
                                            data-day="{{ $day }}"
                                            name="leave[{{ $staff['id'] }}][]"
                                            value="{{ $day }}"
                                            {{ $isLeave ? 'checked' : '' }}
                                        >
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
<script>
    $(document).ready(function () {
        let selectedCells = [];

        function updateSelectedCount() {
            $('#selectedCount').text(selectedCells.length);
        }

        function clearTemporarySelection() {
            $('.leave-checkbox').removeClass('border border-danger');
            selectedCells = [];
            updateSelectedCount();
        }

        $('.leave-checkbox').on('click', function (e) {
            if (e.shiftKey) {
                e.preventDefault();

                const key = $(this).data('staff') + '_' + $(this).data('day');

                if (!selectedCells.includes(key)) {
                    selectedCells.push(key);
                    $(this).addClass('border border-danger');
                } else {
                    selectedCells = selectedCells.filter(item => item !== key);
                    $(this).removeClass('border border-danger');
                }

                updateSelectedCount();
            }
        });

        $('#markSelectedLeave').on('click', function () {
            selectedCells.forEach(function (item) {
                const parts = item.split('_');
                const staffId = parts[0];
                const day = parts[1];

                $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                    .prop('checked', true)
                    .removeClass('border border-danger');
            });

            clearTemporarySelection();
            notyf.success('Selected cells marked as leave');
        });

        $('#unmarkSelectedLeave').on('click', function () {
            selectedCells.forEach(function (item) {
                const parts = item.split('_');
                const staffId = parts[0];
                const day = parts[1];

                $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                    .prop('checked', false)
                    .removeClass('border border-danger');
            });

            clearTemporarySelection();
            notyf.success('Selected leave removed');
        });

        $('#cancelSelectionBtn').on('click', function () {
            clearTemporarySelection();
            notyf.success('Selection cleared');
        });

        $('#saveSelectionBtn').on('click', function () {
            let finalData = [];

            $('.leave-checkbox:checked').each(function () {
                finalData.push({
                    staff_id: $(this).data('staff'),
                    day: $(this).data('day')
                });
            });

            console.log(finalData);

            Swal.fire({
                icon: 'success',
                title: 'Demo Saved',
                text: 'Dummy bulk leave data prepared. Next step is connect AJAX / controller.'
            });
        });
    });
</script>
@endsection