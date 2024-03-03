<?php

namespace App\Http\Controllers;

use App\Models\Verificator;
use Illuminate\Http\Request;

class VerificatorController extends Controller
{
    public function index()
    {
        $title = 'Verifikator';
        $verificators = Verificator::all();
        return view('app.verificator', compact('title', 'verificators'));
    }
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'nik' => 'required|integer',
            'position' => 'required|string|max:255',
        ]);

        try {
            Verificator::create([
                'name' => $validatedData['name'],
                'nik' => $validatedData['nik'],
                'position' => $validatedData['position'],
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data Bendahara.');
    }
    public function update(Request $request, Verificator $verificator)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'nik' => 'required|integer',
            'position' => 'required|string|max:255',
        ]);

        try {
            $verificator->update($validatedData);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mengupdate data Bendahara.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Verificator $verificator)
    {
        try {
            $verificator->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data bendahara berhasil dihapus.');
    }
}
