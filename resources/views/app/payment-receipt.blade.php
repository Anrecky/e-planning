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
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
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

                td:first-child,
                td:nth-child(3),
                td:nth-child(4) {
                    text-align: center;
                }
            }

            .flatpickr-wrapper {
                width: 100%;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <x-custom.statbox>
                <x-custom.alerts />
                <div class="table-responsive my-4 p-2">
                    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
                        <div class="d-flex flex-wrap gap-1 my-2">
                            <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#createModal">Rekam Kuitansi Pembayaran
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-2 my-2">
                            <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
                            <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
                            <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
                        </div>
                    </div>
                    <table id="receipt-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Jenis Kuitansi</th>
                                <th scope="col">Status</th>
                                <th scope="col">Uraian Kegiatan</th>
                                <th scope="col">Tanggal Kegiatan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Pelaksana Kegiatan</th>
                                <th scope="col">Bendahara</th>
                                <th scope="col">PPK</th>
                                <th scope="col">Penyedia</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receipts as $receipt)
                                <tr>
                                    <td>{{ ucfirst(__($receipt->type)) }}</td>
                                    <td>{!! status_receipt($receipt->status) !!}</td>
                                    <td>{{ $receipt->description }}</td>
                                    <td>{{ $receipt->activity_date }}</td>
                                    <td>Rp {{ number_format($receipt->amount, 0, ',', '.') }}</td>
                                    <td>{{ $receipt->activity_implementer ?? '-' }}</td>
                                    <td>{{ $receipt->treasurer->name ?? '-' }}</td>
                                    <td>{{ $receipt->ppk->name }}</td>
                                    <td>{{ $receipt->provider }} {{ $receipt->provider_organization }}</td>
                                    <td class="text-center">
                                        <a class="btn-group btn btn-sm btn-primary temporary-edit"
                                            href="{{ route('payment-receipt.detail', $receipt) }}">
                                            <i data-feather="eye"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-primary temporary-edit"
                                            data-bs-target="#editModal" data-bs-toggle="modal"
                                            data-receipt="{{ $receipt }}"
                                            data-update-url="{{ route('payment-receipt.update', $receipt) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg>
                                        </button>

                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                            onclick="window.confirmDelete({{ $receipt->id }});">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-trash-2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                                <line x1="10" y1="11" x2="10" y2="17">
                                                </line>
                                                <line x1="14" y1="11" x2="14" y2="17">
                                                </line>
                                            </svg>
                                        </a>
                                        <!-- Hidden form for delete request -->
                                        <form id="delete-form-{{ $receipt->id }}"
                                            action="{{ route('payment-receipt.destroy', $receipt->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-custom.statbox>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
        aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Rekam Data Kuitansi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create" action="{{ route('payment-receipt.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 row">
                            <label for="selectTypeReceipt" class="col-sm-2 col-form-label">Jenis Kuitansi</label>
                            <div class="col-sm-8">
                                <select name="type" class="form-select" id="selectTypeReceipt">
                                    <option selected disabled value="">Pilih Jenis Kuitansi...</option>
                                    <option value="direct">Pembayaran Langsung</option>
                                    <option value="treasurer">Pembayaran Langsung (Bendahara)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Uraian
                                Pencairan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="description"
                                    id="inputDisbursementDescription">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityImplementer" class="col-sm-2 col-form-label">Pelaksana
                                Kegiatan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="activity_implementer"
                                    id="inputActivityImplementer">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                            <div class="col-sm-8 flatpickr">
                                <input id="basicFlatpickr" name="activity_date"
                                    class="form-control flatpickr flatpickr-input active text-dark" type="text"
                                    placeholder="Pilih tanggal..">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-8">
                                <input type="text" name="amount" class="form-control" id="inputAmount">
                            </div>
                        </div>
                        <div class="mb-4 row treasurerWrapper ">
                            <label for="selectActivityExecutor" class="col-sm-2 col-form-label">Bendahara</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="treasurer" id="createSelectTreasurer">
                                    <option selected disabled value="">Pilih Bendahara...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row ppkWrapper">
                            <label for="selectVerifier" class="col-sm-2 col-form-label">PPK</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="ppk" id="createSelectPPK">
                                    <option selected disabled value="">Pilih PPK...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputSupplierName" class="col-sm-2 col-form-label">Penyedia PIC</label>
                            <div class="col-sm-8">
                                <input type="text" name="provider" class="form-control" id="inputSupplierName">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputSupplierOrganizationName" class="col-sm-2 col-form-label">Penyedia
                                Badan</label>
                            <div class="col-sm-8">
                                <input type="text" name="provider_organization" class="form-control"
                                    id="inputSupplierOrganizationName">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="selectApprove" class="col-sm-2 col-form-label">Detail COA</label>
                            <div class="col-sm-8">
                                <input hidden type="number" class="form-control" name="detail"
                                    id="selectApproveId">
                                <input readonly disabled type="text" class="form-control" id="selectApproveName">
                            </div>
                            <div class="col-sm-2">
                                <button id="COABtn" type="button" data-bs-target="#COAModal"
                                    data-bs-toggle="modal" class="btn btn-primary btn-lg">...</button>
                            </div>
                        </div>
                        <button id="submitFormCreate" disabled
                            class="btn btn-primary text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- COA Modal -->
    <div class="modal fade" id="COAModal" tabindex="-1" role="dialog" aria-labelledby="COAModalTitle"
        aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="COAModalTitle">Detail COA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4 row">
                        <label for="selectActivityCode" class="col-sm-2 col-form-label">Kode Kegiatan</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="selectActivityCode">
                                <option selected disabled value="">Pilih Kode Kegiatan...</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}"> {{ $activity->code }} -
                                        {{ $activity->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectAccountCode" class="col-sm-2 col-form-label">Kode Akun</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="selectAccountCode">
                                <option selected disabled value="">Pilih Kode Akun...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectBudgetDetail" class="col-sm-2 col-form-label">Detail</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="selectBudgetDetail">
                                <option selected disabled value="">Pilih Detail...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="totalBudget" class="col-sm-2 col-form-label">Jumlah Pagu</label>
                        <div class="col-sm-8">
                            <input style="color:gray;" readonly disabled type="text" class="form-control"
                                id="totalBudget">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="remainingBudget" class="col-sm-2 col-form-label">Sisa Pagu</label>
                        <div class="col-sm-8">
                            <input style="color:gray;" readonly disabled type="text" class="form-control"
                                id="remainingBudget">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                        <button id="saveCOA" data-bs-target="#createModal" data-bs-toggle="modal"
                            class="btn btn-primary text-center align-items-center mt-2 py-auto" type="button">
                            <span class="icon-name">Simpan</span>
                        </button>
                        <button id="cancelCOA" data-bs-target="#createModal" data-bs-toggle="modal"
                            class="btn btn-danger text-center align-items-center mt-2 py-auto" type="button">
                            <span class="icon-name">Batal</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <x-custom.payment-receipt.edit-modal />

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('plugins-rtl/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins-rtl/input-mask/input-mask.js') }}"></script> --}}
        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })

            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                const editModalEl = document.getElementById('editModal');
                let receiptEditData;

                $('#receipt-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'btn btn-danger', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'PDF_Export_' + n;
                            },
                            customize: function(doc) {
                                doc.styles.tableHeader.alignment = 'left'; // Contoh penyesuaian
                                // Tambahkan kustomisasi pdfmake Anda di sini
                                doc.content[1].table.widths = ['auto', '*', '*'];
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-success', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'Excel_Export_' + n;
                            },
                        }
                    ],
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Cari Kuitansi...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });

                $('#inputAmount').inputmask({
                    alias: 'numeric',
                    groupSeparator: '.',
                    autoGroup: true,
                    digits: 0,
                    prefix: 'Rp ',
                    placeholder: '0'
                });

                // On Shown Create Modal
                $('#createModal').on('shown.bs.modal', function(modalEvent) {
                    const inputAmountEl = document.getElementById("inputAmount");
                    flatpickr($("#form-create").find('#basicFlatpickr'), {
                        defaultDate: new Date(),
                        static: true,
                    });
                    // Restrict keyboard input
                    $('#inputAmount').on('keydown', window.allowOnlyNumericInput);
                    // Handle paste events
                    $('#inputAmount').on('paste', window.handlePaste);

                    // $('#inputAmount').on('keyup', function() {
                    //     console.log('up')
                    //     $(this).val(format_number($(this).val()))
                    // })


                    handleSelectTypeReceipt($('#selectTypeReceipt'))
                    $('#createSelectPPK').select2({
                        dropdownParent: $("#form-create").find('.ppkWrapper'),
                        placeholder: 'Pilih PPK',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ route('ppks.index') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results
                                        success({
                                            results: response.data.map(function(item) {
                                                return {
                                                    id: item.id,
                                                    text: item.nik + ' - ' +
                                                        item
                                                        .name
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        // Call the `failure` function in case of an error
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });
                    $('#createSelectTreasurer').select2({
                        dropdownParent: $("#form-create").find('.treasurerWrapper'),
                        placeholder: 'Pilih Bendahara',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ route('treasurers.index') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results
                                        success({
                                            results: response.data.map(function(item) {
                                                return {
                                                    id: item.id,
                                                    text: item.nik + ' - ' +
                                                        item
                                                        .name
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        // Call the `failure` function in case of an error
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });
                    if (modalEvent.relatedTarget?.id !== "saveCOA" && modalEvent.relatedTarget?.id !==
                        "cancelCOA") {

                        $("#selectApproveId").val("");
                        $("#selectApproveName").val("");
                        $("#selectTypeReceipt").val("");
                        $("#inputDisbursementDescription").val("");
                        $("#inputAmount").val("");

                        if ($('#selectTypeReceipt').val() === '' || $('#selectTypeReceipt').val() === null || $(
                                '#selectApproveId').val() === '' || $('#selectApproveId').val() === '') {
                            $("#submitFormCreate").prop('disabled', true);
                        } else {
                            $("#submitFormCreate").prop('disabled', false);
                        }
                    }

                    $("#selectTypeReceipt").on('change', function(selectEvent) {
                        if (selectEvent.currentTarget.value === 'direct') {
                            $("#createSelectTreasurer").val(null)
                        }
                        if (selectEvent.currentTarget.value === '' || selectEvent.currentTarget
                            .value ===
                            null) {
                            $("#submitFormCreate").prop('disabled', true);
                        } else {
                            $("#submitFormCreate").prop('disabled', false);
                        }
                    })
                }).on('hidden.bs.modal', function() {
                    $('#createSelectPPK').select2('destroy');
                    $('#createSelectTreasurer').select2('destroy');
                    flatpickr($("#form-create").find('#basicFlatpickr')).destroy();
                });

                // On Shown Edit Modal
                $(editModalEl).on('shown.bs.modal', async function(e) {
                    if (e.relatedTarget.classList.contains('temporary-edit')) {
                        receiptEditData = $(e.relatedTarget).data('receipt');
                    }
                    let receipt = receiptEditData;
                    let updateUrl = $(e.relatedTarget).data('updateUrl');
                    const formEdit = $("#form-edit");

                    formEdit.attr('action', updateUrl);
                    formEdit.find('#selectTypeReceipt').val(receipt.type);
                    formEdit.find('#inputDisbursementDescription').val(receipt.description);
                    formEdit.find('#inputActivityImplementer').val(receipt.activity_implementer);
                    formEdit.find('#inputSupplierName').val(receipt.provider);
                    formEdit.find('#inputSupplierOrganizationName').val(receipt.provider_organization);
                    formEdit.find('#selectApproveId').val(receipt.budget_implementation_detail_id);
                    formEdit.find('#selectApproveName').val(receipt.detail?.name);
                    flatpickr(formEdit.find('#basicFlatpickr'), {
                        defaultDate: receipt.activity_date,
                        static: true,
                    });
                    const inputAmountEl = formEdit.find("#inputAmount");
                    inputAmountEl.val(parseInt(receipt.amount));
                    // Restrict keyboard input
                    inputAmountEl.on('keydown', window.allowOnlyNumericInput);
                    // Handle paste events
                    inputAmountEl.on('paste', window.handlePaste);

                    formEdit.find('#inputAmount').inputmask({
                        alias: 'numeric',
                        groupSeparator: '.',
                        autoGroup: true,
                        digits: 0,
                        prefix: 'Rp ',
                        placeholder: '0'
                    });
                    // inputAmountEl.trigger('keydown', () => {
                    console.log('trigger')
                    // })
                    handleSelectTypeReceipt($('#selectTypeReceipt'));
                    $('#editSelectPPK').select2({
                        dropdownParent: formEdit.find('.ppkWrapper'),
                        placeholder: 'Pilih PPK',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ route('ppks.index') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results

                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item.id,
                                                    text: item.nik + ' - ' +
                                                        item
                                                        .name
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        // Call the `failure` function in case of an error
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });

                    // create the option and append to Select2
                    var option = new Option(`${receipt.ppk.nik} - ${receipt.ppk.name}`, receipt.ppk.id,
                        true,
                        true);
                    $('#editSelectPPK').append(option).trigger('change');

                    $('#editSelectTreasurer').select2({
                        dropdownParent: formEdit.find('.treasurerWrapper'),
                        placeholder: 'Pilih Bendahara',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ route('treasurers.index') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results
                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item.id,
                                                    text: item.nik + ' - ' +
                                                        item
                                                        .name
                                                };
                                            })
                                        });
                                    })
                                    .catch(function(error) {
                                        // Call the `failure` function in case of an error
                                        failure(error);
                                    });
                            },
                            delay: 250,
                            cache: true
                        }
                    });

                    // create the option and append to Select2
                    var selectedTreasurerOption = new Option(
                        `${receipt.treasurer?.nik ?? ''} - ${receipt.treasurer?.name ?? ''}`, receipt
                        .treasurer?.id ?? null, true, true);
                    $('#editSelectTreasurer').append(selectedTreasurerOption).trigger('change');

                }).on('hidden.bs.modal', function() {
                    const formEdit = $("#form-edit");
                    flatpickr(formEdit.find('#basicFlatpickr')).destroy();
                })
                $('#COAModal').on('show.bs.modal', function(e) {
                    if (e.relatedTarget.id !== 'editCOABtn') {
                        $('#selectActivityCode').val("");
                        $('#selectAccountCode').val("");
                        $('#selectBudgetDetail').val("");
                        $('#totalBudget').val("");
                        $("#remainingBudget").val("");
                    }
                })
                // On Show COA Modal
                $('#COAModal').on('shown.bs.modal', async function(e) {
                    var isEdit = e.relatedTarget.id == 'editCOABtn';

                    $('#selectActivityCode').on('change', async function(selectEvent) {
                        $('input,#selectBudgetDetail', '.modal.show .modal-body').val(null);
                        // Get Elements
                        const selectAccountCode = document.getElementById('selectAccountCode');

                        // Data Source
                        const accountCodesData = await getAccountCodesByActivityID(selectEvent
                            .currentTarget.value);

                        // Convert accountCodesData to options array
                        const accountCodesOptions = accountCodesData.map(accountCode => ({
                            value: accountCode.id,
                            text: accountCode.name
                        }));

                        // Populate select options
                        window.populateSelectWithOptions(selectAccountCode, accountCodesOptions,
                            'Pilih Kode Akun');


                    });
                    await $('#selectAccountCode').on('change', async function(selectEvent) {
                        $('input', '.modal.show .modal-body').val(formatAsIDRCurrency(0.00));
                        // Get Elements
                        const selectBudgetDetail = document.getElementById(
                            'selectBudgetDetail');

                        // Get Select Activity Value
                        const selectActivityID = document.getElementById('selectActivityCode')
                            .value;

                        // Data Source
                        const budgetImplementationDetailsData =
                            await getBudgetImplementationDetailsByActivityIDAndAccountCodeID(
                                selectActivityID, selectEvent
                                .currentTarget.value);

                        // Convert budgetImplementationDetailsData to options array
                        const budgetImplementationDetailsOptions =
                            budgetImplementationDetailsData
                            .map(
                                budgetImplementation => ({
                                    value: budgetImplementation.id,
                                    text: budgetImplementation.name
                                }));

                        // Populate select options
                        window.populateSelectWithOptions(selectBudgetDetail,
                            budgetImplementationDetailsOptions, 'Pilih Detail');

                    });
                    $('#selectBudgetDetail').on('change', async function(selectEvent) {
                        const detailData = await getDetail(selectEvent.currentTarget.value);
                        $("#totalBudget").val(formatAsIDRCurrency(detailData.total));
                        const detailTotalAmount = await getReceiptAmountByDetailId(detailData
                            .id);
                        const remainingBudget = detailData.total - detailTotalAmount;
                        $("#remainingBudget").val(formatAsIDRCurrency(remainingBudget));
                    });
                    if (isEdit) {
                        $(".modal.show #cancelCOA").attr('data-bs-target', '#editModal');
                        $(".modal.show #saveCOA").attr('data-bs-target', '#editModal');
                        const {
                            budget_implementation: {
                                activity,
                                account_code
                            }
                        } = await getDetail(receiptEditData.budget_implementation_detail_id);
                        await $('#selectActivityCode').val(activity.id).change();
                        setTimeout(() => {
                            $('#selectAccountCode').val(account_code.id).change();
                        }, 100);
                        setTimeout(() => {
                            $('#selectBudgetDetail').val(receiptEditData
                                .budget_implementation_detail_id).change();
                        }, 150);
                    } else {
                        $(".modal.show #cancelCOA").attr('data-bs-target', '#createModal');
                        $(".modal.show #saveCOA").attr('data-bs-target', '#createModal');
                    }
                    $("#saveCOA").on('click', function() {
                        const selectApproveNameEl = document.getElementById("selectApproveName");
                        const selectApproveIdEl = document.getElementById("selectApproveId");
                        // Get the select element
                        const selectDetail = document.getElementById('selectBudgetDetail');
                        if (isEdit) {
                            receiptEditData.budget_implementation_detail_id = selectDetail.value;
                            if (receiptEditData.detail) {
                                receiptEditData.detail.name = selectDetail.options[selectDetail
                                    .selectedIndex].textContent;
                            }
                        }

                        selectApproveIdEl.value = selectDetail.value;
                        selectApproveNameEl.value = selectDetail.options[selectDetail
                            .selectedIndex].textContent;
                    });

                });

                // Get Account Codes By Activity ID
                async function getAccountCodesByActivityID(activityID) {
                    // Axios POST request
                    try {
                        const response = await axios.get(`/api/activity/${activityID}/account-codes`);
                        return response.data;
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
                // Get Budget Implementations By Activity ID & Account Code ID
                async function getBudgetImplementationDetailsByActivityIDAndAccountCodeID(activityID, accountCodeID) {
                    // Axios POST request
                    try {
                        const response = await axios.get(
                            `/api/details/${activityID}/${accountCodeID}`);
                        return response.data;
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

                async function getDetail(detailID) {
                    // Axios POST request
                    try {
                        const response = await axios.get(
                            `/api/detail/${detailID}`);
                        return response.data;
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

                // Get Receipt Amount By Budget Implementation Detail Id
                async function getReceiptAmountByDetailId(detailID) {
                    // Axios POST request
                    try {
                        const response = await axios.get(`/api/receipt/total-amount/${detailID}`);
                        return response.data
                        // return response.data;
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: `Terjadi kesalahan. Silahkan coba sesaat lagi. ${error}`,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

                // On Change Select Type Receipt
                $('#selectTypeReceipt').on('change', handleSelectTypeReceipt);

                function handleSelectTypeReceipt(e) {
                    if ((e.hasOwnProperty('originalEvent') ? e.currentTarget.value : $(e).val()) === 'treasurer') {
                        $('.treasurerWrapper').fadeIn();
                    }
                    if ((e.hasOwnProperty('originalEvent') ? e.currentTarget.value : $(e).val()) === 'direct') {
                        $('.treasurerWrapper').fadeOut();
                    }
                }
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
