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
Route::delete('template-summary/drafts/{draft}', [TemplateSummaryController::class, 'deleteDraft'])->name('template-summary.drafts.delete');
Route::get('/template-summary/continue/{draft}', [TemplateSummaryController::class, 'continueDraft'])->name('template-summary.continue');
Route::post('template-summary/parse-excel', [TemplateSummaryController::class, 'parseExcel'])->name('template-summary.parse-excel');

// Anakonidin 30ml Routes
Route::get('template-summary/anakonidin30', [TemplateSummaryController::class, 'sirupEditor'])->name('template-summary.anakonidin30');
Route::post('template-summary/anakonidin30/draft', [TemplateSummaryController::class, 'saveAnakonidin30Draft'])->name('template-summary.anakonidin30.draft');
Route::post('template-summary/anakonidin30/export', [TemplateSummaryController::class, 'exportAnakonidin30'])->name('template-summary.anakonidin30.export');

// Legacy sirup routes (redirect to anakonidin30)
Route::get('template-summary/sirup', [TemplateSummaryController::class, 'sirupEditor'])->name('template-summary.sirup');
Route::post('template-summary/sirup/draft', [TemplateSummaryController::class, 'saveAnakonidin30Draft'])->name('template-summary.sirup.draft');
Route::post('template-summary/sirup/export', [TemplateSummaryController::class, 'exportAnakonidin30'])->name('template-summary.sirup.export');
// Tablet Routes
Route::get('template-summary/tablet', [TemplateSummaryController::class, 'tabletEditor'])->name('template-summary.tablet');
Route::post('template-summary/tablet/draft', [TemplateSummaryController::class, 'saveTabletDraft'])->name('template-summary.tablet.draft');
Route::post('template-summary/tablet/export', [TemplateSummaryController::class, 'exportTablet'])->name('template-summary.tablet.export');

// Kapsul Routes
Route::get('template-summary/kapsul', [TemplateSummaryController::class, 'kapsulEditor'])->name('template-summary.kapsul');
Route::post('template-summary/kapsul/draft', [TemplateSummaryController::class, 'saveKapsulDraft'])->name('template-summary.kapsul.draft');
Route::post('template-summary/kapsul/export', [TemplateSummaryController::class, 'exportKapsul'])->name('template-summary.kapsul.export');

// Heltiskin Routes
Route::get('template-summary/heltiskin', [TemplateSummaryController::class, 'heltiskinEditor'])->name('template-summary.heltiskin');
Route::post('template-summary/heltiskin/draft', [TemplateSummaryController::class, 'saveHeltiskinDraft'])->name('template-summary.heltiskin.draft');
Route::post('template-summary/heltiskin/export', [TemplateSummaryController::class, 'exportHeltiskin'])->name('template-summary.heltiskin.export');

// Konvermex Routes
Route::get('template-summary/konvermex', [TemplateSummaryController::class, 'konvermexEditor'])->name('template-summary.konvermex');
Route::post('template-summary/konvermex/draft', [TemplateSummaryController::class, 'saveKonvermexDraft'])->name('template-summary.konvermex.draft');
Route::post('template-summary/konvermex/export', [TemplateSummaryController::class, 'exportKonvermex'])->name('template-summary.konvermex.export');

// Nutracare Routes
Route::get('template-summary/nutracare', [TemplateSummaryController::class, 'nutracareEditor'])->name('template-summary.nutracare');
Route::post('template-summary/nutracare/draft', [TemplateSummaryController::class, 'saveNutracareDraft'])->name('template-summary.nutracare.draft');
Route::post('template-summary/nutracare/export', [TemplateSummaryController::class, 'exportNutracare'])->name('template-summary.nutracare.export');

// Siladex Routes
Route::get('template-summary/siladex', [TemplateSummaryController::class, 'siladexEditor'])->name('template-summary.siladex');
Route::post('template-summary/siladex/draft', [TemplateSummaryController::class, 'saveSiladexDraft'])->name('template-summary.siladex.draft');
Route::post('template-summary/siladex/export', [TemplateSummaryController::class, 'exportSiladex'])->name('template-summary.siladex.export');

// Konidin OBH Routes
Route::get('template-summary/konidinobh', [TemplateSummaryController::class, 'konidinobhEditor'])->name('template-summary.konidinobh');
Route::post('template-summary/konidinobh/draft', [TemplateSummaryController::class, 'saveKonidinOBHDraft'])->name('template-summary.konidinobh.draft');
Route::post('template-summary/konidinobh/export', [TemplateSummaryController::class, 'exportKonidinOBH'])->name('template-summary.konidinobh.export');

// Anakonidin 60ml Routes
Route::get('template-summary/anakonidin60', [TemplateSummaryController::class, 'Anakonidin60Editor'])->name('template-summary.anakonidin60');
Route::post('template-summary/anakonidin60/draft', [TemplateSummaryController::class, 'saveAnakonidin60Draft'])->name('template-summary.anakonidin60.draft');
Route::post('template-summary/anakonidin60/export', [TemplateSummaryController::class, 'exportAnakonidin60'])->name('template-summary.anakonidin60.export');