<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Interfaces\ServiceInterface;
use App\Models\Branch;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    protected ServiceInterface $serviceRepository;

    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = $this->serviceRepository->getAll();

            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('branch', function ($service) {
                    return $service->branch?->name ?? '-';
                })
                ->addColumn('category', function ($service) {
                    return $service->category?->name ?? '-';
                })
                ->addColumn('price_formatted', function ($service) {
                    return number_format($service->price, 2);
                })
                ->addColumn('commission', function ($service) {
                    return $service->commission_type === 'percentage'
                        ? $service->commission_value . '%'
                        : number_format($service->commission_value, 2);
                })
                ->addColumn('status_badge', function ($service) {
                    return $service->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($service) {
                    $buttons = '';
                    $buttons .= '<button class="btn btn-sm btn-warning editBtn me-1" data-id="' . $service->id . '">Edit</button>';
                    $buttons .= '<button class="btn btn-sm btn-danger deleteBtn" data-id="' . $service->id . '">Delete</button>';

                    return $buttons;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $branches = Branch::select('id', 'name')->orderBy('name')->get();
        $categories = ServiceCategory::select('id', 'name', 'branch_id')->orderBy('name')->get();

        return view('services.index', compact('branches', 'categories'));
    }

    public function store(ServiceRequest $request)
    {
        $this->serviceRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully.',
        ]);
    }

    public function edit(Service $service)
    {
        return response()->json([
            'id' => $service->id,
            'branch_id' => $service->branch_id,
            'service_category_id' => $service->service_category_id,
            'name' => $service->name,
            'code' => $service->code,
            'description' => $service->description,
            'duration_minutes' => $service->duration_minutes,
            'price' => $service->price,
            'cost' => $service->cost,
            'commission_type' => $service->commission_type,
            'commission_value' => $service->commission_value,
            'status' => $service->status,
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $this->serviceRepository->update($service, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully.',
        ]);
    }

    public function destroy(Service $service)
    {
        $this->serviceRepository->delete($service);

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.',
        ]);
    }
}