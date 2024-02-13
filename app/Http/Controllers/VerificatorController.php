<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificatorController extends Controller
{
    public function index()
    {
        $title = 'Verifikator';

        return view('app.verificator', compact('title'));
    }
}
