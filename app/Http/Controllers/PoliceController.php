<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoliceRequest;
use App\Models\PoliceOfficer;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PoliceController extends Controller
{
    public function index(Request $request)
    {
        $query = PoliceOfficer::with([
            'user',
            'rank',
            'unit'
        ]);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($query) use ($search) {
                $query->where('nrp', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('rank', function ($rankQuery) use ($search) {
                        $rankQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('unit', function ($unitQuery) use ($search) {
                        $unitQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $police = $query->get();

        return view('police.index', compact('police'));
    }
    public function show($id)
    {
        $police = PoliceOfficer::with(['user', 'rank', 'unit'])->findOrFail($id);
        return view('police.show', compact('police'));
    }
    //dari sini semua tugas admin
    public function create()
    {
        $users = User::whereDoesntHave('officer')->with('roles')->get();
        $ranks = Rank::all();
        $units = Unit::all();
        return view('police.create', compact(['users', 'ranks', 'units']));
    }
    public function store(PoliceRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $targetUser = User::findOrFail($data['user_id']);
            $citizenRole = Role::where('name', 'citizen')->firstOrFail();
            $targetUser->roles()->detach($citizenRole->id);
            $policeRole = Role::where('name', 'police')->firstOrFail();
            $targetUser->roles()->syncWithoutDetaching([
                $policeRole->id
            ]);

            PoliceOfficer::create([
                'user_id' => $data['user_id'],
                'rank_id' => $data['rank_id'],
                'unit_id' => $data['unit_id'],
                'nrp' => $data['nrp'],
                'address' => $data['address'] ?? null,
                'status' => 'Active',
            ]);
        });
        return redirect()->route('police.index')->with('success', 'Police Officer berhasil di buat');
    }
    public function update(PoliceRequest $request, $id)
    {
        $data = $request->validated();
        $police = PoliceOfficer::findOrFail($id);
        $police->update([
            'unit_id' => $data['unit_id'],
            'rank_id' => $data['rank_id'],
            'nrp' => $data['nrp'],
            'address' => $data['address'] ?? null,
            'status' => $data['status'],
        ]);
        return redirect()->route('police.show', $police->id)->with('success', 'Police Officer berhasil di update');
    }
    public function edit($id)
    {
        $ranks = Rank::all();
        $units = Unit::all();
        $police = PoliceOfficer::findOrFail($id);
        return view('police.edit', compact(['police', 'ranks', 'units']));
    }
}
