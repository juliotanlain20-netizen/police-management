<?php

namespace App\Http\Controllers;

use App\Models\InvestigationCase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CaseSummaryController extends Controller
{
    public function download($id)
    {
        $case = InvestigationCase::with([
            'complaint.category',
            'officers.user',
            'suspects',
            'evidences.category',
            'histories.user',
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'cases.summary-pdf',
            compact('case')
        );

        return $pdf->download(
            'case-summary-' . $case->case_number . '.pdf'
        );
    }
}
