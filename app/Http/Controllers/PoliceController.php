<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoliceRequest;
use App\Models\PoliceOfficer;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PoliceController extends Controller
{
    public function index()
    {
        $police = PoliceOfficer::all();
        return view('police.index', compact('police'));
    }
    public function show($id)
    {
        $police = PoliceOfficer::findOrFail($id);
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
        return redirect()->route('police.index');
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
        return redirect()->route('police.show', $police->id);
    }
    public function edit($id)
    {
        $ranks = Rank::all();
        $units = Unit::all();
        $police = PoliceOfficer::findOrFail($id);
        return view('police.edit', compact(['police', 'ranks', 'units']));
    }
}
