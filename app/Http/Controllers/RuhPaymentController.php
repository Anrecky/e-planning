<?php

namespace App\Http\Controllers;

class RuhPaymentController extends Controller
{
    public function index()
    {
        $title = 'RUH Pembayaran';

        // $ruhPayment = RuhPayment::all();
        return view('app.ruh-payment', compact('title'));
    }
}
