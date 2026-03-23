<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCategoryRequest;
use App\Interfaces\ServiceCategoryInterface;
use App\Models\Branch;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ServiceCategoryController extends Controller
{
    protected ServiceCategoryInterface $serviceCategoryRepository;

    public function __construct(ServiceCategoryInterface $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = $this->serviceCategoryRepository->getAll();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('branch', function ($category) {
                    return $category->branch?->name ?? '-';
                })
                ->addColumn('status_badge', function ($category) {
                    return $category->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($category) {
                    $buttons = '';

                    $buttons .= '<button class="btn btn-sm btn-warning editBtn me-1" data-id="' . $category->id . '">Edit</button>';
                    $buttons .= '<button class="btn btn-sm btn-danger deleteBtn" data-id="' . $category->id . '">Delete</button>';

                    return $buttons ?: '-';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $branches = Branch::all();

        return view('service_categories.index', compact('branches'));
    }

    public function store(ServiceCategoryRequest $request)
    {
        $this->serviceCategoryRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service category created successfully.',
        ]);
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        $serviceCategory->load('branch');

        return response()->json($serviceCategory);
    }

    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        $this->serviceCategoryRepository->update($serviceCategory, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service category updated successfully.',
        ]);
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $this->serviceCategoryRepository->delete($serviceCategory);

        return response()->json([
            'success' => true,
            'message' => 'Service category deleted successfully.',
        ]);
    }
}
