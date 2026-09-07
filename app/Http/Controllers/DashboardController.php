<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Evidence;
use App\Models\InvestigationCase;
use App\Models\PoliceOfficer;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->roles()->where('roles.name', 'admin')->exists()) {

            $stats = [
                'users' => User::count(),

                'active_police' => PoliceOfficer::where('status', 'Active')
                    ->count(),

                'pending_complaints' => Complaint::where('status', 'Pending')
                    ->count(),

                'active_cases' => InvestigationCase::where('status', '!=', 'Closed')
                    ->count(),

                'evidences' => Evidence::count(),
            ];

            $recentCases = InvestigationCase::latest('opened_at')
                ->take(5)
                ->get();

            $pendingComplaints = Complaint::with('user')
                ->where('status', 'Pending')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'stats',
                'recentCases',
                'pendingComplaints'
            ));
        }

        if ($user->roles()->where('roles.name', 'police')->exists()) {

            $officer = $user->officer;

            if (!$officer) {
                abort(403, 'User Police tidak memiliki profile Police Officer');
            }

            $activeCases = InvestigationCase::whereHas('officers', function ($query) use ($officer) {
                $query->where('police_officers.id', $officer->id)
                    ->where('case_officers.status', 'Active');
            });

            $stats = [
                'pending_complaints' => Complaint::where('status', 'Pending')->count(),

                'active_cases' => (clone $activeCases)
                    ->where('status', '!=', 'Closed')
                    ->count(),

                'evidences' => Evidence::whereHas('investigationCase.officers', function ($query) use ($officer) {
                    $query->where('police_officers.id', $officer->id)
                        ->where('case_officers.status', 'Active');
                })->count(),

                'closed_this_month' => (clone $activeCases)
                    ->where('status', 'Closed')
                    ->whereMonth('closed_at', now()->month)
                    ->whereYear('closed_at', now()->year)
                    ->count(),
            ];

            $assignedCases = (clone $activeCases)
                ->where('status', '!=', 'Closed')
                ->orderByRaw("
            CASE
                WHEN priority = 'High' THEN 1
                WHEN priority = 'Medium' THEN 2
                WHEN priority = 'Low' THEN 3
                ELSE 4
            END
        ")
                ->latest('opened_at')
                ->take(5)
                ->get();

            $pendingComplaints = Complaint::with('user')
                ->where('status', 'Pending')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.police', compact(
                'stats',
                'assignedCases',
                'pendingComplaints'
            ));
        }

        $complaints = Complaint::where('user_id', $user->id);

        $stats = [
            'total' => (clone $complaints)->count(),
            'pending' => (clone $complaints)->where('status', 'Pending')->count(),
            'need_evidence' => (clone $complaints)->where('status', 'Need More Evidence')->count(),
            'approved' => (clone $complaints)->where('status', 'Approved')->count(),
            'rejected' => (clone $complaints)->where('status', 'Rejected')->count(),
        ];

        $recentComplaints = (clone $complaints)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.citizen', compact(
            'stats',
            'recentComplaints'
        ));
    }
}
