<?php

namespace App\Http\Controllers;

class DetailedFAReportController extends Controller
{
    public function index()
    {
        $title = 'Verifikasi Pembayaran';

        return view('app.detailed-FA-report', compact('title'));
    }
}
