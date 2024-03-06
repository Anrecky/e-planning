<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PPK;
use App\Models\Receipt;
use App\Models\Treasurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        $title = 'Rekam Kuitansi';
        $ppks = PPK::all();
        $treasurers = Treasurer::all();
        $activities = Activity::all();
        $receipts = Receipt::with(['ppk', 'treasurer', 'detail'])->get();

        return view('app.payment-receipt', compact('title', 'ppks', 'treasurers', 'activities', 'receipts'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'in:direct,treasurer',
            'description' => 'nullable|string',
            'activity_implementer' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'provider' => 'nullable|string',
            'ppk' => 'required|exists:ppks,id',
            'treasurer' => 'required_if:type,treasurer|exists:treasurers,id',
            'detail' => 'required|exists:budget_implementation_details,id'
        ]);

        try {
            $receipt = new Receipt;
            $receipt->type = $validatedData['type'];
            $receipt->description = $validatedData['description'];
            $receipt->activity_implementer = $validatedData['activity_implementer'];
            $receipt->activity_date = $validatedData['activity_date'];
            $receipt->amount = $validatedData['amount'];
            $receipt->provider = $validatedData['provider'];
            $receipt->ppk_id = $validatedData['ppk'];
            $receipt->treasurer_id = $validatedData['type'] === 'direct' ? null : $validatedData['treasurer'];
            $receipt->budget_implementation_detail_id = $validatedData['detail'];
            $receipt->save();

            return back()->with('success', 'Data penerimaan berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request, Receipt $receipt)
    {
        try {
            $validatedData = $request->validate([
                'type' => 'in:direct,treasurer',
                'description' => 'nullable|string',
                'activity_implementer' => 'nullable|string',
                'activity_date' => 'nullable|date',
                'amount' => 'nullable|numeric',
                'provider' => 'nullable|string',
                'ppk' => 'required|exists:ppks,id',
                'treasurer' => 'required_if:type,treasurer|exists:treasurers,id',
                'detail' => 'required|exists:budget_implementation_details,id'
            ]);
            $receipt->type = $validatedData['type'];
            $receipt->description = $validatedData['description'];
            $receipt->activity_implementer = $validatedData['activity_implementer'];
            $receipt->activity_date = $validatedData['activity_date'];
            $receipt->amount = $validatedData['amount'];
            $receipt->provider = $validatedData['provider'];
            $receipt->ppk_id = $validatedData['ppk'];
            $receipt->treasurer_id = $validatedData['type'] === 'direct' ? null : $validatedData['treasurer'];
            $receipt->budget_implementation_detail_id = $validatedData['detail'];
            $receipt->save();
            return back()->with('success', 'Data pembayaran kuitansi berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(Receipt $receipt)
    {
        try {
            $receipt->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data bendahara berhasil dihapus.');
    }
    public function totalAmountByBudgetImplementationDetail(Request $request, $detail)
    {
        try {
            $totalAmounts = Receipt::select('id', 'amount')
                ->where('budget_implementation_detail_id', $detail)
                ->sum('amount');
            return response()->json($totalAmounts);
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
