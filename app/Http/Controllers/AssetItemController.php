<?php

namespace App\Http\Controllers;

use App\Models\AssetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AssetItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Barang Aset';
        $assetItems = AssetItem::all();

        return view('app.asset_item', compact('title', 'assetItems'));
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
            'asset_item_name.*' => 'required|string|max:255',
            'asset_item_category' => [
                'required',
                'array',
            ],
            'asset_item_category.*' => Rule::in(['IT', 'NonIT']),
            'asset_item_description.*' => 'nullable|string|max:255',
        ]);

        try {
            foreach ($validatedData['asset_item_name'] as $index => $name) {

                // Create a new AccountCode
                AssetItem::create([
                    'name' => $name,
                    'category' => $validatedData['asset_item_category'][$index],
                    'description' => ! empty($validatedData['asset_item_description'][$index]) ? $validatedData['asset_item_description'][$index] : null,
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e);

            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan barang aset.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetItem $assetItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetItem $assetItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetItem $assetItem)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'category' => [
                'required',
                'string',
                Rule::in(['IT', 'NonIT']),
            ],
            'description' => 'nullable|string',
        ]);
        try {
            $assetItem->name = $validatedData['name'];
            $assetItem->category = $validatedData['category'];
            $assetItem->description = $validatedData['description'];
            $assetItem->save();

            return redirect()->route('asset_item.index')->with('success', 'Barang aset berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error($e);

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetItem $assetItem)
    {
        $assetItem->delete();

        return redirect()->back()->with('success', 'Barang aset berhasil dihapus.');
    }

    public function getAssetItemBySelectedCategory(Request $request, $category = 'IT')
    {
        $assetItems = AssetItem::where('category', $category)->get();

        return response()->json($assetItems);
    }
}
