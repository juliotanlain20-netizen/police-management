<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.user-roles.index', compact(['users']));
    }
    public function edit($userId)
    {
        $user = User::with(['roles', 'officer'])->findOrFail($userId);
        $roles = Role::all();
        return view('admin.user-roles.edit', compact(['user', 'roles']));
    }
    public function update(Request $request, $userId)
    {
        $data = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id']
        ]);

        $user = User::with(['roles', 'officer'])->findOrFail($userId);
        $requestedRoleIds = $data['roles'] ?? [];
        $policeRole = Role::where('name', 'police')->firstOrFail();
        $citizenRole = Role::where('name', 'citizen')->firstOrFail();
        $supervisorRole = Role::where('name', 'investigation_supervisor')->firstOrFail();
        $wantPolice = in_array($policeRole->id, $requestedRoleIds);
        $wantSupervisor = in_array($supervisorRole->id, $requestedRoleIds);

        //kalau tammbah role investigation role atau officer tapi belum jadi officer
        //maka di arahkan ke halaman create police
        if (!$user->officer && ($wantSupervisor || $wantPolice)) {
            return back() //kembai ke halaman edit
                ->withInput() //bawa semua data yang tadi kita isi
                ->with('needs_officer', true)
                ->with('officer_user_id', $user->id);
        }
        //ini yang menambahkan otomatis role police kalau memang sudah police
        //dan hapus citizen otomatis
        if ($user->officer) {
            if (!in_array($policeRole->id, $requestedRoleIds)) {
                $requestedRoleIds[] = $policeRole->id;
            }
            $requestedRoleIds = array_values(array_filter(
                $requestedRoleIds,
                fn($roleId) => $roleId != $citizenRole->id
            ));
        }
        if ($user->status === 'active' && empty($requestedRoleIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'roles' => 'User aktif harus memiliki minimal satu role.'
                ]);
        }
        $user->roles()->sync($requestedRoleIds);
        return redirect()->route('user-role.index')->with('success', 'Role user berhasil diperbarui');
    }
}
