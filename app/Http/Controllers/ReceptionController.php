<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function index()
    {
        $title = 'Penerimaan';

        return view('app.reception', compact('title'));
    }

    public function store(Request $request)
    {
        return dd($request);
    }
}
