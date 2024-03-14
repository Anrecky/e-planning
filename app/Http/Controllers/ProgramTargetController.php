<?php

namespace App\Http\Controllers;

use App\Models\ProgramTarget;
use Illuminate\Http\Request;

class ProgramTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programTargets = ProgramTarget::all();

        return view('app.program-target', ['title' => 'Sasaran Program', 'programTargets' => $programTargets]);
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
        // Validate the request
        $request->validate([
            'program_target.*' => 'required|string|max:255', // Validate each program target
        ]);

        // Loop through the program targets and save each one
        foreach ($request->program_target as $target) {
            ProgramTarget::create(['name' => $target]);
        }

        // Redirect to a specific route with a success message
        return redirect()->route('program_target.index')->with('success', 'Sasaran Program berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramTarget $programTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramTarget $programTarget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramTarget $programTarget)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $programTarget->update(['name' => $request->name]);

        return redirect()->route('program_target.index')->with('success', 'Sasaran Program berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramTarget $programTarget)
    {
        // Delete the ProgramTarget instance
        $programTarget->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Sasaran Program berhasil dihapus.');
    }

    public function getProgramTargets(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $query = ProgramTarget::query();

        if (! empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $programTargets = $query->limit($limit)->get(['id', 'name']);

        return response()->json($programTargets);
    }
}
