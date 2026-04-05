<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Interfaces\ProductCategoryInterface;
use App\Models\Branch;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    protected ProductCategoryInterface $productCategoryRepository;

    public function __construct(ProductCategoryInterface $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = $this->productCategoryRepository->getAll();

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

        $branches = Branch::select('id', 'name')->orderBy('name')->get();

        return view('product_categories.index', compact('branches'));
    }

    public function store(ProductCategoryRequest $request)
    {
        $this->productCategoryRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product category created successfully.',
        ]);
    }

    public function edit(ProductCategory $productCategory)
    {
        return response()->json([
            'id' => $productCategory->id,
            'branch_id' => $productCategory->branch_id,
            'name' => $productCategory->name,
            'description' => $productCategory->description,
            'status' => $productCategory->status,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $this->productCategoryRepository->update($productCategory, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product category updated successfully.',
        ]);
    }

    public function destroy(ProductCategory $productCategory)
    {
        $this->productCategoryRepository->delete($productCategory);

        return response()->json([
            'success' => true,
            'message' => 'Product category deleted successfully.',
        ]);
    }
}
