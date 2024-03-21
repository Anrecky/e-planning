<?php

namespace App\Http\Controllers;

use App\Models\Renstra;
use App\Models\RenstraIndicator;
use App\Models\RenstraMission;
use Illuminate\Http\Request;

class RenstraController extends Controller
{
    public function vision()
    {
        $renstra = Renstra::first();

        return view('app.vision', ['title' => 'VISI', 'renstra' => $renstra]);
    }

    public function updateVision(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|max:255',
        ]);

        $renstra = Renstra::first();
        $renstra->vision = $validated['vision'];
        $renstra->save();

        return redirect()->route('vision.index')->with('success', 'Visi berhasil diperbarui.');
    }

    public function mission()
    {
        $renstra = Renstra::with('missions')->first();
        return view('app.mission', ['title' => 'Misi', 'renstra' => $renstra]);
    }

    public function storeMission(Request $request)
    {
        $validatedData = $request->validate([
            'mission.*' => 'required|string|max:255', // Validate each mission input
        ]);
        $renstra = Renstra::first();
        foreach ($validatedData['mission'] as $data)
            RenstraMission::create(['renstra_id' => $renstra->id, 'description' => $data]);

        return redirect()->route('mission.index')->with('success', 'Berhasil menambahkan misi.');
    }
    // Add this method to your RenstraController

    public function deleteMission(Request $request)
    {
        RenstraMission::find($request->id)->delete();
        return response()->json(['success' => 'Berhasil menghapus misi.']);
    }

    public function iku()
    {
        $renstra = Renstra::first();
        $missions = RenstraMission::get();
        $ikus = RenstraIndicator::with('mission')->get();
        // dd($ikus);

        return view('app.iku', ['title' => 'Indikator Kinerja Utama', 'renstra' => $renstra, 'missions' => $missions, 'ikus' => $ikus]);
    }

    public function storeIku(Request $request)
    {
        $validatedData = $request->validate([
            'iku.*' => 'required|string|max:255', // Validate each iku input
            'misi' => 'required|integer', // Validate each iku input
        ]);
        foreach ($validatedData['iku'] as $data)
            RenstraIndicator::create(['renstra_mission_id' => $validatedData['misi'], 'description' => $data]);
        return redirect()->route('iku.index')->with('success', 'IKU berhasil ditambahkan.');
    }
    // Add this method to your RenstraController

    public function deleteIku(Request $request)
    {

        RenstraIndicator::find($request->id)->delete();
        return response()->json(['success' => 'Berhasil menghapus indikator.']);
    }
}
