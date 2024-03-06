<?php

namespace App\Http\Controllers;

use App\Models\PPK;
use Illuminate\Http\Request;

class PPKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'PPK';
        $ppks = PPK::all();
        return view('app.ppk', compact('title', 'ppks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'ppk_name.*' => 'required|string|max:255',
            'ppk_nik.*' => 'required|integer',
            'ppk_position.*' => 'required|string|max:255',
        ]);

        try {
            foreach ($validatedData['ppk_name'] as $index => $name) {
                PPK::create([
                    'name' => $name,
                    'nik' => $validatedData['ppk_nik'][$index],
                    'position' => $validatedData['ppk_position'][$index],
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Berhasil menambahkan data PPK.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PPK $ppk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PPK $ppk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PPK $ppk)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'nik' => 'required|integer',
            'position' => 'required|string|max:255',
        ]);

        try {
            $ppk->update($validatedData);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Berhasil mengupdate data PPK.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PPK $ppk)
    {
        try {
            $ppk->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Data ppk berhasil dihapus.');
    }
    public function getPPKs(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $query = PPK::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%")
                ->orWhere('position', 'LIKE', "%{$search}%");
        }

        $ppks = $query->limit($limit)->get(['id', 'name', 'position', 'nik']);

        return response()->json($ppks);
    }
}
