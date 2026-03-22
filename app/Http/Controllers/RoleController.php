<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index(Request $request)
    {
        // If AJAX (DataTable)
        if ($request->ajax()) {
            return response()->json(Role::select('id', 'name')->get());
        }

        return view('roles.index');
    }

    /**
     * Show form to create role
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store new role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated');
    }

    /**
     * Delete role
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted'
        ]);
    }

    /**
     * Show permission assignment UI
     */
    public function permissions(Role $role)
    {
        $permissions = Permission::all();

        return view('roles.permissions', compact('role', 'permissions'));
    }

    /**
     * Update permissions for role
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('roles.permissions', $role->id)
            ->with('success', 'Permissions updated successfully');
    }
}
