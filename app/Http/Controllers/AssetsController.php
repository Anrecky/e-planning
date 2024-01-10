<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function index(){
        $title = 'Aset';

        return view('app.assets', compact('title'));
    }
}