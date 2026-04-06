@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-dark">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <h2 class="page-title mb-4">Settings</h2>

    <div class="settings-card">

        <div class="setting-item mb-4">
            <div class="setting-content">
                <h5>Basic Settings</h5>

                <div class="d-flex gap-3 flex-wrap">

                    <div class="sub-setting-card">
                        <h6>Common Data</h6>
                        <a href="#" class="btn btn-sm btn-outline-primary">Open</a>
                    </div>

                    <div class="sub-setting-card">
                        <h6>Business Details</h6>
                        <a href="#" class="btn btn-sm btn-outline-primary">Open</a>
                    </div>

                </div>
            </div>
        </div>


        </div>
    </div>
</div>
@endsection