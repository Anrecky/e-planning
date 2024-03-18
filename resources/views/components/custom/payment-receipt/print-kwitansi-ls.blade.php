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
    </style>
</head>

<body>
    <div class="receipt">
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
                {{-- <h2 class="title">KWITANSI / BUKTI PEMBAYARAN</h2> --}}
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
                        <td>Penerima Uang,</td>
                    </tr>
                    <tr>
                        <td style="height: 90px"></td>

                    </tr>
                    <tr>
                        <td>{{ $receipt->ppk->name }}</td>
                        <td></td>
                        <td>{{ $receipt->provider }}</td>
                    </tr>
                    <tr>
                        <td>{{ strtoupper($receipt->ppk->employee_staff->identity_type) }}.
                            {{ $receipt->ppk->employee_staff->id }}</td>
                        <td></td>
                        <td>{{ $receipt->provider_organization ?? '' }}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <table class="text-top fullwidth">
                <tr>
                    <td style="width: 100%">Barang/pekerjaan telah diterima/diselesaikan dengan baik dan lengkap</td>
                </tr>
                <tr>
                    <td>Pejabat yang bertanggung jawab,</td>
                </tr>
                <tr>
                    <td style="height: 90px"></td>
                </tr>
                <tr>
                    <td>{{ $receipt->activity_implementer }}</td>
                </tr>
                <tr>
                    <td>NIP. </td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
