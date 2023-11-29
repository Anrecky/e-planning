<?php

namespace App\Http\Controllers;

use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Unit Kerja';
        $workUnits = WorkUnit::all();
        return view('app.work-unit', compact('title', 'workUnits'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkUnit $workUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkUnit $workUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkUnit $workUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkUnit $workUnit)
    {
        //
    }
}
