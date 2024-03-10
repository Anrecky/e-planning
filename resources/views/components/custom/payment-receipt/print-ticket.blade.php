<!DOCTYPE html>
<html>

<?php
$imageSrc = 'logo.png';

function checkbox($number, $desc, $span = 'ADA')
{
    return "<tr class='no-border'>
                                    <td class='no-border'>$number.</td>
                                    <td class='no-border'>$desc</td>
                                    <td class='no-border'><div class='box'></div></td>
                                    <td class='no-border'>$span </td>
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
        font-size: 14px;
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

<body>
    <table style="width: 100%">
        <tr>
            <th colspan="3" class="text-center">
                <table style="width:100% ;margin: 0px ; padding :0px; ">
                    <tr>
                        <td style="width: 150px"><img style="width: 150px" src="{{ $imageSrc }}" alt="auth-img"></td>
                        <td class="text-center">
                            <h4>KEMENTRIAN AGAMA RI <br>
                                INSTITUT AGAMA ISLAM NEGERI <br>
                                SYAIKH ABDURRAHMAN SIDDIK <br>
                                BANGKA BELITUNG <br> <br>
                                FORMULIR VERIFIKASI</h4>
                        </td>
                        <td>
                            <p style="margin-left: 10px !important">Nomor : <br><br>Tanggal : <br><br> <span
                                    style="font-style: italic;">(diisi
                                    verifikator)</span></p>
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr class="text-center">
            <td colspan="3" class="text-center">
                <b> MOHON DI ISI DENGAN HURUF KAPITAL</b>
            </td>
        </tr>
        <tr class="text-center">
            <td colspan="3" class="">
                <b>1. Jenis Pencairan </b>
                <table style="width: 100%" class="no-border">
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
                            ({{ ucwords(terbilang($receipt->amount)) }})</td>
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
                                {!! checkbox('a', 'SPBy/Kwitansi LS') !!}
                                {!! checkbox('b', 'NOTA / INVOICE') !!}
                                {!! checkbox('c', 'NMR, TGL, TANDATANGAN DAN <br>CAP PADA DOKUMEN') !!}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('d', 'FOTOCOPY NPWP (SUPLIER BARU)') !!}
                                {!! checkbox('e', 'FOTOCOPY BUKU REKENING<br> (SUPLIER BARU)') !!}
                                {!! checkbox('f', 'DOKUMENTASI') !!}
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
                                {!! checkbox('a', 'DAFTAR HONOR') !!}
                                {!! checkbox('b', 'SK') !!}
                                {!! checkbox('c', 'RUNDOWN ACARA (PENCAIRAN <br> HONOR NARASUMBER)', 'LENGKAP') !!}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('d', 'SURAT TUGAS NARASUMBER') !!}
                                {!! checkbox('e', 'DOKUMENTASI') !!}
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
                                {!! checkbox('a', 'SURAT TUGAS') !!}
                                {!! checkbox('b', 'SPD') !!}
                                {!! checkbox('c', 'KWITANSI LS') !!}
                                {!! checkbox('d', 'DAFTAR RAMPUNG') !!}
                                {!! checkbox('e', 'INVOICE HOTEL') !!}
                            </table>
                        </td>
                        <td style="width : 50%">
                            <table class="no-border" style="width: 90%">
                                {!! checkbox('f', 'TIKET PP') !!}
                                {!! checkbox('g', 'DAFTAR RILL') !!}
                                {!! checkbox('h', 'UNDANGAN / MEMO') !!}
                                {!! checkbox('i', 'LAPORAN PERJALANAN DINAS') !!}
                                {!! checkbox('j', 'DOKUMENTASI') !!}
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
                SAYA MENYATAKAN BAHWA FORM DIISI DENGAN SEBENARNYA <br>PELAKSANA KEGIATAN<br>TANGGAL<br>
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
                {{ $receipt->activity_implementer }}
            </td>
            <td class="text-top">
                NAMA KEGIATAN DI POK :<br><br><br>
                <br>
                <br>KODE KEGIATAN / MAX :
                <br>

            </td>
        </tr>
        <tr>
            <td colspan="3" class="">
                <table class="no-border" style="width:90% ;margin: 0px !important; padding:0px !important">
                    <tr>
                        <td colspan="3"> <span style="font-style: italic;">*)Diisi oleh verifikator</span></td>
                    </tr>
                    <tr>
                        <td colspan="3"> TGL PEMERIKSAAN :</td>
                    </tr>
                    <tr>
                        <td>HASIL PEMERIKSAAN :</td>
                        <td>
                            <div class="box"></div>
                        </td>
                        <td>Lengkap</td>
                        <td>
                            <div class="box"></div>
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
                            <hr>
                            NIP.
                        </td>
                        <td>
                        </td>
                        <td style="width: 230px" class="text-top">MENYETUJUI: <br>PEJABAT PEMBUAT KOMITMEN

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            {{ $receipt->ppk->name }}
                            <hr>
                            NIP.

                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <!-- Other rows and content -->
    </table>
</body>

</html>
