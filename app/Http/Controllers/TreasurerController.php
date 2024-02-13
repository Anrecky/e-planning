<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreasurerController extends Controller
{
    public function index()
    {
        $title = 'Bendahara';

        return view('app.treasurer', compact('title'));
    }
}
