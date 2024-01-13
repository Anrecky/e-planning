<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailedFAReportController extends Controller
{
    public function index(){
        $title = 'Verifikasi Pembayaran';

        return view('app.detailed-FA-report', compact('title'));
    }
}