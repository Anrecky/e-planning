<!DOCTYPE html>
<html lang="en" style="margin: 0px">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <style>
        /* Gaya CSS untuk kwitansi */
        body {
            font-family: Arial, sans-serif;
            margin: 0px
                /* Margin only on the left side */
        }

        .receipt {
            width: calc(100% - 80px) !important;
            margin-top: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            padding: 20px 20px 20px 20px;
            padding-right: 30px !important;

            border: 1px solid #252525;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-body {
            margin-bottom: 20px;
        }

        .receipt-footer {
            text-align: center;
            font-size: 12px;
        }

        .fullwidth {
            width: 100%;
        }

        .text-top {
            vertical-align: top;
        }

        .section {
            width: 100%
        }

        .section .table-container {
            padding-left: 65%;
            margin-left: 20px;
            /* Jarak antara tabel dan konten lainnya */
        }

        /* Atur lebar untuk setiap kolom */
        .section .table-container table {
            width: 100%;
            /* Atur sesuai kebutuhan Anda */
        }

        .title {
            text-align: center;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @if ($receipt->perjadin == 'N')
        @php
            $penerima['name'] = $receipt->provider;
            $penerima['sub'] = $receipt->provider_organization;
            $penerima['total'] = $receipt->amount;

        @endphp
    @else
        @php $i= 1 @endphp
        @foreach ($receipt->pengikut as $p)
            @if ($i != 1)
                <div class="page_break"></div>
            @endif
            @php
                $i++;
                $penerima['name'] = $p->user->name;
                $penerima['sub'] = strtoupper($p->user->employee->identity_type) . '. ' . $p->user->employee->id;
                $penerima['total'] = 0;
                if (!empty($p->datas)) {
                    foreach (json_decode($p->datas) as $key => $value) {
                        $penerima['total'] = (int) $penerima['total'] + (int) $value->amount;
                    }
                }
            @endphp
            <x-custom.payment-receipt.print-kwitansi-page :receipt="$receipt" :penerima="$penerima" />
        @endforeach
    @endif

    {{-- @include('components.custom.payment-receipt.print-kwitansi-ls') --}}


    {{-- <div class="receipt">
        <div class="receipt-header">
            <h2>KUITANSI PEMBAYARAN LANGSUNG</h2>
        </div>
        <div class="receipt-body">
            <div class="section">
                <div class="table-container">
                    <table class="fullwidth text-top">
                        <tr>
                            <td style="width: 120px">Tahun Anggaran</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($receipt->activity_date)->format('Y') }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Bukti</td>
                            <td>:</td>
                            <td>{{ $receipt->proof_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Mata Anggaran</td>
                            <td>:</td>
                            <td>{{ $receipt->mata_anggaran ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="section">
                <table class="fullwidth text-top">
                    <tr>
                        <td style="width: 200px">Sudah Terima Dari</td>
                        <td style="10px">:</td>
                        <td>Pejabat Pembuat Komitmen IAIN SAS Babel</td>
                    </tr>
                    <tr>
                        <td>Jumlah Uang</td>
                        <td>:</td>
                        <td>{{ number_format($receipt->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td>{{ ucwords(terbilang($receipt->amount)) }} Rupiah</td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td>{{ $receipt->description }}</td>
                    </tr>
                </table>
            </div>
            <div class="height: 100px">&nbsp;</div>
            <div class="section fullwidth">
                <table class="text-top fullwidth">
                    <tr>
                        <td style="width: 40%px">An. Kuasa Pengguna Anggaran</td>
                        <td style="width: 20%"></td>
                        <td style="width: 40%">Bangka,
                            {{ \Carbon\Carbon::parse($receipt->activity_date)->translatedFormat('j F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pejabat Pembuat Komitmen,
                        </td>
                        <td></td>
                        <td>{{ $receipt->type == 'direct' ? 'Penerima Uang,' : 'Bendahara Pengeluaran' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 90px"></td>

                    </tr>
                    <tr>
                        <td>{{ $receipt->ppk->name }}</td>
                        <td></td>
                        <td>{{ $receipt->type == 'direct' ? $receipt->provider : $receipt->treasurer->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ strtoupper($receipt->ppk->identity_type) }}.
                            {{ $receipt->ppk->id }}</td>
                        <td></td>
                        <td>{{ $receipt->type == 'direct' ? $receipt->provider_organization ?? '' : strtoupper($receipt->treasurer->identity_type) . '. ' . $receipt->treasurer->id }}
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            @if ($receipt->type == 'treasurer')
                <table class="text-top fullwidth">
                    <tr>
                        <td style="width: 50%">Penerima Uang
                        </td>
                        <td style="width: 50%">Barang/pekerjaan telah diterima/diselesaikan dengan baik dan lengkap
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pejabat yang bertanggung jawab,</td>

                    </tr>
                    <tr>
                        <td style="height: 90px"></td>
                        <td style="height: 90px"></td>
                    </tr>
                    <tr>
                        <td>{{ $receipt->provider }}</td>
                        <td>{{ $receipt->pelaksana->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $receipt->provider_organization ?? '' }}</td>
                        <td>{{ strtoupper($receipt->pelaksana->identity_type) }}.
                            {{ strtoupper($receipt->pelaksana->id) }}</td>
                    </tr>
                </table>
            @else
                <table class="text-top fullwidth">
                    <tr>
                        <td style="width: 50%">Barang/pekerjaan telah diterima/diselesaikan dengan baik dan lengkap
                        </td>
                    </tr>
                    <tr>
                        <td>Pejabat yang bertanggung jawab,</td>
                    </tr>
                    <tr>
                        <td style="height: 90px"></td>
                    </tr>
                    <tr>
                        <td>{{ $receipt->pelaksana->user->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ strtoupper($receipt->pelaksana->identity_type) }}.
                            {{ strtoupper($receipt->pelaksana->id) }}</td>
                    </tr>
                </table>
            @endif
        </div>

    </div> --}}

</body>

</html>
