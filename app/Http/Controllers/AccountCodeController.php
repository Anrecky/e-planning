<?php

namespace App\Http\Controllers;

use App\Models\AccountCode;
use App\Models\BudgetImplementation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kode Akun';
        $accountCodes = AccountCode::all();
        return view('app.account-code', compact('title', 'accountCodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'account_code_name.*' => 'required|string|max:255', // Validation for names
            'account_code_code.*' => 'nullable|string|max:255', // Validation for codes
        ]);

        $names = $request->input('account_code_name');
        $codes = $request->input('account_code_code');

        foreach ($names as $index => $name) {
            $code = $codes[$index] ?? null; // Use null if the code is not provided

            // Create a new AccountCode
            AccountCode::create([
                'name' => $name,
                'code' => $code,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan kode akun.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountCode $accountCode)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is a required field
            'code' => 'nullable|string|max:255', // Assuming 'code' is optional
        ]);

        // Update the ExpenditureUnit with validated data
        $accountCode->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('account_code.index')->with('success', 'Kode akun berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountCode $accountCode)
    {
        $accountCode->delete();
        return redirect()->back()->with('success', 'Kode akun berhasil dihapus.');
    }

    // Get Account Code By Activity
    public function getAccountCodesByActivity(Request $request, $activityId)
    {
        try {
            $accountCodes = AccountCode::whereHas('budgetImplementations', function ($query) use ($activityId) {
                $query->where('activity_id', $activityId);
            })->get();
            return response()->json($accountCodes);
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
