<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TemplateSummaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Settings Routes
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('settings/database-status', [SettingsController::class, 'checkDatabase'])->name('settings.database-status');

// Template Report Routes (New simplified system)
Route::get('template-summary', [TemplateSummaryController::class, 'index'])->name('template-summary.index');
Route::get('template-summary/drafts', [TemplateSummaryController::class, 'drafts'])->name('template-summary.drafts');
Route::get('template-summary/sirup', [TemplateSummaryController::class, 'sirupEditor'])->name('template-summary.sirup');
Route::delete('template-summary/drafts/{draft}', [TemplateSummaryController::class, 'deleteDraft'])->name('template-summary.drafts.delete');
Route::post('template-summary/sirup/draft', [TemplateSummaryController::class, 'saveSirupDraft'])->name('template-summary.sirup.draft');
Route::post('template-summary/sirup/export', [TemplateSummaryController::class, 'exportSirup'])->name('template-summary.sirup.export');
Route::post('template-summary/parse-excel', [TemplateSummaryController::class, 'parseExcel'])->name('template-summary.parse-excel');
Route::get('template-summary/tablet', [TemplateSummaryController::class, 'tabletEditor'])->name('template-summary.tablet');
Route::post('template-summary/tablet/draft', [TemplateSummaryController::class, 'saveTabletDraft'])->name('template-summary.tablet.draft');
Route::post('template-summary/tablet/export', [TemplateSummaryController::class, 'exportTablet'])->name('template-summary.tablet.export');
Route::get('template-summary/kapsul', [TemplateSummaryController::class, 'kapsulEditor'])->name('template-summary.kapsul');
Route::post('template-summary/kapsul/draft', [TemplateSummaryController::class, 'saveKapsulDraft'])->name('template-summary.kapsul.draft');
Route::post('template-summary/kapsul/export', [TemplateSummaryController::class, 'exportKapsul'])->name('template-summary.kapsul.export');
Route::get('/template-summary/continue/{draft}', [TemplateSummaryController::class, 'continueDraft'])->name('template-summary.continue');
