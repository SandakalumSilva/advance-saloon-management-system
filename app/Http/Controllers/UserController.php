<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

use App\Interfaces\UserInterface;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->userRepository->getQuery();
            // Log::info($query);
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('branch', function (User $user) {
                    return $user->branch?->name ?? '-';
                })
                ->addColumn('role', function (User $user) {
                    return $user->roles->pluck('name')->join(', ');
                })
                ->addColumn('status_badge', function (User $user) {
                    return $user->staff?->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->editColumn('created_at', function (User $user) {
                    return $user->created_at?->format('Y-m-d');
                })
                ->addColumn('action', function (User $user) {
                    return '
                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="' . $user->id . '">
                        Edit
                    </button>

                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="' . $user->id . '">
                        Delete
                    </button>
                ';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $roles = Role::all();
        $branches = Branch::all();

        return view('users.index', compact('roles', 'branches'));
    }

    public function store(UserRequest $request)
    {
        $this->userRepository->create($request->all());

        return response()->json(['success' => true]);
    }

    public function edit(User $user)
    {
        $user->load('roles', 'branch','staff');
        
        return response()->json($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->userRepository->update($user, $request->validated());

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(User $user)
    {
        $this->userRepository->delete($user);

        return response()->json([
            'success' => true
        ]);
    }
}
