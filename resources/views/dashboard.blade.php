@extends('layouts.app')

@section('content')
    <h2>Dashboard</h2>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Bookings</h5>
                <h2>12</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <h5>Revenue</h5>
                <h2>$640</h2>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/dashboard.js'])
@endsection
