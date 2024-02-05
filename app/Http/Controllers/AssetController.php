<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Aset';
        $assets = Asset::with('assetItem:id,category,name')->get();
        return view('app.assets', compact('title', 'assets'));
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
            'asset_item' => 'required|integer|exists:asset_items,id',
            'brand' => 'nullable|string',
            'year_acquisition' => 'required|digits:4|integer|min:1998|max:2036',
            'code' => 'unique:App\Models\Asset,code|string|required',
            'condition' => 'string|required|in:good,slightly,heavy',
            'description' => 'nullable|string'
        ]);


        try {
            // Create a new Asset
            Asset::create([
                'asset_item_id' => $validatedData['asset_item'],
                'brand' => $validatedData['brand'],
                'year_acquisition' => $validatedData['year_acquisition'],
                'code' => $validatedData['code'],
                'condition' => $validatedData['condition'],
                'description' => $validatedData['description'] ?? ''
            ]);
            return redirect()->back()->with('success', 'Berhasil menambahkan aset.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        try {
            return response()->json($asset->load('assetItem:id,category'));
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validatedData = $this->validate($request, [
            'asset_item' => 'required|integer|exists:asset_items,id',
            'brand' => 'nullable|string',
            'year_acquisition' => 'required|digits:4|integer|min:1998|max:2036',
            'code' => "unique:App\Models\Asset,code," . $asset->id . ",code|string|required",
            'condition' => 'string|required|in:good,slightly,heavy',
            'description' => 'sometimes|nullable|string'
        ]);

        try {
            $asset->brand = $validatedData['brand'];
            $asset->year_acquisition = $validatedData['year_acquisition'];
            $asset->code = $validatedData['code'];
            $asset->condition = $validatedData['condition'];
            $asset->description = $validatedData['description'];
            $asset->assetItem()->associate($validatedData['asset_item']);
            $asset->save();
            return back()->with('success', 'Data aset berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }


        // $asset->fill($validatedData);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->back()->with('success', 'Aset berhasil dihapus.');
    }
}
