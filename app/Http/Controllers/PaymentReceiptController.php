<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PaymentVerification;
use App\Models\PPK;
use App\Models\Receipt;
use App\Models\ReceiptLog;
use App\Models\Role;
use App\Models\Treasurer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        $title = 'Rekam Kuitansi';
        $ppkRole = Role::where('name', 'PPK')->first();
        $ppks = $ppkRole->users()->get()->toArray();
        $treasurersRole = Role::where('name', 'BENDAHARA')->first();
        $treasurers = $treasurersRole->users()->get()->toArray();
        $activities = Activity::all();
        $receipts = Receipt::with(['ppk', 'treasurer', 'detail']);
        if (!(Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN']))) {
            $receipts =  $receipts->where('user_entry', '=', Auth::user()->id);
        } else {
            // $receipts = $receipts->where('user_entry', '-', Auth::user()->id);
        }
        $receipts = $receipts->get();

        return view('app.payment-receipt', compact('title', 'ppks', 'treasurers', 'activities', 'receipts'));
    }

    public function list()
    {
        $title = 'Daftar Kuitansi';
        // $ppks = PPK::all();
        // $treasurers = Treasurer::all();
        $activities = Activity::all();
        $receipts = Receipt::select('receipts.*')->selectRaw(' users.name as name_ppk, employees.id as identity_number_ppk,employees.user_id as user_id_ppk, employees.staff_id as staff_id_ppk')->with(['ppk', 'treasurer', 'detail'])
            ->join('users', 'receipts.ppk_id', 'users.id')
            ->join('employees', 'employees.user_id', 'users.id');
        if (Auth::user()->hasRole('PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-ppk', 'reject-ppk', 'accept'])
                ->where('employees.user_id',  Auth::user()->id);
        }
        if (Auth::user()->hasRole('SPI')) {
            $receipts = $receipts->whereIn('status', ['wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept']);
        }
        if (Auth::user()->hasRole('STAF PPK')) {
            $receipts = $receipts->whereIn('status', ['wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])
                ->where('employees.staff_id',  Auth::user()->id);
        }
        $receipts = $receipts->get();
        // dd($receipts);
        return view('app.payment-receipt-list', compact('title',  'activities', 'receipts'));
    }

    public function detail(Receipt $receipt)
    {
        $title = 'Detail Kuitansi';
        $receipt = Receipt::with(['ppk', 'treasurer', 'detail', 'verification', 'logs'])->findOrFail($receipt->id);
        $receipt->verification->load('user');
        $receipt->logs->load('user');
        // $receipt->ppk->load('employee');
        if ($receipt->treasurer_id)
            $receipt->treasurer->load('employee');
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
            'perjadin' => 'in:N,Y',
            'description' => 'nullable|string',
            'activity_implementer' => 'nullable|string',
            'activity_date' => 'nullable|date',
            'provider' => 'nullable|string',
            'provider_organization' => 'nullable|string',
            'ppk' => 'required|integer',
            'treasurer' => 'required_if:type,treasurer|exists:treasurers,id|integer',
            'detail' => 'required|exists:budget_implementation_details,id',
        ]);
        $validatedData['amount'] = $cleanedAmount;

        try {
            $receipt = new Receipt;
            $receipt->type = $validatedData['type'];
            $receipt->perjadin = $validatedData['perjadin'];
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
            $log->activity = 'entry-receipt';
            $log->description = 'Melalukan Entri Kuitansi';
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
                'perjadin' => 'in:N,Y',
                'description' => 'nullable|string',
                'activity_implementer' => 'nullable|string',
                'activity_date' => 'nullable|date',
                'provider' => 'nullable|string',
                'provider_organization' => 'nullable|string',
                'ppk' => 'required|integer',
                'treasurer' => 'required_if:type,treasurer,integer',
                'detail' => 'required|exists:budget_implementation_details,id',
            ]);
            $validatedData['amount'] = $cleanedAmount;
            $receipt->type = $validatedData['type'];
            $receipt->perjadin = $validatedData['perjadin'];
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
            $log->activity = 'update-receipt';
            $log->description = 'Melalukan Update Data Kuitansi';
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
            $receipt = $receipt->with(['ppk', 'treasurer', 'detail'])->findOrFail($receipt->id);
            // dd($receipt);
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
            $receipt = $receipt->with(['verification', 'spi', 'ppk', 'detail'])->findOrFail($receipt->id);
            // $receipt->ppk->load('user');
            // dd($receipt);
            $verif->load('user');
            $receipt->detail->load('expenditureUnit', 'budgetImplementation');
            $receipt->detail->budgetImplementation->load('activity', 'accountCode');
            $dompdf = new PDF();
            if ($verif->id) {
                $verifData = $verif;
                // dd($verifData);
                $pdf = PDF::loadView('components.custom.payment-receipt.print-verification', compact('receipt', 'verifData'));
            } else
                $pdf = PDF::loadView('components.custom.payment-receipt.print-ticket', compact('receipt'));
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
