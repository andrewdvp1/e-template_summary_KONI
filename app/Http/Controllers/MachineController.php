<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MachineController extends Controller
{
    /**
     * List machine grouped by stage (tahap)
     */
    public function index(): View
    {
        $stages = Stage::query()
            ->orderBy('sort_order')
            ->get();

        // eager load machines per stage
        $stages->each(function (Stage $stage) {
            $stage->setRelation('machines', $stage->machines()
                ->orderBy('sort_order')
                ->get());
        });

        return view('listmachine', [
            'stages' => $stages,
        ]);
    }

    // ─── Stage CRUD ────────────────────────────────────────────────────────────

    public function storeStage(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $maxOrder = Stage::max('sort_order') ?? 0;

        Stage::create([
            'name'       => $validated['name'],
            'sort_order' => $maxOrder + 1,
        ]);

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type'    => 'success',
                'title'   => 'Berhasil',
                'message' => 'Tahapan berhasil ditambahkan.',
            ]);
    }

    public function updateStage(Request $request, Stage $stage)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $stage->update(['name' => $validated['name']]);

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type'    => 'success',
                'title'   => 'Berhasil',
                'message' => 'Tahap pengolahan berhasil diperbarui.',
            ]);
    }

    public function destroyStage(Stage $stage)
    {
        // hapus semua mesin dalam tahap ini dulu
        $stage->machines()->delete();
        $stage->delete();

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type'    => 'success',
                'title'   => 'Berhasil',
                'message' => 'Tahap pengolahan berhasil dihapus.',
            ]);
    }

    // ─── Machine CRUD ───────────────────────────────────────────────────────────

    public function store(Request $request, Stage $stage)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $machine = new Machine([
            'name' => $validated['name'],
        ]);

        $stage->machines()->save($machine);

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data mesin berhasil ditambahkan.',
            ]);
    }

    public function update(Request $request, Stage $stage, Machine $machine)
    {
        abort_unless($machine->stage_id === $stage->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $machine->update([
            'name' => $validated['name'],
        ]);

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Perubahan data mesin berhasil disimpan.',
            ]);
    }

    public function destroy(Request $request, Stage $stage, Machine $machine)
    {
        abort_unless($machine->stage_id === $stage->id, 404);

        $machine->delete();

        return Redirect::route('listmachine.index')
            ->with('toast', [
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data mesin berhasil dihapus.',
            ]);
    }
}

