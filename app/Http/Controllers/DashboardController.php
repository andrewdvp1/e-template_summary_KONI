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
        // Map draft types to production groups
        $pharma1aTypes = ['kapsul', 'nutracare'];
        $pharma1bTypes = ['tablet'];
        $pharma2Types  = ['sirup', 'siladex', 'konvermex', 'heltiskin'];
        $naturalTypes  = ['nutracare_natural']; // placeholder for future

        $draftCounts = [
            'total'    => TemplateSummaryDraft::count(),
            'pharma1a' => TemplateSummaryDraft::whereIn('draft_type', $pharma1aTypes)->count(),
            'pharma1b' => TemplateSummaryDraft::whereIn('draft_type', $pharma1bTypes)->count(),
            'pharma2'  => TemplateSummaryDraft::whereIn('draft_type', $pharma2Types)->count(),
            'natural'  => TemplateSummaryDraft::whereIn('draft_type', $naturalTypes)->count(),
        ];

        $recentDrafts = TemplateSummaryDraft::query()
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'breadcrumb'  => ['Dashboard' => null],
            'title'       => 'Dashboard',
            'draftCounts' => $draftCounts,
            'recentDrafts' => $recentDrafts,
        ]);
    }
}
