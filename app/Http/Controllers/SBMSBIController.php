<?php

namespace App\Http\Controllers;

use App\Models\SBMSBI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SBMSBIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbmsbi = SBMSBI::first();
        $title = 'SBM dan SBI';
        return view('app.sbm-sbi', compact('sbmsbi', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'sbm' => 'required|file|mimes:jpg,jpeg,png,pdf,xlsx,xls,doc,docx,csv|max:21048', // adjust mime types and max size as needed
            'sbi' => 'required|file|mimes:jpg,jpeg,png,pdf,xlsx,xls,doc,docx,csv|max:21048',
            'sbmsbi_id' => 'nullable|exists:sbmsbis,id' // Check if the ID exists in the SBMSBI table only if it's not null

        ]);

        // Store files and get their paths
        $sbmPath = $request->file('sbm')->store('sbm', 'public');
        $sbiPath = $request->file('sbi')->store('sbi', 'public');

        if ($request->has('sbmsbi_id') && isset($request->sbmsbi_id)) {
            $sbmsbi = SBMSBI::findOrFail($request->input('sbmsbi_id'));
            $sbmsbi->sbm_path = $sbmPath;
            $sbmsbi->sbi_path = $sbiPath;
            $sbmsbi->save();
        } else {
            // Create a new SBMSBI record
            $sbmsbi = new SBMSBI;
            $sbmsbi->sbm_path = $sbmPath;
            $sbmsbi->sbi_path = $sbiPath;
            $sbmsbi->save();
        }

        // Redirect or return response
        return back()->with('success', 'Berhasil upload SBM dan SBI.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SBM_SBI $sBM_SBI)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SBM_SBI $sBM_SBI)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SBM_SBI $sBM_SBI)
    {
        //
    }
}
