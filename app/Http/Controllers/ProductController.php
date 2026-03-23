<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductInterface;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = $this->productRepository->getAll();

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('branch', function ($product) {
                    return $product->branch?->name ?? '-';
                })
                ->addColumn('category', function ($product) {
                    return $product->category?->name ?? '-';
                })
                ->addColumn('selling_price_formatted', function ($product) {
                    return number_format($product->selling_price, 2);
                })
                ->addColumn('cost_price_formatted', function ($product) {
                    return $product->cost_price !== null
                        ? number_format($product->cost_price, 2)
                        : '-';
                })
                ->addColumn('commission', function ($product) {
                    return $product->commission_type === 'percentage'
                        ? $product->commission_value . '%'
                        : number_format($product->commission_value, 2);
                })
                ->addColumn('status_badge', function ($product) {
                    return $product->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($product) {
                    $buttons = '';
                    $buttons .= '<button class="btn btn-sm btn-warning editBtn me-1" data-id="' . $product->id . '">Edit</button>';
                    $buttons .= '<button class="btn btn-sm btn-danger deleteBtn" data-id="' . $product->id . '">Delete</button>';

                    return $buttons;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $branches = Branch::select('id', 'name')->orderBy('name')->get();
        $categories = ProductCategory::select('id', 'name', 'branch_id')->orderBy('name')->get();

        return view('products.index', compact('branches', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $this->productRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
        ]);
    }

    public function edit(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'branch_id' => $product->branch_id,
            'product_category_id' => $product->product_category_id,
            'name' => $product->name,
            'sku' => $product->sku,
            'description' => $product->description,
            'selling_price' => $product->selling_price,
            'cost_price' => $product->cost_price,
            'stock_qty' => $product->stock_qty,
            'commission_type' => $product->commission_type,
            'commission_value' => $product->commission_value,
            'status' => $product->status,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($product, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
        ]);
    }

    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ]);
    }
}
