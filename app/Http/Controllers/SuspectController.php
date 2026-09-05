<?php

namespace App\Http\Controllers;

use App\Models\InvestigationCase;
use App\Models\Suspect;
use Illuminate\Http\Request;

class SuspectController extends Controller
{
    public function store(Request $request, $caseId)
    {
        $case = InvestigationCase::findOrFail($caseId);

        $this->ensureAssignedToCase(
            $request->user(),
            $case
        );
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'identity_number' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'status' => 'required|in:identified,wanted,detained,released',
            'notes' => 'nullable|string',
        ]);
        Suspect::create([
            'investigation_case_id' => $case->id,
            'name' => $data['name'],
            'address' => $data['address'],
            'identity_number' => $data['identity_number'] ?? null,
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);
        return redirect()->route('cases.show', $case->id)->with('success', 'Berhasil menambah suspect');
    }
    public function show($id)
    {
        $suspect = Suspect::with('case')->findOrFail($id);
        return view('suspect.show', compact('suspect'));
    }
    public function update(Request $request, $id)
    {
        $suspect = Suspect::with('case')->findOrFail($id);

        $this->ensureAssignedToCase(
            $request->user(),
            $suspect->case
        );
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'identity_number' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'status' => 'required|in:identified,wanted,detained,released',
            'notes' => 'nullable|string',
        ]);

        $suspect->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'identity_number' => $data['identity_number'] ?? null,
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);
        return redirect()->route('suspect.show', $suspect->id)->with('success', 'Suspect berhasil di update');
    }
    public function edit(Request $request, $id)
    {
        $suspect = Suspect::with('case')->findOrFail($id);
        $this->ensureAssignedToCase(
            $request->user(),
            $suspect->case
        );
        return view('suspect.edit', compact('suspect'));
    }
}
