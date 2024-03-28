<!DOCTYPE html>
<html>

<?php
$imageSrc = 'logo.png';

?>

<head>
    <title>Judul</title>
</head>

<style>
    /* CSS untuk memberikan margin pada tabel */
    html,
    body {
        margin: 20px 20px 20px 20px;
        padding: 3px 3px 3px 3px;
        font-size: 16px;
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
        padding: 2px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .table-stylis {
        margin: 10px;
        margin-top: 4px;
        padding: 4px;
        border-collapse: collapse;
        border: 2px solid #070707;
        border-spacing: 3px;
    }

    .table-stylis td,
    .table-stylis tr,
    .table-stylis th {
        /* border: none; */
        border: 2px solid #070707;
        border-spacing: 3px;
        padding: 10px;
        padding-right: 5px;
        border-collapse: collapse;
    }

    .table-stylis th {
        text-align: center;
        font-weight: bold;
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
        height: 15px;
        border: 1px solid black;
    }

    .f1 {
        font-size: 16;
        letter-spacing: 2px;
        line-height: 1;
    }

    .f2 {
        font-size: 13;
        letter-spacing: 1px;
        line-height: 1;
    }

    .f3 {
        font-size: 13;
        line-height: 0.9;
    }

    .text-top {
        vertical-align: top;
    }

    .page_break {
        page-break-before: always;
    }
</style>

@php

    // echo 'd';
    // dd($items);
@endphp

<body>
    @php $i= 1 @endphp
    @foreach ($receipt->pengikut as $pengikut)
        @if ($i != 1)
            <div class="page_break"></div>
        @endif
        @php $i++ @endphp

        <table style="width:100% ;margin: 0px ; padding :0px; " class="no-border">
            <tr class="sno-border">
                <td style="width: 120px" class="no-border"><img style="width: 130px; height:100px" src="{{ $imageSrc }}"
                        alt="auth-img">
                </td>
                <td class="text-center no-border" style="margin: 0px ; padding:0px">
                    <h4 class="f1" style="margin: 0px ; padding:0px">KEMENTRIAN AGAMA RI
                        <br>
                        INSTITUT AGAMA ISLAM NEGERI (IAIN)
                    </h4>
                    <h4 class="f2" style="margin: 0px ; padding:0px">
                        SYAIKH ABDURRAHMAN SIDDIK<br>
                        BANGKA BELITUNG
                    </h4>
                    <p class="f3" style="margin: 0px ; padding:0px;font-size:13px">Jalan Raya Petaling KM 13 Kec.
                        Mendo
                        Barat Kab.
                        Bangka
                        Prov. Kep. Bangka Belitung 33173<br>
                        E-mail : humas@iainsasbabel.ac.id
                </td>
            </tr>
        </table>
        <hr style="line-height: 0.1; padding-top:0.5px; margin-top:1 ;  height: 0.1px; background-color: #000000;">
        {{-- <hr style="line-height: 0.1; padding-top:0px; margin-top:0 ;  height: 0.1px; background-color: #000000;"> --}}
        <h4 class="f1 text-center" style="margin-left:100px">
            {{ $receipt->perjadin == 'Y' ? 'RINCIAN BIAYA PERJALAN DINAS' : 'DAFTAR TERIMA' }}
        </h4>
        <table class="no-border">
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{{ $receipt->spd_number }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}
                </td>
            </tr>
            <tr>
                <td class="text-top">Kegiatan </td>
                <td class="text-top">:</td>
                <td>{{ $receipt->description }}
                    {{-- Tanggal --}}
                    {{-- {{ \Carbon\Carbon::parse($receipt->activity_date)->translatedFormat('j F Y') }} --}}
                </td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>:</td>
                <td>{{ $receipt->spd_tujuan }}</td>
            </tr>
        </table>
        <table class="table-stylis" style="width:100%">
            <tr>
                <th width="10px" class="text-center ">No</th>
                <th>Perincian Biaya</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
            @php
                $total = 0;
                $row_p = 1;
            @endphp
            @if (!empty($pengikut->datas))
                @foreach (json_decode($pengikut->datas) as $p_data)
                    <tr>
                        <td>
                            {{ $row_p }}
                        </td>
                        <td>
                            {{ $p_data->rinc }}
                        </td>

                        <td>
                            {{ $p_data->desc }}
                        </td>
                        <td class="text-right" style="text-align: right">
                            Rp. {{ number_format((int) $p_data->amount, 0, ',', '.') }}
                        </td>
                        @php $total = $total+ (int) $p_data->amount @endphp
                    </tr>
                    <?php $row_p++; ?>
                @endforeach
            @endif
            <tr>
                <td scope="text-center" colspan="3">
                    <b>Total</b>
                </td>
                <td scope="text-center" style="text-align: right">
                    <b> Rp {{ number_format((int) $total, 0, ',', '.') }}</b>
                </td>
            </tr>

        </table>
        <table class="no-border">
            <tr>
                <td scope="text-top" colspan="1" width="100px">
                    Terbilang
                </td>
                <td scope="text-top" colspan="1" width="10px">
                    :
                </td>
                <td scope="text-center" colspan="1">
                    {{ ucwords(terbilang($total)) }} Rupiah

                </td>
            </tr>
        </table>
        <p></p>
        <table class="no-border" style="width:100%">
            <tr>
                <td width="40%">Pejabat Pembuat Komitmen
                </td>
                <td width="20%"></td>
                <td width="40%">Yang Menerima
                </td>
            </tr>
            <tr>
                <td height="100px">
                </td>
            </tr>
            <tr>
                <td>{{ $receipt->ppk->name }}
                </td>
                <td></td>
                <td> {{ $pengikut->user->name }}
                </td>
            </tr>
            <tr>
                <td>{{ strtoupper($receipt->ppk->employee->identity_type) }}.
                    {{ $receipt->ppk->employee->id }}
                </td>
                <td></td>
                {{-- @dd($pengikut) --}}
                <td>{{ strtoupper($pengikut->user->employee->identity_type) }}.
                    {{ $pengikut->user->employee->id }}
                </td>
            </tr>
        </table>
    @endforeach


    {{-- </th>
        </tr> --}}

    <!-- Other rows and content -->
    {{-- </table> --}}
</body>

</html>
