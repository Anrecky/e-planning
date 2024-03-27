<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/flatpickr/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/noUiSlider/nouislider.min.css') }}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        {{-- @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss']) --}}
        {{-- @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss']) --}}
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
            td,
            th {
                border-radius: 0px !important;
            }

            th {
                color: white !important;
            }

            a.text-danger {
                transition: color 0.3s ease;
            }

            a.text-danger:hover {
                color: #dc3545;
            }

            .icon-trash {
                width: 30px;
                height: 30px;
                color: #dc3545;
            }

            #add-account_code_btn,
            #add-expenditure_detail_btn {
                opacity: 0;
                visibility: hidden;

                &.show {
                    opacity: 1;
                    visibility: visible;
                }
            }

            th,
            tr {
                td:first-child {
                    font-weight: bold !important;
                }

                &.selected td {
                    background-color: #2196f3 !important;
                    color: white;
                }

                &.activity-row td {
                    background-color: #fcf5e9;
                    font-weight: bold !important;
                    font-style: italic !important;
                }

                &.account-row td {
                    font-style: italic !important;
                }

                td {
                    text-align: left;
                }
            }

            .flatpickr-wrapper {
                width: 100%;
            }

            .checklist .cl-box {
                height: 25px;
                width: 25px
            }

            .checklist hr {
                border: 3px solid rgb(50, 51, 53);
                border-radius: 5px;
            }

            .checklist .form-check-input {
                /* background-color: blue; */
                /* border-color: blue */
            }

            .c-modal-bg {
                /* position: fixed; */
                /* top: 0; */
                /* left: 0; */
                /* z-index: 1040; */
                /* width: 100vw; */
                /* height: 100vh; */
                /* background-color: rgba(0, 0, 0, 0.4); */
                /* backdrop-filter: blur(15px); */
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kwitansi </a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <x-custom.statbox>
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="float-start"> Detail
                                Kwitansi {!! status_receipt($receipt->status) !!}</h4>
                            {{-- @dd($receipt->ppk->employee->head_id) --}}
                            @if (in_array($receipt->status, ['wait-verificator', 'reject-verificator', 'wait-ppk']) &&
                                    $receipt->ppk->employee->head_id == Auth::user()->employee?->id &&
                                    $receipt->ppk->employee->head_id != null)
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.verification-modal :receipt="$receipt" />
                                </div>
                            @endif
                            @if ($receipt->status == 'accept' && $receipt->ppk->head_id == Auth::user()->employee?->id)
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.app-money-modal :receipt="$receipt" />
                                </div>
                            @endif
                            @if (in_array($receipt->status, ['wait-ppk', 'reject-ppk', 'accept']) && $receipt->ppk_id == Auth::user()->id)
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.ppk-modal :receipt="$receipt" />
                                </div>
                            @endif
                            @if (in_array($receipt->status, ['wait-treasurer', 'reject-treasurer', 'accept']) &&
                                    $receipt->treasurer_id == Auth::user()->id)
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.treasurer-modal :receipt="$receipt" />
                                </div>
                            @endif
                            @if (in_array($receipt->status, ['wait-spi', 'reject-spi']) && Auth::user()->hasRole('SPI'))
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.spi-modal :receipt="$receipt" />
                                </div>
                            @endif
                            @if (in_array($receipt->status, ['draft', 'reject-verificator', 'reject-ppk', 'reject-spi']) &&
                                    $receipt->user_entry == Auth::user()->id)
                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.submit-modal :receipt="$receipt" />
                                </div>

                                <div class="float-end p-2">
                                    <x-custom.payment-receipt.rampung-modal :receipt="$receipt" />
                                </div>
                            @endif


                        </div>

                    </div>
                </div>
                <div class="widget-content widget-content-area p-3">
                    <div class="simple-pill">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-icon-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home-icon" type="button" role="tab"
                                    aria-controls="pills-home-icon" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Resume
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-icon-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile-icon" type="button" role="tab"
                                    aria-controls="pills-profile-icon" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    COA
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-icon-tab" data-bs-toggle="pill"
                                    data-bs-target="#rampung" type="button" role="tab"
                                    aria-controls="pills-profile-icon" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Rampung
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-icon-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-document" type="button" role="tab"
                                    aria-controls="pills-document" aria-selected="false">
                                    <i data-feather="file-text"></i>
                                    Dokumen
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-icon-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-log" type="button" role="tab"
                                    aria-controls="pills-log" aria-selected="false">
                                    <i data-feather="clock"></i>
                                    Log
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel"
                                aria-labelledby="pills-home-icon-tab" tabindex="0">
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription"
                                            class="col-sm-2 col-form-label">Nomor Surat
                                        </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">{{ $receipt->reference_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription"
                                            class="col-sm-2 col-form-label">Uraian
                                            Pencairan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">{{ $receipt->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Jenis Kuitansi</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->type == 'direct' ? 'Pembayaran Langsung' : ($receipt->type == 'treasurer' ? 'Pembayaran Langsung (Bendahara)' : '') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Pelaksana</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->pelaksana->name }} /
                                                {{ $receipt->pelaksana->id }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Tanggal Kegiatan</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->activity_date }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Jumlah</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                Rp. {{ number_format($receipt->amount, 0, '.', ',') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Bendahara</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                @if ($receipt->treasurer)
                                                    {{ $receipt->treasurer?->name }} /
                                                    {{ $receipt->treasurer?->id }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            PPK</label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->ppk->name }} /
                                                {{ $receipt->ppk->id }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Verifikator </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                @if ($receipt->verification->last())
                                                    {{-- @dd($receipt) --}}
                                                    {{ $receipt->verification->last()->user->name }} (
                                                    {{ $receipt->verification->last()->date }})
                                                @else
                                                    {{ $receipt->ppk->employee_staff?->headOf?->user->name }} ( Belum
                                                    Diverifikasi)
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Penyedia PIC </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->provider }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Penyedia Badan </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->provider_organization }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel"
                                aria-labelledby="pills-profile-icon-tab" tabindex="0">
                                <div class="col-lg-12">
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Kode Kegiatan </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->detail->budgetImplementation->activity->code ?? '-' }} |
                                                {{ $receipt->detail->budgetImplementation->activity->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Kode Akun </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->detail->budgetImplementation->accountCode->code ?? '-' }}
                                                |
                                                {{ $receipt->detail->budgetImplementation->accountCode->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Detail </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                {{ $receipt->detail->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">
                                            Jumlah Pagu </label>
                                        <div class="col-sm-8">
                                            <p class="form-control">
                                                Rp. {{ number_format($receipt->detail->total, 2, '.', ',') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-document" role="tabpanel"
                                aria-labelledby="pills-icon-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td scope="text-center"><b>Name</b></td>
                                                <td class="text-center" style="width: 300px"><b>Download</b></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Kwitansi
                                                </td>
                                                <td class="text-center">
                                                    <a target="_blank"
                                                        href="{{ route('payment-receipt.print-kwitansi', $receipt) }}">
                                                        <span class="badge badge-light-success">Download</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @if ($receipt->perjadin == 'Y')
                                                <tr>
                                                    <td>
                                                        Rampung
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank"
                                                            href="{{ route('payment-receipt.print-rampung', $receipt) }}">
                                                            <span class="badge badge-light-success">Download</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($receipt->ppk->head_id == Auth::user()->employee?->id)
                                                <tr>
                                                    <td>
                                                        Draft Form Verifikasi
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank"
                                                            href="{{ route('payment-receipt.print-ticket', $receipt) }}">
                                                            <span class="badge badge-light-success">Download</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    Berkas
                                                </td>
                                                <td class="text-center">
                                                    @if ($receipt->berkas)
                                                        <a target="_blank"
                                                            href="{{ url('storage/berkas_receipt/' . $receipt->berkas) }}">
                                                            <span class="badge badge-light-success">Download</span>
                                                        </a>
                                                    @else
                                                        <span class="badge badge-light-danger">Tidak ada berkas</span>
                                                    @endif

                                                    @if (Auth::user()->id == $receipt->user_entry &&
                                                            in_array($receipt->status, ['draft', 'reject-verificator', 'reject-ppk', 'reject-spi']))
                                                        <br>
                                                        <x-custom.payment-receipt.upload-modal :receipt="$receipt" />
                                                    @endif
                                                </td>
                                            </tr>
                                            @foreach ($receipt->verification as $verif)
                                                <tr>
                                                    <td>
                                                        Hasil Verifikasi {{ $verif->created_at }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a target="_blank" style=""
                                                            href="{{ route('payment-receipt.print-ticket', [$receipt, $verif]) }}">
                                                            <span class="badge badge-light-success">Download</span>
                                                        </a>
                                                        @if (Auth::user()->id == $verif->verification_user &&
                                                                in_array($receipt->status, ['reject-verificator', 'wait-verificator', 'wait-spi']))
                                                            <x-custom.payment-receipt.verification-modal
                                                                :receipt="$receipt" :dataVerif="$verif"
                                                                :btnText="'edit'" />
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="rampung" role="tabpanel"
                                aria-labelledby="pills-icon-tab" tabindex="0">
                                {{-- <div class="table-responsive"> --}}

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="text-center">
                                            <td scope="col" style="width: 20px"><b>No</b></td>
                                            <td scope="col"><b>Perincian</b></td>
                                            <td scope="col"><b>Keterangan</b></td>
                                            <td scope="col"><b>Rupiah</b></td>
                                        </tr>
                                        @foreach ($receipt->pengikut as $pengikut)
                                            <tr>
                                                <td scope="text-center" colspan="4">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="text-center" colspan="4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-arrow-right">
                                                        <line x1="5" y1="12" x2="19"
                                                            y2="12"></line>
                                                        <polyline points="12 5 19 12 12 19"></polyline>
                                                    </svg> <b>{{ $pengikut->user->name }}</b>
                                                </td>
                                            </tr>
                                            <?php
                                            $row_p = 1;
                                            $total = 0;
                                            ?>
                                            @if (!empty($pengikut->datas))
                                                @foreach (json_decode($pengikut->datas) as $p_data)
                                                    <tr>
                                                        <td>
                                                            <p>{{ $row_p }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $p_data->rinc }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ $p_data->desc }}</p>
                                                        </td>
                                                        <td class="text-right" style="text-align: right">
                                                            <p class="text-right">
                                                                {{ number_format((int) $p_data->amount, 0, ',', '.') }}
                                                            </p>
                                                        </td>
                                                        @php $total = $total+ (int) $p_data->amount @endphp
                                                    </tr>
                                                    <?php $row_p++; ?>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td scope="text-center" colspan="3">
                                                    Total
                                                </td>
                                                <td scope="text-center" style="text-align: right">
                                                    {{ number_format((int) $total, 0, ',', '.') }}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- </div> --}}
                            </div>
                            <div class="tab-pane fade" id="pills-log" role="tabpanel"
                                aria-labelledby="pills-icon-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td scope="text-center"><b>Waktu</b></td>
                                                <td class="text-center" style="width: 300px"><b>User</b></td>
                                                <td class="text-center"><b>Keterangan</b></td>
                                                <td class="text-center"><b></b></td>
                                            </tr>
                                            @foreach ($receipt->logs as $log)
                                                <tr>
                                                    <td>
                                                        {{ $log->created_at }}
                                                    </td>
                                                    <td>
                                                        {{ $log->user->name }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ $log->description }}
                                                    </td>
                                                    <td>
                                                        {{ $log->relation_id }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-custom.statbox>
        </div>

    </div>

    <x-custom.payment-receipt.edit-modal />

    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script type="module" src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <!-- Select2 JS -->
        <script src="{{ asset('plugins-rtl/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins-rtl/input-mask/input-mask.js') }}"></script> --}}

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
