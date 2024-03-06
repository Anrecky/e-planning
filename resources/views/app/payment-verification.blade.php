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
                <div class="table-responsive my-4">
                    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1 px-2">
                        <div class="d-flex flex-wrap gap-1 my-2">
                            <button id="btnCreateModal" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#createModal">Rekam Verifikasi Pembayaran
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-2 my-2">
                            <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
                            <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
                            <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
                        </div>
                    </div>
                    <table id="payment_verification-table" class="table table-bordered my-3">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Uraian Pencairan</th>
                                <th scope="col">Tanggal Kegiatan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Nama Penyedia</th>
                                <th scope="col">Pelaksana Kegiatan</th>
                                <th scope="col">Verifikator</th>
                                <th scope="col">SPI</th>
                                <th scope="col">PPK</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_verifications as $payment_verification)
                                <tr>
                                    <td>{{ $payment_verification->description }}</td>
                                    <td>{{ $payment_verification->activity_date }}</td>
                                    <td>Rp {{ number_format($payment_verification->amount, 0, ',', '.') }}</td>
                                    <td>{{ $payment_verification->provider }}</td>
                                    <td>{{ $payment_verification->implementer_name ?? '-' }}</td>
                                    <td>{{ $payment_verification->verificator->name }}</td>
                                    <td>{{ $payment_verification->auditor_name }}</td>
                                    <td>{{ $payment_verification->ppk->name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary temporary-edit"
                                            data-bs-target="#editModal" data-bs-toggle="modal"
                                            data-payment-verification="{{ $payment_verification }}"
                                            data-update-url="{{ route('payment-verification.update', $payment_verification) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg>
                                        </button>

                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                            onclick="window.confirmDelete({{ $payment_verification->id }});">
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
                                        <form id="delete-form-{{ $payment_verification->id }}"
                                            action="{{ route('payment-verification.destroy', $payment_verification->id) }}"
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
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Rekam Data Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create" method="POST" action="{{ route('payment-verification.store') }}">
                        @csrf
                        <div class="mb-4 row">
                            <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Uraian
                                Pencairan</label>
                            <div class="col-sm-8">
                                <input type="text" required name="description" class="form-control"
                                    id="inputDisbursementDescription">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="date" id="inputActivityDate" name="activity_date"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-8">
                                <input type="number" name="amount" class="form-control" id="inputAmount">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputSupplierName" class="col-sm-2 col-form-label">Nama Penyedia</label>
                            <div class="col-sm-8">
                                <input type="text" required name="provider" class="form-control"
                                    id="inputSupplierName">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="activityImplementer" class="col-sm-2 col-form-label">Pelaksana
                                Kegiatan</label>
                            <div class="col-sm-8">
                                <input type="hidden" required class="form-control" name="activity_implementer_nip"
                                    id="activityImplementerNIP">
                                <input readonly required="text" class="form-control" name="activity_implementer_name"
                                    id="activityImplementerName">
                            </div>
                            <div class="col-sm-2">
                                <button type="button"
                                    class="btn btn-primary btn-lg btnInputActivityImplementer">...</button>
                            </div>
                        </div>
                        <div class="mb-4 row verificatorWrapper">
                            <label for="createSelectVerificator" class="col-sm-2 col-form-label">Verifikator</label>
                            <div class="col-sm-8">
                                <select required class="form-select" name="verificator" id="createSelectVerificator">
                                    <option selected disabled value="">Pilih Verifikator...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="spiName" class="col-sm-2 col-form-label">SPI</label>
                            <div class="col-sm-8">
                                <input required type="hidden" name="spi_nip" id="spiNIP">
                                <input required readonly type="text" class="form-control" name="spi_name"
                                    id="spiName">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary btn-lg btnInputSPI">...</button>
                            </div>
                        </div>
                        <div class="mb-4 row ppkWrapper">
                            <label for="selectVerifier" class="col-sm-2 col-form-label">PPK</label>
                            <div class="col-sm-8">
                                <select required class="form-select" name="ppk" id="createSelectPPK">
                                    <option selected disabled value="">Pilih PPK...</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Data Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-edit" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4 row">
                            <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Uraian
                                Pencairan</label>
                            <div class="col-sm-8">
                                <input type="text" required name="description" class="form-control"
                                    id="inputDisbursementDescription">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="date" id="inputActivityDate" name="activity_date"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-8">
                                <input type="number" name="amount" class="form-control" id="inputAmount">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputSupplierName" class="col-sm-2 col-form-label">Nama Penyedia</label>
                            <div class="col-sm-8">
                                <input type="text" required name="provider" class="form-control"
                                    id="inputSupplierName">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="activityImplementer" class="col-sm-2 col-form-label">Pelaksana
                                Kegiatan</label>
                            <div class="col-sm-8">
                                <input type="hidden" required class="form-control" name="activity_implementer_nip"
                                    id="activityImplementerNIP">
                                <input readonly required="text" class="form-control" name="activity_implementer_name"
                                    id="activityImplementerName">
                            </div>
                            <div class="col-sm-2">
                                <button type="button"
                                    class="btn btn-primary btn-lg btnInputActivityImplementer">...</button>
                            </div>
                        </div>
                        <div class="mb-4 row verificatorWrapper">
                            <label for="createSelectVerificator" class="col-sm-2 col-form-label">Verifikator</label>
                            <div class="col-sm-8">
                                <select required class="form-select" name="verificator" id="createSelectVerificator">
                                    <option selected disabled value="">Pilih Verifikator...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="spiName" class="col-sm-2 col-form-label">SPI</label>
                            <div class="col-sm-8">
                                <input required type="hidden" name="spi_nip" id="spiNIP">
                                <input required readonly type="text" class="form-control" name="spi_name"
                                    id="spiName">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary btn-lg btnInputSPI">...</button>
                            </div>
                        </div>
                        <div class="mb-4 row ppkWrapper">
                            <label for="selectVerifier" class="col-sm-2 col-form-label">PPK</label>
                            <div class="col-sm-8">
                                <select required class="form-select" name="ppk" id="createSelectPPK">
                                    <option selected disabled value="">Pilih PPK...</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-warning text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Edit</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Input PIC Modal -->
    <div class="modal fade" id="inputPICModal" tabindex="-1" aria-labelledby="inputPICModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputPICModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4 row align-items-center">
                        <label for="inputFullName" class="col-sm-4 col-form-label">Nama
                            Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" id="inputFullName">
                        </div>
                    </div>
                    <div class="mb-4 row align-items-center">
                        <label for="inputNumberId" class="col-sm-4 col-form-label">NIP/NIK/NIDN</label>
                        <div class="col-sm-8">
                            <input type="text" name="nip" class="form-control" id="inputNumberId">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="btnSavePic" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
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
        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                $("input[name='activity_date']").each(function(index, el) {
                    flatpickr($(el), {
                        defaultDate: new Date(),
                        static: true,
                    });
                });
                // temporary open edit modal
                $(".temporary-edit").eq(1).click()
                $('#payment_verification-table').DataTable({
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
                        "sSearchPlaceholder": "Cari Pembayaran Kuitansi...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });
                $("#createModal").on('shown.bs.modal', function(e) {
                    // Restrict keyboard input
                    $(this).find('#inputAmount').on('keydown', window.allowOnlyNumericInput);
                    // Handle paste events
                    $(this).find('#inputAmount').on('paste', window.handlePaste);
                    $("#form-create").find('#createSelectVerificator').select2({
                        dropdownParent: $(this).find('.verificatorWrapper'),
                        placeholder: 'Pilih Verifikator',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                axios.get(`{{ route('verificators.index') }}`, {
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
                });
                // On Shown Edit Modal
                $('#editModal').on('shown.bs.modal', async function(e) {
                    const paymentVerification = $(e.relatedTarget).data('paymentVerification');
                    // Restrict keyboard input
                    $(this).find('#inputAmount').on('keydown', window.allowOnlyNumericInput);
                    // Handle paste events
                    $(this).find('#inputAmount').on('paste', window.handlePaste);
                    $(this).find("input[name='description']").val(paymentVerification.description);
                    $(this).find("input[name='amount']").val(paymentVerification.amount);
                    flatpickr($(this).find('input[name="activity_date"]'), {
                        defaultDate: paymentVerification.activity_date,
                        static: true,
                    });
                    $("#form-edit").attr('action', $(e.relatedTarget).data('updateUrl'));
                    $(this).find("input[name='provider']").val(paymentVerification.provider);
                    $(this).find("input[name='activity_implementer_name']").val(paymentVerification
                        .implementer_name);
                    $(this).find("input[name='activity_implementer_nip']").val(paymentVerification
                        .implementer_nip);
                    $(this).find("input[name='spi_name']").val(paymentVerification
                        .auditor_name);
                    $(this).find("input[name='spi_nip']").val(paymentVerification
                        .auditor_nip);
                    $(this).find("select[name='verificator']").select2({
                        dropdownParent: $(this).find('.verificatorWrapper'),
                        placeholder: 'Pilih Verifikator',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ route('verificators.index') }}`, {
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
                    var verificatorOption = new Option(
                        `${paymentVerification.verificator.nik} - ${paymentVerification.verificator.name}`,
                        paymentVerification.verificator.id,
                        true,
                        true);
                    $(this).find("select[name='verificator']").append(verificatorOption).trigger('change');

                    $(this).find("select[name='ppk']").select2({
                        dropdownParent: $(this).find('.ppkWrapper'),
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
                    var ppkOption = new Option(
                        `${paymentVerification.ppk.nik} - ${paymentVerification.ppk.name}`,
                        paymentVerification.ppk.id,
                        true,
                        true);
                    $(this).find("select[name='ppk']").append(ppkOption).trigger('change');

                });
                $(".btnInputActivityImplementer").on('click', function(e) {
                    $(".modal.show").toggleClass('d-none');
                    const inputPICModalEl = document.getElementById('inputPICModal');
                    const inputPICModal = new bootstrap.Modal(inputPICModalEl, {
                        keyboard: false,
                    });
                    $(inputPICModalEl).data('type', 'activity_implementer'); // Setting data attribute
                    inputPICModal.show();
                });
                $(".btnInputSPI").on('click', function(e) {
                    $(".modal.show").toggleClass('d-none');
                    const inputPICModalEl = document.getElementById('inputPICModal');
                    const inputPICModal = new bootstrap.Modal(inputPICModalEl, {
                        keyboard: false,
                    });
                    $(inputPICModalEl).data('type', 'spi'); // Setting data attribute
                    inputPICModal.show();
                });

                $("#inputPICModal").on('show.bs.modal', function(e) {
                    const type = $(this).data('type');
                    $(this).find('input[name="nip"]').on('keydown', window.allowOnlyNumericInput);
                    // Handle paste events
                    $(this).find('input[name="nip"]').on('paste', window.handlePaste);
                    $(this).find('.modal-title').text(type == 'activity_implementer' ? "Pelaksana Kegiatan" :
                        "Pemeriksa");
                    if ($(".modal.show.d-none").attr('id') == 'editModal') {
                        let editInputNameVal = $("#form-edit").find(`[name='${type}_name']`).val();
                        let editInputNipVal = $("#form-edit").find(`[name='${type}_nip']`).val();
                        $("#inputPICModal").find('input[name="name"]').val(editInputNameVal);
                        $("#inputPICModal").find('input[name="nip"]').val(editInputNipVal);
                    }
                });
                $("#btnSavePic").on('click', function() {
                    var type = $("#inputPICModal").data('type');
                    var inputPICModal = bootstrap.Modal.getInstance(document.getElementById('inputPICModal'));
                    const inputNameVal = $("#inputPICModal").find('input[name="name"]').val();
                    const inputNipVal = $("#inputPICModal").find('input[name="nip"]').val();
                    if (type === 'activity_implementer') {
                        $('.modal.show input[name="activity_implementer_name"]').val(inputNameVal);
                        $('.modal.show input[name="activity_implementer_nip"]').val(inputNipVal);
                    }
                    if (type === 'spi') {
                        $('.modal.show input[name="spi_name"]').val(inputNameVal);
                        $('.modal.show input[name="spi_nip"]').val(inputNipVal);
                    }
                    inputPICModal.hide();
                });

                $("#inputPICModal").on('hidden.bs.modal', function() {
                    $(".modal.show").toggleClass('d-none');
                })
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
