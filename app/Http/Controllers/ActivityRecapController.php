<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRecap;
use Illuminate\Http\Request;

class ActivityRecapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Rekap Kegiatan dan Upload Data Dukung";
        $activities = Activity::sortedByCode()->get();;

        return view('app.activity-recap', compact('title', 'activities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityRecap $activityRecap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityRecap $activityRecap)
    {
        //
    }
}
