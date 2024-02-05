<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        $title = 'Rekam Kuitansi';

        return view('app.payment-receipt', compact('title'));
    }
}
