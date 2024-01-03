<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuhPaymentController extends Controller
{
    public function index(){
        $title = 'RUH Pembayaran';
        // $ruhPayment = RuhPayment::all();
        return view('app.ruh-payment', compact('title'));
    }
}