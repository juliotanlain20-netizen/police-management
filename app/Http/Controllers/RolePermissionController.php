<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.role-permissions.index', compact('roles'));
    }
    public function edit($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $permissions = Permission::all();
        return view('admin.role-permissions.edit', compact(['role', 'permissions']));
    }
    public function update(Request $request, $roleId)
    {
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id']
        ]);
        $role = Role::findOrFail($roleId);
        $requestedPermissionIds = $data['permissions'] ?? [];
        $role->permissions()->sync($requestedPermissionIds);
        return redirect()
            ->route('role-permission.index')
            ->with('success', 'Permission role berhasil diperbarui.');
    }
}
