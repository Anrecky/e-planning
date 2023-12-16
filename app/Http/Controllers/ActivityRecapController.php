<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRecap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Supports\Disk;
use Illuminate\Support\Facades\Response;

class ActivityRecapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Rekap Kegiatan dan Upload Data Dukung";
        // Load ActivityRecap data with each Activity
        $activities = Activity::with('activityRecap')->sortedByCode()->get();

        return view('app.activity-recap', compact('title', 'activities'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $activityIDs = $request->input('activityIDs', []);
        $descriptions = $request->input('descriptions', []);
        $files = $request->file('files', []);

        foreach ($activityIDs as $index => $activityID) {
            $description = $descriptions[$index] ?? '';
            $file = $files[$index] ?? null;

            $activityRecap = ActivityRecap::firstOrNew(['activity_id' => $activityID]);

            $activityRecap->description = $description;

            if ($file) {
                $existingFiles = collect(Storage::disk(Disk::ActivityRecapAttachment)->files());

                $existingFile = $existingFiles->first(function ($filename) use ($file) {
                    return basename($filename) == $file->getClientOriginalName() &&
                        Storage::disk(Disk::ActivityRecapAttachment)->size($filename) == $file->getSize();
                });

                if (!$existingFile) {
                    if ($activityRecap->attachment_path) {
                        Storage::disk(Disk::ActivityRecapAttachment)->delete($activityRecap->attachment_path);
                    }

                    $filePath = $file->store('/', Disk::ActivityRecapAttachment);
                    $activityRecap->attachment_path = $filePath;
                }
            }

            $activityRecap->save();
        }

        return response()->json(['message' => 'Activity recaps processed successfully.']);
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


    public function showFile(ActivityRecap $activityRecap)
    {
        // $this->authorize('view', $activityRecap); // Optional: check if user is authorized to view

        $path = $activityRecap->attachment_path;
        $filePath = Storage::disk(Disk::ActivityRecapAttachment)->path($path);
        $fileMimeType = mime_content_type($filePath);

        return Response::file($filePath, [
            'Content-Type' => $fileMimeType
        ]);
    }
    // In your ActivityRecapController
    public function updateStatus(Request $request)
    {
        $activityId = $request->input('activity_id');
        $newStatus = $request->input('is_valid');

        $activityRecap = ActivityRecap::where('activity_id', $activityId)->first();
        if ($activityRecap) {
            $activityRecap->is_valid = $newStatus;
            $activityRecap->save();

            return response()->json(['message' => 'Status updated successfully']);
        }

        return response()->json(['message' => 'Activity Recap not found'], 404);
    }
}
