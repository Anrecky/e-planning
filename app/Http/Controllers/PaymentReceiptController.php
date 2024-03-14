<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PaymentVerification;
use App\Models\PPK;
use App\Models\Receipt;
use App\Models\ReceiptLog;
use App\Models\Treasurer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function list()
    {
        $title = 'Daftar Kuitansi';
        $ppks = PPK::all();
        $treasurers = Treasurer::all();
        $activities = Activity::all();
        $receipts = Receipt::select('receipts.*')->with(['ppk', 'treasurer', 'detail'])->join('ppks', 'receipts.ppk_id', 'ppks.id');
        if (Auth::user()->hasRole('PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-ppk', 'reject-ppk', 'accept'])->where('ppks.user_account', '=', Auth::user()->id);
        }
        if (Auth::user()->hasRole('SPI')) {
            $receipts = $receipts->whereIn('status', ['wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept']);
        }
        if (Auth::user()->hasRole('STAF PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])->whereHas('ppk', function ($query) {
                $query->where('staff_account', Auth::user()->id);
            });
        }
        $receipts = $receipts->get();
        return view('app.payment-receipt-list', compact('title', 'ppks', 'treasurers', 'activities', 'receipts'));
    }

    public function detail(Receipt $receipt)
    {
        $title = 'Detail Kuitansi';
        $receipt = Receipt::with(['ppk', 'treasurer', 'detail', 'verification', 'logs'])->findOrFail($receipt->id);
        $receipt->verification->load('user');
        $receipt->logs->load('user');
        // dd($receipt);
        $receipt->ppk->load('user', 'staff');
        $receipt->detail->load('expenditureUnit', 'budgetImplementation');
        $receipt->detail->budgetImplementation->load('activity', 'accountCode');
        // dd($receipt);

        return view('app.payment-receipt-detail', compact('title', 'receipt'));
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
            'provider_organization' => 'nullable|string',
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
            $receipt->provider_organization = $validatedData['provider_organization'];
            $receipt->provider = $validatedData['provider'];
            $receipt->ppk_id = $validatedData['ppk'];
            $receipt->treasurer_id = $validatedData['type'] === 'direct' ? null : $validatedData['treasurer'];
            $receipt->budget_implementation_detail_id = $validatedData['detail'];
            $receipt->user_entry = Auth::user()->id;
            $receipt->save();

            $log = new ReceiptLog;
            $log->receipt_id = $receipt->id;
            $log->user_id = $receipt->user_entry;
            $log->activity = "entry-receipt";
            $log->description = "Melalukan Entri Kuitansi";
            $log->save();

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
                'provider_organization' => 'nullable|string',
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
            $receipt->provider_organization = $validatedData['provider_organization'];
            $receipt->ppk_id = $validatedData['ppk'];
            $receipt->treasurer_id = $validatedData['type'] === 'direct' ? null : $validatedData['treasurer'];
            $receipt->budget_implementation_detail_id = $validatedData['detail'];
            $receipt->user_entry = Auth::user()->id;
            $receipt->save();

            $log = new ReceiptLog;
            $log->receipt_id = $receipt->id;
            $log->user_id = $receipt->user_entry;
            $log->activity = "update-receipt";
            $log->description = "Melalukan Update Data Kuitansi";
            $log->save();
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
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }
    public function upload(Request $request, Receipt $receipt)
    {
        try {
            $request->validate([
                'file_upload' => 'required|file|max:20480', // Max file size: 10 MB
            ]);
            if ($receipt->user_entry != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => "Anda tidak memiliki izin untuk mengunggah file untuk tanda terima ini."], 400);
            }
            if ($request->file('file_upload')->isValid()) {
                $file = $request->file('file_upload');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/berkas_receipt/', $fileName);
                $receipt->berkas = $fileName;
                $receipt->save();
                $log = new ReceiptLog;
                $log->receipt_id = $receipt->id;
                $log->user_id = $receipt->user_entry;
                $log->activity = "upload-berkas";
                $log->description = "Melakukan upload berkas";
                $log->save();
                return response()->json(['error' => false], 200);
            }

            return response()->json(['error' => true,  'message' => 'File upload failed'], 400);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function submit(Request $request, Receipt $receipt)
    {
        try {

            if ($receipt->user_entry != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => "Anda tidak memiliki izin untuk mengunggah file untuk tanda terima ini."], 400);
            }
            if (empty($receipt->berkas)) {
                return response()->json(['error' => true,  'message' => "Berkas belum diunggah!!."], 400);
            }
            if (!in_array($receipt->status, ['draft', 'reject-verificator', 'reject-ppk', 'reject-spi'])) {
                return response()->json(['error' => true,  'message' => "Anda tidak memiliki hak pada tahap ini"], 400);
            }
            if (empty($receipt->reference_number)) {
                $year = Carbon::createFromFormat('Y-m-d', $receipt->activity_date)->year;
                $number = "VR/LS/" . $year;
                $tmp = Receipt::where('ppk_id', '=', $receipt->ppk_id)->where('reference_number', 'like', '%' . $number)->orderBy('reference_number', 'desc')->first('reference_number');
                if ($tmp) {
                    $splitReference = explode("/", $tmp->reference_number)[0];
                    $newNumber = str_pad($splitReference + 1, 3, '0', STR_PAD_LEFT);
                    $receipt->reference_number = $newNumber . '/' . $number;
                } else {
                    $receipt->reference_number = '001/' . $number;
                }
            }
            $receipt->status = 'wait-verificator';
            $receipt->save();
            $log = new ReceiptLog;
            $log->receipt_id = $receipt->id;
            $log->user_id = $receipt->user_entry;
            $log->activity = "submit";
            $log->description = "Mengirimkan pengajuan ke verifikator";
            $log->save();
            return response()->json(['error' => false], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function ppk_action(Request $request, Receipt $receipt)
    {
        try {
            $receipt->load('ppk');
            if (!(in_array($receipt->status, ['wait-ppk', 'reject-ppk', 'accept'])) ||  $receipt->ppk->user_account != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }

            $log = new ReceiptLog;

            if ($request->res == 'Y') {
                $receipt->status = 'accept';
                $log->activity = "ppk-approv";
                $log->description = "Melakukan Approv";
            } else {
                $receipt->status = 'reject-ppk';
                $log->activity = "ppk-reject";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $receipt->save();

            $log->receipt_id = $receipt->id;
            $log->user_id = Auth::user()->id;
            $log->save();
            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    public function spi_action(Request $request, Receipt $receipt)
    {
        try {
            $receipt->load('ppk');
            if (!(in_array($receipt->status, ['wait-spi', 'reject-spi'])) || !(Auth::user()->hasRole('SPI'))) {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }

            $log = new ReceiptLog;

            if ($request->res == 'Y') {
                $receipt->status = 'wait-ppk';
                $log->activity = "spi-approv";
                $log->description = "Melakukan Approv";
            } else {
                $receipt->status = 'reject-spi';
                $log->activity = "spi-reject";
                if (!empty($request->description)) $log->description = "Melakukan Penolakan dengan alasan " . $request->description;
                else $log->description = "Melakukan Penolakan";
            }
            $receipt->save();

            $log->receipt_id = $receipt->id;
            $log->user_id = Auth::user()->id;
            $log->save();
            return response()->json(['error' => false,  'message' => $request->res], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function verification(Request $request, Receipt $receipt)
    {
        $validatedData = $request->validate([
            'verification_description' => 'nullable|string',
            // 'verification_date' => 'nullable|date',
            'receipt' => 'nullable|numeric',
            'verification_result' => 'nullable|string',
        ]);

        try {

            $items = [
                '2' => ['a', 'b', 'c', 'd', 'e'],
                '3' => ['a', 'b', 'c', 'd', 'e'],
                '4' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'],
            ];
            $tmp = $request->toArray();
            $result = [];
            foreach ($items as $key_i => $item) {
                foreach ($item as  $i) {
                    $result['item_' . $key_i . '_' . $i] = !empty($tmp['item_' . $key_i . '_' . $i]) ? 'Y' : null;
                }
            }
            // dd($result);
            // dd($request->toArray());
            if ($request->idVerification) {
                $payment_verification = PaymentVerification::findOrFail($request->idVerification);
            } else {
                // dd('new');
                $payment_verification = new PaymentVerification();
            }
            $payment_verification->receipt_id = $validatedData['receipt'];
            $payment_verification->items = json_encode($result);
            $payment_verification->description = $validatedData['verification_description'];
            // dd(auth()->user()->hasRole('admin'));
            // $payment_verification->date = $validatedData['verification_date'];
            $payment_verification->result = $validatedData['verification_result'];
            $payment_verification->file = 'null';
            $payment_verification->verification_user = Auth::user()->id;
            // $payment_verification->ppk_id = $validatedData['ppk'];
            // $payment_verification->auditor_name = $validatedData['spi_name'];
            // $payment_verification->auditor_nip = $validatedData['spi_nip'];
            // $payment_verification->verificator_id = $validatedData['verificator'];
            $payment_verification->save();
            $log = new ReceiptLog;

            if ($payment_verification->result == 'Y') {
                $log->activity = "verificator-approv";
                $log->description = "Melakukan Verifikasi dengan hasil Lengkap";
                $receipt->status = "wait-spi";
            } else
            if ($payment_verification->result == 'N') {
                $log->activity = "verificator-reject";
                $log->description = "Melakukan Verifikasi dengan hasil Tidak Lengkap";
                $receipt->status = "reject-verificator";
            }

            $receipt->save();
            $log->receipt_id = $receipt->id;
            $log->user_id = Auth::user()->id;
            $log->save();
            return response()->json(['error' => false,  'message' => 'Success'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
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
    public function print_ticket(Request $request, Receipt $receipt, PaymentVerification $verif)
    {
        try {
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail'])->findOrFail($receipt->id);
            $receipt->ppk->load('user', 'staff');
            $receipt->detail->load('expenditureUnit', 'budgetImplementation');
            $receipt->detail->budgetImplementation->load('activity', 'accountCode');

            $dompdf = new PDF();
            if ($verif->id) {
                $verifData = $verif;
                $pdf = PDF::loadView('components.custom.payment-receipt.print-verification', compact('receipt', 'verifData'));
            } else
                $pdf = PDF::loadView('components.custom.payment-receipt.print-ticket', compact('receipt'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('invoice.pdf');
        } catch (\Exception $e) {
            Log::error($e);
            // return back()->with('error', $e->getMessage());
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
                            $cell->setValue(str_replace("{{{$placeholder}}}", $searchValue[$placeholder], $cellValue));
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
