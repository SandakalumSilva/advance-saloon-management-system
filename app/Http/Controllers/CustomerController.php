<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected CustomerRepositoryInterface $customerRepository;
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->customerRepository->getQuery();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('full_name', function (Customer $customer) {
                    return trim($customer->first_name . ' ' . $customer->last_name);
                })
                ->addColumn('status_badge', function (Customer $customer) {
                    return $customer->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->editColumn('created_at', function (Customer $customer) {
                    return $customer->created_at?->format('Y-m-d');
                })
                ->addColumn('action', function (Customer $customer) {
                    return '
        <button type="button" class="btn btn-sm btn-primary editBtn" data-id="' . $customer->id . '">
            Edit
        </button>

        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="' . $customer->id . '">
            Delete
        </button>
    ';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('customers.index');
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $customer = $this->customerRepository->create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ]);
    }

    public function edit(Customer $customer)
    {
        return response()->json([
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'date_of_birth' => $customer->date_of_birth ? $customer->date_of_birth->format('Y-m-d') : null,
            'gender' => $customer->gender,
            'address' => $customer->address,
            'notes' => $customer->notes,
            'status' => $customer->status,
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $this->customerRepository->update($customer, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully.',
        ]);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        if ($customer->customer_code === 'CUST-000001') {
            return response()->json([
                'status' => false,
                'message' => 'Default walk-in customer cannot be deleted.',
            ], 422);
        }

        $this->customerRepository->delete($customer);

        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
