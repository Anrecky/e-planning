<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PPK;
use App\Models\Receipt;
use App\Models\Treasurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

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
        $requestAmount = $request->input('amount');
        $cleanedAmount = preg_replace('/[^0-9]/', '', $requestAmount);
        $validatedData = $request->validate([
            'type' => 'in:direct,treasurer',
            'description' => 'nullable|string',
            'activity_implementer' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'provider' => 'nullable|string',
            'ppk' => 'required|exists:ppks,id',
            'treasurer' => 'required_if:type,treasurer|exists:treasurers,id',
            'detail' => 'required|exists:budget_implementation_details,id'
        ]);
        $validatedData['amount'] = $cleanedAmount;

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
            $requestAmount = $request->input('amount');
            $cleanedAmount = preg_replace('/[^0-9]/', '', $requestAmount);
            $validatedData = $request->validate([
                'type' => 'in:direct,treasurer',
                'description' => 'nullable|string',
                'activity_implementer' => 'nullable|string',
                'activity_date' => 'nullable|date',
                'provider' => 'nullable|string',
                'ppk' => 'required|exists:ppks,id',
                'treasurer' => 'required_if:type,treasurer|exists:treasurers,id',
                'detail' => 'required|exists:budget_implementation_details,id'
            ]);
            $validatedData['amount'] = $cleanedAmount;
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

    public function print_kwitansi(Request $request, Receipt $receipt)
    {
        try {
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail'])->findOrFail($receipt->id);
            $dompdf = new PDF();
            $pdf = PDF::loadView('components.custom.payment-receipt.print-kwitansi-ls', compact('receipt'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('invoice.pdf');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function print_ticket(Request $request, Receipt $receipt)
    {
        try {
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail'])->findOrFail($receipt->id);
            $dompdf = new PDF();
            $pdf = PDF::loadView('components.custom.payment-receipt.print-ticket', compact('receipt'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('invoice.pdf');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function print2(Request $request, Receipt $receipt)
    {
        try {

            $receipt = $receipt->with(['ppk', 'treasurer', 'detail'])->findOrFail($receipt->id);
            $templatePath = storage_path('app/public/format_print/kwitansi_ls.xlsx');
            $spreadsheet = IOFactory::load($templatePath);
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $searchValue = [
                'ppk_nama' => $receipt->ppk->name,
                'ppk_nik' => $receipt->ppk->nik ?? '-',
                'amount' => $receipt->amount ?? '-',
                'provider' => $receipt->provider ?? '-',
                'provider_organization' => '-',
                'activity_implementer' => $receipt->activity_implementer,
                'tanggal_kwitansi' => $receipt->created_at,
            ];

            foreach ($activeWorksheet->getRowIterator() as $row) {
                foreach ($row->getCellIterator() as $cell) {
                    $cellValue = $cell->getValue();
                    if (strpos($cellValue, '{{') !== false && strpos($cellValue, '}}') !== false) {
                        $placeholder = substr($cellValue, strpos($cellValue, '{{') + 2, strpos($cellValue, '}}') - strpos($cellValue, '{{') - 2);
                        if (isset($searchValue[$placeholder])) {
                            $cell->setValue(str_replace("{{{$placeholder}}}",$searchValue[$placeholder], $cellValue));
                        }
                    }
                }
            }

            $writer = new Dompdf($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $output = ob_get_clean();

            // Set header untuk respons HTTP
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            // Tampilkan file PDF di browser tanpa perlu menyimpannya
            return Response::make($output, 200, $headers);

        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
