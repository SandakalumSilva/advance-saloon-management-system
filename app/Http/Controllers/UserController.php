<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

use App\Interfaces\UserInterface;
use App\Models\Branch;
use App\Models\User;
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
            $users = $this->userRepository->getAll();

            return DataTables::of($users)
                ->addColumn('branch', function ($user) {
                    return $user->branch ? $user->branch->name : '-';
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->pluck('name')->join(', ');
                })
                ->addColumn('action', function ($user) {
                    return '
                        <button class="btn btn-sm btn-warning editBtn" data-id="' . $user->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $user->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
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
        $user->load('roles','branch');
        return response()->json($user);
    }

    public function update(UserRequest $request, $id)
    {
        $this->userRepository->update($id, $request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return response()->json(['success' => true]);
    }
}
