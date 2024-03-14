<?php

namespace App\Http\Controllers;

use App\Models\Treasurer;
use Illuminate\Http\Request;

class TreasurerController extends Controller
{
    public function index()
    {
        $title = 'Bendahara';
        $treasurers = Treasurer::all();

        return view('app.treasurer', compact('title', 'treasurers'));
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
            'treasurer_name.*' => 'required|string|max:255',
            'treasurer_nik.*' => 'required|integer',
            'treasurer_position.*' => 'required|string|max:255',
        ]);

        try {
            foreach ($validatedData['treasurer_name'] as $index => $name) {
                Treasurer::create([
                    'name' => $name,
                    'nik' => $validatedData['treasurer_nik'][$index],
                    'position' => $validatedData['treasurer_position'][$index],
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data Bendahara.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treasurer $treasurer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treasurer $treasurer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treasurer $treasurer)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'nik' => 'required|integer',
            'position' => 'required|string|max:255',
        ]);

        try {
            $treasurer->update($validatedData);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mengupdate data Bendahara.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treasurer $treasurer)
    {
        try {
            $treasurer->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data bendahara berhasil dihapus.');
    }

    public function getTreasurers(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $query = Treasurer::query();

        if (! empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%")
                ->orWhere('position', 'LIKE', "%{$search}%");
        }

        $treasurers = $query->limit($limit)->get(['id', 'name', 'position', 'nik']);

        return response()->json($treasurers);
    }
}
