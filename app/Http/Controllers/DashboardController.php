<?php

namespace App\Http\Controllers;

use App\Models\TemplateSummaryDraft;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        // Get counts for each type of draft
        $draftCounts = [
            'total' => TemplateSummaryDraft::count(),
            'sirup' => TemplateSummaryDraft::where('draft_type', 'sirup')->count(),
            'tablet' => TemplateSummaryDraft::where('draft_type', 'tablet')->count(),
            'kapsul' => TemplateSummaryDraft::where('draft_type', 'kapsul')->count(),
        ];

        // Get 5 most recent drafts of any type for quick resume
        $recentDrafts = TemplateSummaryDraft::query()
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'breadcrumb' => [
                'Dashboard' => null,
            ],
            'title' => 'Dashboard',
            'draftCounts' => $draftCounts,
            'recentDrafts' => $recentDrafts,
        ]);
    }
}
