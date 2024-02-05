<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $title = 'Rekam Verifikasi';

        return view('app.payment-verification', compact('title'));
    }
}
