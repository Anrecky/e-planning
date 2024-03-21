<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function getHeads(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $limit = $request->input('limit', 10);

            $query = Employee::query()
                ->with('user')
                ->where('id', '!=', auth()->user()->employee->id);

            if (!empty($search)) {
                $query->where('id', 'LIKE', "%{$search}%");
            }
            Log::info($query->get());
            // $heads = $query->get(['id', 'user.name']);

            // return response()->json($heads);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }
}
