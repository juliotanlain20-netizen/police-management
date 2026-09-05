<?php

namespace App\Http\Controllers;

use App\Models\InvestigationCase;

abstract class Controller
{
    protected function ensureAssignedToCase(
        $user,
        InvestigationCase $case
    ): void {
        $isAdmin = $user->roles()
            ->where('roles.name', 'admin')
            ->exists();

        if ($isAdmin) {
            return;
        }

        $officer = $user->officer;

        if (!$officer) {
            abort(403, 'User bukan Police Officer');
        }

        $assigned = $case->officers()
            ->where('police_officers.id', $officer->id)
            ->wherePivot('status', 'Active')
            ->exists();

        if (!$assigned) {
            abort(
                403,
                'Hanya officer yang ditugaskan pada case ini yang dapat melakukan aksi ini'
            );
        }
    }
}
