<?php

namespace App\Http\Controllers;

use App\Models\PaymentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PPK;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $title = 'Rekam Verifikasi';
        $payment_verifications = PaymentVerification::with(['verificator', 'ppk'])->get();

        return view('app.payment-verification', compact('title', 'payment_verifications'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'provider' => 'nullable|string',
            'ppk' => 'required|exists:ppks,id',
            'activity_implementer_nip' => 'required|numeric',
            'activity_implementer_name' => 'required|string',
            'spi_nip' => 'required|numeric',
            'spi_name' => 'required|string',
            'verificator' => 'required|exists:verificators,id'
        ]);

        try {
            $payment_verification = new PaymentVerification;
            $payment_verification->description = $validatedData['description'];
            $payment_verification->implementer_name = $validatedData['activity_implementer_name'];
            $payment_verification->implementer_nip = $validatedData['activity_implementer_nip'];
            $payment_verification->activity_date = $validatedData['activity_date'];
            $payment_verification->amount = $validatedData['amount'];
            $payment_verification->provider = $validatedData['provider'];
            $payment_verification->ppk_id = $validatedData['ppk'];
            $payment_verification->auditor_name = $validatedData['spi_name'];
            $payment_verification->auditor_nip = $validatedData['spi_nip'];
            $payment_verification->verificator_id = $validatedData['verificator'];
            $payment_verification->save();

            return back()->with('success', 'Data pembayaran verifikasi berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request, PaymentVerification $payment_verification)
    {
        try {
            $validatedData = $request->validate([
                'description' => 'nullable|string',
                'activity_date' => 'nullable|date',
                'amount' => 'nullable|numeric',
                'provider' => 'nullable|string',
                'ppk' => 'required|exists:ppks,id',
                'activity_implementer_nip' => 'required|numeric',
                'activity_implementer_name' => 'required|string',
                'spi_nip' => 'required|numeric',
                'spi_name' => 'required|string',
                'verificator' => 'required|exists:verificators,id'
            ]);
            $payment_verification->description = $validatedData['description'];
            $payment_verification->implementer_name = $validatedData['activity_implementer_name'];
            $payment_verification->implementer_nip = $validatedData['activity_implementer_nip'];
            $payment_verification->activity_date = $validatedData['activity_date'];
            $payment_verification->amount = $validatedData['amount'];
            $payment_verification->provider = $validatedData['provider'];
            $payment_verification->ppk_id = $validatedData['ppk'];
            $payment_verification->auditor_name = $validatedData['spi_name'];
            $payment_verification->auditor_nip = $validatedData['spi_nip'];
            $payment_verification->verificator_id = $validatedData['verificator'];
            $payment_verification->save();
            return back()->with('success', 'Data pembayaran kuitansi berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(PaymentVerification $payment_verification)
    {
        try {
            $payment_verification->delete();
            return redirect()->back()->with('success', 'Data pembayaran verifikasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
