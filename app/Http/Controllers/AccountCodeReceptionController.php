<?php

namespace App\Http\Controllers;

use App\Models\AccountCodeReception;
use Illuminate\Http\Request;

class AccountCodeReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kode Akun';
        $accountCodeReceptions = AccountCodeReception::all();

        return view('app.account-code-reception', compact('title', 'accountCodeReceptions'));
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
        $this->validate($request, [
            'account_code_name.*' => 'required|string|max:255', // Validation for names
            'account_code_code.*' => 'nullable|string|max:255', // Validation for codes
        ]);

        $names = $request->input('account_code_name');
        $codes = $request->input('account_code_code');

        foreach ($names as $index => $name) {
            $code = $codes[$index] ?? null; // Use null if the code is not provided

            // Create a new AccountCode
            AccountCodeReception::create([
                'name' => $name,
                'code' => $code,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan kode akun.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountCodeReception $accountCodeReception)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountCodeReception $accountCodeReception)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountCodeReception $accountCodeReception)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is a required field
            'code' => 'nullable|string|max:255', // Assuming 'code' is optional
        ]);

        // Update the ExpenditureUnit with validated data
        $accountCodeReception->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('account_code_reception.index')->with('success', 'Kode akun berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountCodeReception $accountCodeReception)
    {
        $accountCodeReception->delete();

        return redirect()->back()->with('success', 'Kode akun berhasil dihapus.');
    }

    public function getAccountCodes(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10);

        $query = AccountCodeReception::query();

        if (! empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
        }

        $accountCodeReception = $query->get(['id', 'name', 'code']);

        return response()->json($accountCodeReception);
    }

    public function getSelectedAccountCode(Request $request, AccountCodeReception $accountCodeReception)
    {

        return response()->json($accountCodeReception);
    }
}
