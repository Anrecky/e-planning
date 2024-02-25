<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PPK;
use App\Models\Treasurer;
use Illuminate\Http\Request;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        $title = 'Rekam Kuitansi';
        $ppks = PPK::all();
        $treasurers = Treasurer::all();
        $activities = Activity::all();

        return view('app.payment-receipt', compact('title', 'ppks', 'treasurers', 'activities'));
    }
}
