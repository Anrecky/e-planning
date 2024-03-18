<!DOCTYPE html>
<html>

<?php
$imageSrc = 'logo.png';

function checkbox($number, $desc, $span = 'ADA', $res = false)
{
    if ($res == 'Y') {
        $checked = 'checked';
    } else {
        $checked = '';
    }
    return "<tr class='no-border'>
                                    <td class='no-border' style='width: 10px'>$number.</td>
                                    <td class='no-border'>$desc</td>
                                    <td class='no-border' style='width: 10px'>
                                        <input style='vertical-align: top ;  transform: scale(1.5); margin-top:  -5px !important ; padding-top: -10px  !important ;height: 15px !important' type='checkbox' ' . $checked . '>
                                        </td>
                                </tr>";
}
?>

<head>
    <title>Judul</title>
</head>

<style>
    /* CSS untuk memberikan margin pada tabel */
    html,
    body {
        margin: 3px 10px 3px 5px;
        padding: 3px 3px 3px 3px;
        font-size: 13px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .no-border,
    .no-border td,
    .no-border tr {
        border: none;
        padding-bottom: 2px;
        padding-right: 2px;
        border-collapse: collapse;
    }

    table {
        margin: 10px;
        margin-top: 2px;
        padding: 3px;
        border-collapse: collapse;
        border: 1px solid #070707;
        border-spacing: 1px;
    }

    th,
    td {
        border: 1px solid #070707;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .text-center {
        text-align: center;
    }

    .background-image,
    .front-image {
        width: 370px !important;
        height: 370px;
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center center;
    }

    .front-image {
        background-image: url('{{ $imageSrc }}');
        position: absolute;
        top: 0;
        left: 0;
    }

    .page_break {
        page-break-before: always;
    }

    .box {
        width: 40px;
        height: 20px;
        border: 1px solid black;
    }

    .text-top {
        vertical-align: top;
    }
</style>
@php
    if (!empty($verifData->items)) {
        $items = json_decode($verifData->items);
    }
    // echo 'd';
    // dd($items);
@endphp

<body>
    <table style="width: 100%">
        <tr>
            <th colspan="3" class="text-center">
                <table style="width:100% ;margin: 0px ; padding :0px; ">
                    <tr>
                        <td style="width: 150px"><img style="width: 150px" src="{{ $imageSrc }}" alt="auth-img"></td>
                        <td class="text-center">
                            <h4><span style="font-size: 14">KEMENTRIAN AGAMA RI <br>
                                    INSTITUT AGAMA ISLAM NEGERI <br>
                                    SYAIKH ABDURRAHMAN SIDDIK <br>
                                    BANGKA BELITUNG <br> </span><br>
                                FORMULIR VERIFIKASI</h4>
                        </td>
                        <td>
                            <p style="margin-left: 10px !important">Nomor :
                                {{ $receipt->reference_number }}<br><br>Tanggal :
                                {{ \Carbon\Carbon::parse($verifData->date)->translatedFormat('j F Y') }}
                                <br><br>
                                <span style="font-style: italic;">(diisi
                                    verifikator)</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        {{-- <tr class="text-center">
            <td colspan="3" class="text-center">
                <b> MOHON DI ISI DENGAN HURUF KAPITAL</b>
            </td>
        </tr> --}}
        <tr class="text-center">
            <td colspan="3" class="">
                <b>1. Jenis Pencairan </b>
                <table style="width: 100% ; margin-top :0" class="no-border">
                    <tr>
                        <td>Nama Pencairan</td>
                        <td>:</td>
                        <td>{{ $receipt->description }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kegiatan</td>
                        <td>: </td>
                        <td> {{ \Carbon\Carbon::parse($receipt->activity_date)->translatedFormat('j F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>Rp {{ number_format($receipt->amount, 0, ',', '.') }}
                            ({{ ucwords(terbilang($receipt->amount)) }} Rupiah)</td>
                    </tr>
                    <tr>
                        <td>Nama Penyedia</td>
                        <td>: </td>
                        <td>{{ $receipt->provider }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="">
                <b>2. BUKTI KELENGKAPAN BERKAS PENCAIRAN MELALUI GUP BENDAHARA / LS PIHAK KE TIGA </b>
                <table class="no-border" style="width: 100%; margin: 0px; padding:0px">
                    <tr class="">
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">


                                {!! checkbox('a', 'SPBy/Kwitansi LS', '', $items->item_2_a) !!}
                                {!! checkbox('b', 'NOTA / INVOICE DGN NMR, TGL, TTD DAN CAP ', '', $items->item_2_b) !!}
                                {{-- {!! checkbox('c', 'NMR, TGL, TANDATANGAN DAN <br>CAP PADA DOKUMEN') !!} --}}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('c', 'FOTOCOPY NPWP (SUPLIER BARU)', '', $items->item_2_c) !!}
                                {!! checkbox('d', 'FOTOCOPY BUKU REKENING<br> (SUPLIER BARU)', '', $items->item_2_d) !!}
                                {!! checkbox('e', 'DOKUMENTASI', '', $items->item_2_e) !!}
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="3" class="">
                <b>3. BUKTI KELENGKAPAN BERKAS PENCAIRAN HONORARIUM </b>
                <table class="no-border" style="width: 100%; margin: 0px; padding:0px">
                    <tr class="">
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('a', 'DAFTAR HONOR', '', $items->item_3_a) !!}
                                {!! checkbox('b', 'SK', '', $items->item_3_b) !!}
                                {!! checkbox('c', 'RUNDOWN ACARA (PENCAIRAN <br> HONOR NARASUMBER)', '', $items->item_3_c) !!}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('d', 'SURAT TUGAS NARASUMBER', '', $items->item_3_d) !!}
                                {!! checkbox('e', 'DOKUMENTASI', '', $items->item_3_e) !!}
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="3" class="">
                <b>4. BUKTI KELENGKAPAN BERKAS PENCAIRAN PERJALANAN DINAS</b>
                <table class="no-border" style="width: 100%; margin: 0px; padding:0px">
                    <tr class="">
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('a', 'SURAT TUGAS', '', $items->item_4_a) !!}
                                {!! checkbox('b', 'SPD', '', $items->item_4_b) !!}
                                {!! checkbox('c', 'KWITANSI LS', '', $items->item_4_c) !!}
                                {!! checkbox('d', 'DAFTAR RAMPUNG', '', $items->item_4_d) !!}
                                {!! checkbox('e', 'INVOICE HOTEL', '', $items->item_4_e) !!}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('f', 'TIKET PP', '', $items->item_4_f) !!}
                                {!! checkbox('g', 'DAFTAR RILL', '', $items->item_4_g) !!}
                                {!! checkbox('h', 'UNDANGAN / MEMO', '', $items->item_4_h) !!}
                                {!! checkbox('i', 'LAPORAN PERJALANAN DINAS', '', $items->item_4_i) !!}
                                {!! checkbox('j', 'DOKUMENTASI', '', $items->item_4_j) !!}
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Keterangan : <br><br><br></b>
            </td>
        </tr>
        <tr>
            <td class="text-top" style="width: 35%">
                SAYA MENYATAKAN BAHWA FORM DIISI<br>DENGAN SEBENARNYA PELAKSANA KEGIATAN<br>
                <br>
                <br>
                <br>
                <br>
                <br>
                {{ $receipt->activity_implementer }}
            </td>
            <td class="text-top" style="width: 35%">
                VERIFIKATOR<br>STAF PEJABAT PEMBUAT KOMITMEN<br>TANGGAL<br>
                <br>
                <br>
                <br>
                <br>
                {{ $verifData->user->name }}<br>
                {{ strtoupper($verifData->user->identity_type) }}. {{ strtoupper($verifData->user->identity_number) }}
            </td>
            <td class="text-top">
                NAMA KEGIATAN DI POK : <br>
                {{ $receipt->detail->budgetImplementation->activity->name ?? '-' }}<br><br>
                <br>KODE KEGIATAN / MAX :
                <br>
                {{ $receipt->detail->budgetImplementation->activity->code ?? '-' }} /

            </td>
        </tr>
        <tr>
            <td colspan="3" class="">
                <table class="no-border" style="width:90% ;margin: 0px !important; padding:0px !important">
                    <tr>
                        <td colspan="3"> <span style="font-style: italic;">*)Diisi oleh verifikator</span></td>
                    </tr>
                    <tr>
                        <td colspan="3"> TGL PEMERIKSAAN :
                            {{ \Carbon\Carbon::parse($verifData->date)->translatedFormat('j F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 130px">HASIL PEMERIKSAAN :</td>
                        <td style="width: 30px">
                            <input
                                style='vertical-align: top ;  transform: scale(1.5); margin-top:  -5px !important ; padding-top: -10px  !important ;height: 15px !important'
                                type='checkbox' {{ $verifData->result == 'Y' ? 'checked' : '' }}>

                            {{-- <div class="box"></div> --}}
                        </td>
                        <td>Lengkap</td>
                        <td style="width: 30px">
                            <input
                                style='vertical-align: top ;  transform: scale(1.5); margin-top:  -5px !important ; padding-top: -10px  !important ;height: 15px !important'
                                type='checkbox' {{ $verifData->result == 'N' ? 'checked' : '' }}>

                            {{-- <div class="box"></div> --}}
                        </td>
                        <td>Tidak Lengkap</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="">
                <table class="no-border" style="width:95% ;margin: 0px !important; padding:0px !important">
                    <tr>
                        <td style="width: 230px" class="text-top">Diperiksa Oleh: <br>Satuan Pengawasan Internal

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            {!! $receipt->spi?->name ?? '<br>' !!}
                            <hr>
                            {{ strtoupper($receipt->spi?->employee->identity_type ?? '') }}.
                            {!! strtoupper($receipt->spi?->employee->id) ?? '<br>' !!}

                        </td>
                        <td>
                        </td>
                        <td style="width: 230px" class="text-top">MENYETUJUI: <br>PEJABAT PEMBUAT KOMITMEN

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            @if ($receipt->status == 'accept')
                                {{ $receipt->ppk->name }}
                                <hr>
                                {{ strtoupper($receipt->ppk->employee->identity_type ?? '') }}.
                                {{ strtoupper($receipt->ppk->employee->id) }}
                            @else
                                <br>
                                <hr><br>
                            @endif

                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <!-- Other rows and content -->
    </table>
</body>

</html>
