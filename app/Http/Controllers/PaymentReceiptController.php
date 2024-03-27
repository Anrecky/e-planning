<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BudgetImplementationDetail;
use App\Models\Employee;
use App\Models\PaymentVerification;
use App\Models\PPK;
use App\Models\Receipt;
use App\Models\ReceiptData;
use App\Models\ReceiptLog;
use App\Models\Role;
use App\Models\Treasurer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use PDF;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        // $res =   Employee::with('user')
        //     // ->join('users', 'employees.user_id', '=', 'users.id')
        //     ->limit(10)
        //     ->get();
        // dd($res);

        $title = 'Rekam Kuitansi';
        $ppkRole = Role::where('name', 'PPK')->first();
        $ppks = $ppkRole->users()->get()->toArray();
        $treasurersRole = Role::where('name', 'BENDAHARA')->first();
        $treasurers = $treasurersRole->users()->get()->toArray();
        $activities = Activity::all();
        $receipts = Receipt::with(['ppk', 'treasurer', 'detail', 'pengikut']);
        if (!(Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN']))) {
            $receipts =  $receipts->where('user_entry', '=', Auth::user()->id);
        } else {
        }
        $receipts = $receipts->get();
        // dd($receipts);
        return view('app.payment-receipt', compact('title', 'ppks', 'treasurers', 'activities', 'receipts'));
    }

    public function list()
    {
        $title = 'Daftar Kuitansi';
        // $ppks = PPK::all();
        // $treasurers = Treasurer::all();
        $activities = Activity::all();
        $receipts = Receipt::select('receipts.*')
            // ->selectRaw('users.name as name_ppk, employees.id as identity_number_ppk,employees.user_id as user_id_ppk, employees.head_id as head_id_ppk')
            ->with(['ppk', 'treasurer', 'detail'])
            // ->join('users', 'receipts.ppk_id', 'users.id')
            ->join('users as u', 'u.id', 'receipts.ppk_id')
            ->join('employees as p', 'p.user_id', 'u.id');
        if (Auth::user()->hasRole('PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-treasurer', 'reject-treasurer', 'wait-ppk', 'reject-ppk', 'accept'])
                ->where('ppk_id',  Auth::user()->id);
        }
        if (Auth::user()->hasRole('SPI')) {
            $receipts = $receipts->whereIn('status', ['wait-treasurer', 'reject-treasurer', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept']);
        }
        if (Auth::user()->hasRole('STAF PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-treasurer', 'reject-treasurer', 'wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])
                ->where('p.head_id',  Auth::user()->id);
        }
        if (Auth::user()->hasRole('BENDAHARA')) {
            $receipts = $receipts->whereIn('status', ['wait-treasurer', 'reject-treasurer', 'accept'])
                ->where('treasurer_id',  Auth::user()->id);
        }
        $receipts = $receipts->get();
        return view('app.payment-receipt-list', compact('title',  'activities', 'receipts'));
    }

    public function detail(Receipt $receipt)
    {
        $title = 'Detail Kuitansi';
        $receipt = Receipt::with(['ppk', 'treasurer', 'detail', 'verification', 'logs', 'pelaksana'])->findOrFail($receipt->id);
        $receipt->verification->load('user');
        $receipt->logs->load('user');
        $receipt->ppk->load('employee_staff');
        // if ($receipt->treasurer_id)
        //     $receipt->treasurer->load('employee');
        $receipt->detail->load('expenditureUnit', 'budgetImplementation');
        $receipt->detail->budgetImplementation->load('activity', 'accountCode');
        // dd($receipt->verification[0]);
        return view('app.payment-receipt-detail', compact('title', 'receipt'));
    }

    public function store(Request $request)
    {
        $requestAmount = $request->input('amount');
        $cleanedAmount = preg_replace('/[^0-9]/', '', $requestAmount);


        $validatedData = $request->validate([
            'type' => 'in:direct,treasurer',
            'perjadin' => 'required|in:N,Y',
            'description' => 'nullable|string',
            'activity_implementer' => 'nullable|integer',
            'activity_date' => 'nullable|date',
            'provider' => 'nullable|string',
            'provider_organization' => 'nullable|string',
            'ppk' => 'required|integer',
            'activity_followings.*' => 'integer',
            'treasurer' => 'required_if:type,treasurer,integer',
            'spd_number' => 'required_if:perjadin,Y,string',
            'spd_tujuan' => 'required_if:perjadin,Y,string',
            'detail' => 'required|exists:budget_implementation_details,id',
        ]);

        $detail = BudgetImplementationDetail::select('total')->find($request->detail);
        $sum = Receipt::where('budget_implementation_detail_id', '=', $request->detail)->sum('amount');
        $sisa = $detail->total - $sum;
        if ($sisa - $cleanedAmount < 0)
            return back()->with('error', 'Maaf Sisa pagu tidak cukup, sisa pagu yaitu Rp. ' . number_format($sisa, 0, ',', '.'));

        $validatedData['amount'] = $cleanedAmount;
        try {
            $receipt = new Receipt;
            $receipt->type = $validatedData['type'];
            $receipt->perjadin = $validatedData['perjadin'];
            $receipt->spd_number = $validatedData['spd_number'] ?? null;
            $receipt->spd_tujuan = $validatedData['spd_tujuan'] ?? null;
            $receipt->description = $validatedData['description'];
            $receipt->activity_implementer = $validatedData['activity_implementer'];
            $receipt->activity_date = $validatedData['activity_date'];
            $receipt->amount = $validatedData['amount'];
            $receipt->activity_followings = (!empty($validatedData['activity_followings']) ? json_encode($validatedData['activity_followings']) : null);
            $receipt->provider_organization = $validatedData['provider_organization'];
            $receipt->provider = $validatedData['provider'];
            $receipt->ppk_id = $validatedData['ppk'];
            $receipt->treasurer_id = $validatedData['type'] === 'direct' ? null : $validatedData['treasurer'];
            $receipt->budget_implementation_detail_id = $validatedData['detail'];
            $receipt->user_entry = Auth::user()->id;
            $receipt->save();

            $following = new ReceiptData();
            $following->user_id = $validatedData['activity_implementer'];
            $following->receipt_id = $receipt->id;
            $following->datas = null;
            $following->save();
            // dd((!empty($validatedData['activity_followings']) ? json_encode($validatedData['activity_followings']) : null));

            if (!empty($validatedData['activity_followings']))
                foreach ($validatedData['activity_followings'] as $foll) {
                    $following = new ReceiptData();
                    $following->user_id = $foll;
                    $following->receipt_id = $receipt->id;
                    $following->datas = null;
                    $following->save();
                }

            $log = new ReceiptLog;
            $log->receipt_id = $receipt->id;
            $log->user_id = $receipt->user_entry;
            $log->activity = "entry-receipt";
            $log->description = "Membuat Draft Pembayaran";
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
            if (!(in_array($receipt->status, ['draft', 'reject-spi', 'reject-ppk', 'reject-verificator', 'reject-treasurer'])))
                return back()->with('error', "Tidak diizinkan lagi untuk melakukan perubahan");

            $requestAmount = $request->input('amount');
            $cleanedAmount = preg_replace('/[^0-9]/', '', $requestAmount);
            $validatedData = $request->validate([
                'type' => 'in:direct,treasurer',
                'perjadin' => 'required|in:N,Y',
                'description' => 'nullable|string',
                'activity_implementer' => 'nullable|integer',
                'activity_date' => 'nullable|date',
                'provider' => 'nullable|string',
                'provider_organization' => 'nullable|string',
                'activity_followings.*' => 'integer',
                'spd_number' => 'required_if:perjadin,Y,string',
                'spd_tujuan' => 'required_if:perjadin,Y,string',
                'ppk' => 'required|integer',
                'treasurer' => 'required_if:type,treasurer,integer',
                'detail' => 'required|exists:budget_implementation_details,id',
            ]);
            $validatedData['amount'] = $cleanedAmount;
            $receipt->type = $validatedData['type'];
            $receipt->perjadin = $validatedData['perjadin'];
            $receipt->spd_number = $validatedData['spd_number'] ?? null;
            $receipt->spd_tujuan = $validatedData['spd_tujuan'] ?? null;
            $receipt->description = $validatedData['description'];
            $receipt->activity_followings = (!empty($validatedData['activity_followings']) ? json_encode($validatedData['activity_followings']) : null);
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

            array_unshift($validatedData['activity_followings'], $receipt->activity_implementer);
            if (!empty($validatedData['activity_followings']))
                foreach ($validatedData['activity_followings'] as $foll) {
                    $existingReceiptData = ReceiptData::where('user_id', $foll)->where('receipt_id', $receipt->id)->exists();
                    if (!$existingReceiptData) {
                        $newReceiptData = new ReceiptData();
                        $newReceiptData->user_id = $foll;
                        $newReceiptData->receipt_id = $receipt->id;
                        $newReceiptData->datas = null;
                        $newReceiptData->save();
                    }
                }

            ReceiptData::where('receipt_id', $receipt->id)->whereNotIn('user_id', $validatedData['activity_followings'])->delete();


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



    public function print_kwitansi(Request $request, Receipt $receipt)
    {
        try {
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail', 'pelaksana'])->findOrFail($receipt->id);
            // dd($receipt);
            $dompdf = new PDF();
            // return view('components.custom.payment-receipt.print-kwitansi-ls', compact('receipt'));
            $pdf = PDF::loadView('components.custom.payment-receipt.print-kwitansi-ls', compact('receipt'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('invoice.pdf');
        } catch (\Exception $e) {
            Log::error($e);
            return back()->with('error', $e->getMessage());
        }
    }

    public function print_rampung(Request $request, Receipt $receipt)
    {
        try {
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail', 'pelaksana'])->findOrFail($receipt->id);
            $receipt->detail->load('expenditureUnit', 'budgetImplementation');
            $receipt->detail->budgetImplementation->load('activity', 'accountCode');
            $dompdf = new PDF();
            // return view('components.custom.payment-receipt.print-rampung', compact('receipt'));
            $pdf = PDF::loadView('components.custom.payment-receipt.print-rampung', compact('receipt'));
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
            $receipt = $receipt->with(['verification', 'spi', 'ppk', 'detail', 'pelaksana'])->findOrFail($receipt->id);
            // $receipt->ppk->load('user');
            // dd($receipt);
            $verif->load('user');
            $receipt->detail->load('expenditureUnit', 'budgetImplementation');
            $receipt->detail->budgetImplementation->load('activity', 'accountCode');
            $dompdf = new PDF();
            if ($verif->id) {
                $verifData = $verif;
                // dd($verifData);
                // return view('components.custom.payment-receipt.print-verification', compact('receipt', 'verifData'));
                $pdf = PDF::loadView('components.custom.payment-receipt.print-verification', compact('receipt', 'verifData'));
            } else
                return view('components.custom.payment-receipt.print-ticket', compact('receipt'));
            // $pdf = PDF::loadView('components.custom.payment-receipt.print-ticket', compact('receipt'));
            // $customPaper = array(0, 0, 816, 1247);
            // $pdf->setPaper($customPaper);
            $pdf->setPaper('legal', 'portrait');

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
