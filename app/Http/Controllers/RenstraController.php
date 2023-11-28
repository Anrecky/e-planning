<?php

namespace App\Http\Controllers;

use App\Models\Renstra;
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
        $renstra = Renstra::first();
        return view('app.mission', ['title' => 'Misi', 'renstra' => $renstra]);
    }
    public function storeMission(Request $request)
    {
        $validatedData = $request->validate([
            'mission.*' => 'required|string|max:255' // Validate each mission input
        ]);

        $renstra = Renstra::first();
        // If there are existing missions, append the new ones; otherwise, set them directly
        if (is_array($renstra->mission)) {
            $renstra->mission = array_merge($renstra->mission, $validatedData['mission']);
        } else {
            $renstra->mission = $validatedData['mission'];
        }

        $renstra->save();

        return redirect()->route('mission.index')->with('success', 'Berhasil menambahkan misi.');
    }
    // Add this method to your RenstraController

    public function deleteMission(Request $request)
    {
        $index = $request->index; // Get the index of the mission to delete

        $renstra = Renstra::first();
        if ($renstra) {
            $missions = $renstra->mission;
            if (is_array($missions) && isset($missions[$index])) {
                unset($missions[$index]); // Remove the mission
                $renstra->mission = array_values($missions); // Reindex the array
                $renstra->save();
            }
        }

        return response()->json(['success' => 'Berhasil menghapus misi.']);
    }

    public function iku()
    {
        $renstra = Renstra::first();
        return view('app.iku', ['title' => 'Indikator Kinerja Utama', 'renstra' => $renstra]);
    }
    public function storeIku(Request $request)
    {
        $validatedData = $request->validate([
            'iku.*' => 'required|string|max:255' // Validate each iku input
        ]);

        $renstra = Renstra::first();
        // If there are existing iku, append the new ones; otherwise, set them directly
        if (is_array($renstra->iku)) {
            $renstra->iku = array_merge($renstra->iku, $validatedData['iku']);
        } else {
            $renstra->iku = $validatedData['iku'];
        }

        $renstra->save();

        return redirect()->route('iku.index')->with('success', 'IKU berhasil ditambahkan.');
    }
    // Add this method to your RenstraController

    public function deleteIku(Request $request)
    {
        $index = $request->index; // Get the index of the mission to delete

        $renstra = Renstra::first();
        if ($renstra) {
            $iku = $renstra->iku;
            if (is_array($iku) && isset($iku[$index])) {
                unset($iku[$index]); // Remove the iku
                $renstra->iku = array_values($iku); // Reindex the array
                $renstra->save();
            }
        }

        return response()->json(['success' => 'Mission deleted successfully.']);
    }
}
