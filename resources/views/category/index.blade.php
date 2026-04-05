@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Category Management</h4>
        <p class="text-muted mb-0">Choose which category section you want to manage.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('service-categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 category-card">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <h5 class="mb-2 text-dark">Service Categories</h5>
                            <p class="text-muted mb-0">Manage all salon service categories.</p>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="bi bi-scissors"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('product-categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 category-card">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <h5 class="mb-2 text-dark">Product Categories</h5>
                            <p class="text-muted mb-0">Manage all salon product categories.</p>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="bi bi-bag"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
