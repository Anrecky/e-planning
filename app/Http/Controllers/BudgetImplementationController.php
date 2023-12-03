<?php

namespace App\Http\Controllers;

use App\Models\BudgetImplementation;
use Illuminate\Http\Request;

class BudgetImplementationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "DIPA";
        return view('app.budget-implementation', compact('title'));
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
    public function show(BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetImplementation $budgetImplementation)
    {
        //
    }
}
