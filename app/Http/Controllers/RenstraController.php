<?php

namespace App\Http\Controllers;

use App\Models\Renstra;
use Illuminate\Http\Request;

class RenstraController extends Controller
{
    public function visi()
    {
        return view('app.visi', ['title' => 'VISI']);
    }
}
