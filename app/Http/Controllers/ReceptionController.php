<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\ReceptionType;
use App\Models\Reception;
use Illuminate\Support\Facades\Log;

class ReceptionController extends Controller
{
    public function index()
    {
        $title = 'Penerimaan';
        $receptions = Reception::with('accountCodeReception')->get();

        return view('app.reception', compact('title', 'receptions'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'accountCode' => 'required|integer|exists:account_code_receptions,id',
            'target' => 'nullable|integer',
            'description' => 'nullable',
            'type.*' => [Rule::enum(ReceptionType::class)]
        ]);

        try {
            $reception = new Reception;
            $reception->account_code_reception_id = $validatedData['accountCode'];
            $reception->revenue_target = $validatedData['target'];
            $reception->description = $validatedData['description'];
            $reception->type = $validatedData['type'];
            $reception->save();
            return back()->with('success', 'Data penerimaan berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Reception $reception)
    {
        $validatedData = $request->validate([
            'accountCode' => 'required|integer|exists:account_code_receptions,id',
            'target' => 'nullable|integer',
            'description' => 'nullable',
            'type.*' => [Rule::enum(ReceptionType::class)]
        ]);
        try {
            $reception->account_code_reception_id = $validatedData['accountCode'];
            $reception->revenue_target = $validatedData['target'];
            $reception->description = $validatedData['description'];
            $reception->type = $validatedData['type'];
            $reception->save();
            return back()->with('success', 'Data penerimaan berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reception $reception)
    {
        $reception->delete();
        return redirect()->back()->with('success', 'Data penerimaan berhasil dihapus.');
    }

    public function deleteSome(Reception $reception)
    {
        $reception->delete();
        return response()->json($reception)->with('success', 'Data penerimaan berhasil dihapus.');
    }
}
