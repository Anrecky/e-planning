<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Activity;
use App\Models\PaymentVerification;
use App\Models\PPK;
use App\Models\ReceiptLog;
use App\Models\Role;
use App\Models\Treasurer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class ReceiptActionController extends Controller
{

    public function upload_berkas(Request $request, Receipt $receipt)
    {
        try {
            $request->validate([
                'file_upload' => 'required|file|max:20480', // Max file size: 10 MB
            ]);
            if ($receipt->user_entry != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak memiliki izin untuk mengunggah file untuk tanda terima ini.'], 400);
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
                $log->activity = 'upload-berkas';
                $log->description = 'Melakukan upload berkas';
                $log->save();

                return response()->json(['error' => false], 200);
            }

            return response()->json(['error' => true,  'message' => 'File upload failed'], 400);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function ajukan(Request $request, Receipt $receipt)
    {
        try {

            if ($receipt->user_entry != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak memiliki izin untuk mengunggah file untuk tanda terima ini.'], 400);
            }
            if (empty($receipt->berkas)) {
                return response()->json(['error' => true,  'message' => "Berkas belum diunggah!!."], 400);
            }
            if (!in_array($receipt->status, ['draft', 'reject-verificator', 'reject-ppk', 'reject-spi'])) {
                return response()->json(['error' => true,  'message' => 'Anda tidak memiliki hak pada tahap ini'], 400);
            }
            if (empty($receipt->reference_number)) {
                $year = Carbon::createFromFormat('Y-m-d', $receipt->activity_date)->year;
                $number = 'VR/LS/' . $year;
                $tmp = Receipt::where('ppk_id', '=', $receipt->ppk_id)->where('reference_number', 'like', '%' . $number)->orderBy('reference_number', 'desc')->first('reference_number');
                if ($tmp) {
                    $splitReference = explode('/', $tmp->reference_number)[0];
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
            $log->activity = 'submit';
            $log->description = 'Mengirimkan pengajuan ke verifikator';
            $log->save();

            return response()->json(['error' => false], 200);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    public function ppk(Request $request, Receipt $receipt)
    {
        try {
            $receipt->load('ppk');
            // dd($receipt);
            if (!(in_array($receipt->status, ['wait-ppk', 'reject-ppk', 'accept'])) || $receipt->ppk_id != Auth::user()->employee->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }

            $log = new ReceiptLog;

            if ($request->res == 'Y') {
                if ($receipt->type == 'direct')
                    $receipt->status = 'accept';
                else if ($receipt->type == 'treasurer')
                    $receipt->status = 'wait-treasurer';

                $log->activity = 'ppk-approv';
                $log->description = 'Melakukan Approv';
            } else {
                $receipt->status = 'reject-ppk';
                $log->activity = 'ppk-reject';
                if (!empty($request->description)) {
                    $log->description = 'Melakukan Penolakan dengan alasan ' . $request->description;
                } else {
                    $log->description = 'Melakukan Penolakan';
                }
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

    public function treasurer(Request $request, Receipt $receipt)
    {
        try {
            $receipt->load('treasurer');
            // dd($receipt);
            if (!(in_array($receipt->status, ['wait-treasurer', 'reject-treasurer', 'accept'])) || $receipt->treasurer_id != Auth::user()->employee->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }

            $log = new ReceiptLog;

            if ($request->res == 'Y') {
                $receipt->status = 'accept';
                $log->activity = 'treasurer-approv';
                $log->description = 'Melakukan Approv';
            } else {
                $receipt->status = 'reject-treasurer';
                $log->activity = 'treasurer-reject';
                if (!empty($request->description)) {
                    $log->description = 'Melakukan Penolakan dengan alasan ' . $request->description;
                } else {
                    $log->description = 'Melakukan Penolakan';
                }
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

    public function spi(Request $request, Receipt $receipt)
    {
        try {
            $receipt->load('ppk');
            if (!(in_array($receipt->status, ['wait-spi', 'reject-spi'])) || !(Auth::user()->hasRole('SPI'))) {
                return response()->json(['error' => true,  'message' => 'Anda tidak berhak melalukan aksi ini'], 500);
            }

            $log = new ReceiptLog;

            if ($request->res == 'Y') {
                $receipt->status = 'wait-ppk';
                $receipt->spi_id = Auth::user()->employee->id;
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
            'verification_date' => 'nullable|date',
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
            $payment_verification->date = $validatedData['verification_date'];
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
    public function change_money_app(Request $request, Receipt $receipt)
    {
        try {
            $validatedData = $request->validate([
                'status_money_app' => 'required|string',
            ]);
            $receipt->status_money_app = $validatedData['status_money_app'];
            $receipt->save();

            $log = new ReceiptLog;
            $log->receipt_id = $receipt->id;
            $log->user_id = $receipt->user_entry;
            $log->activity = 'update-status-money';

            if ($validatedData['status_money_app'] == 'Y')
                $log->description = 'Merubah Status Aplikasi Keuangan menjadi Sudah Entri';
            else
                $log->description = 'Merubah Status Aplikasi Keuangan menjadi Belum Entri';
            $log->save();
            return response()->json(['error' => false], 200);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
