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
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
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
                <x-custom.reception.table :receptions="$receptions" />
            </x-custom.statbox>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Rekam Penerimaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create" action="{{ route('reception.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="accountCode" class="col-sm-3 col-form-label">Kode Akun</label>
                            <div class="col-sm-7">
                                <select name="accountCode" id="accountCode" class="form-control"></select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description" class="col-sm-3 col-form-label">Uraian</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <p class="col-sm-3 col-form-label text-dark">Jenis</p>
                            <div class="col-sm-7">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" checked name="type[]"
                                        id="inlineRadio1" value="umum">
                                    <label class="form-check-label mb-0" for="inlineRadio1">Umum</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type[]" id="inlineRadio2"
                                        value="fungsional">
                                    <label class="form-check-label mb-0" for="inlineRadio2">Fungsional</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type[]" id="inlineRadio2"
                                        value="pajak">
                                    <label class="form-check-label mb-0" for="inlineRadio2">Pajak</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="target" class="col-sm-3 col-form-label">Target Pendapatan</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="target" name="target">
                            </div>
                        </div>
                        <button class="btn btn-primary text-center align-items-center mt-1 mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <x-custom.reception.edit-modal />

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @vite(['resources/assets/js/custom.js'])
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script type="module">
            const c1 = $('#reception-table').DataTable({
                headerCallback: function(e, a, t, n, s) {
                    e.getElementsByTagName("th")[0].innerHTML = `
                    <div class="form-check form-check-primary d-block">
                        <input class="form-check-input chk-parent" type="checkbox" id="form-check-default">
                    </div>`
                },
                columnDefs: [{
                        targets: 0,
                        width: "30px",
                        className: "",
                        orderable: !1,
                        render: function(e, a, t, n) {
                            return `
                        <div class="form-check form-check-primary d-block">
                            <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                        </div>`
                        }
                    },
                    {
                        targets: 6,
                        className: "",
                        orderable: !1,
                        searchable: false,
                    }
                ],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 10
            });
            multiCheck(c1);
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                const createModalEl = document.getElementById('createModal');
                const editModalEl = document.getElementById('editModal');
                const createForm = document.getElementById('form-create');
                const btnDeleteSome = document.getElementById('btnDeleteSome');

                theadTh.forEach(th => th.classList.add('bg-info'));

                createModalEl.addEventListener('show.bs.modal', function() {
                    const targetInputEl = document.getElementById('target')
                    targetInputEl.addEventListener('input', handleInput);
                });

                $(createModalEl).on('shown.bs.modal', function() {
                    $('#accountCode').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $(createModalEl),
                        ajax: {
                            transport: function(params, success, failure) {
                                axios.get(`{{ route('account_code_receptions.index') }}`, {
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
                                                    text: item.name
                                                };
                                            })
                                        });
                                    })
                            }
                        }
                    });

                }).on('hidden.bs.modal', function() {
                    $('#accountCode').select2('destroy');
                });

                $(editModalEl).on('shown.bs.modal', async function(e) {
                    let reception = $(e.relatedTarget).data('reception');
                    let updateUrl = $(e.relatedTarget).data('updateUrl');
                    const formEdit = $("#form-edit");
                    const editSelectEl = $('#editSelectAccountCode')

                    formEdit.attr('action', updateUrl);

                    formEdit.find('[name="description"]').val(reception.description)
                    formEdit.find('[name="target"]').on('input', handleInput);
                    formEdit.find('[name="target"]').val(reception.revenue_target.replace(/\.00$/, ''))
                        .trigger('input');
                    reception.type.forEach((type) => formEdit.find(`#${type}-checkbox`).prop('checked',
                        true))

                    editSelectEl.select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $("#editModal"),
                        ajax: {
                            transport: async function(params, success, failure) {
                                try {
                                    const res = await axios.get(
                                        `{{ route('account_code_receptions.index') }}`, {
                                            params: {
                                                search: params.data.term,
                                                limit: 10
                                            }
                                        })
                                    await success({
                                        results: res.data.map(function(item) {
                                            return {
                                                id: item.id,
                                                text: `${item.code} (${item.name})`
                                            };
                                        })
                                    });

                                } catch (error) {
                                    let errorMessage =
                                        'Gagal untuk mengambil data kode akun penerimaan.';
                                    if (error.response && error.response.data && error
                                        .response.data.message) {
                                        errorMessage = error.response.data.message;
                                    }

                                    Swal.fire({
                                        title: 'Kesalahan',
                                        text: errorMessage,
                                        icon: 'error'
                                    });
                                }

                            }
                        }
                    });

                    const res = await axios.get(
                        `/admin/api/selected-account-code-reception/${reception.account_code_reception_id}`
                    )
                    const selectedAccountCode = res.data;
                    var option = new Option(selectedAccountCode.code, selectedAccountCode.id,
                        selectedAccountCode.id === reception
                        .account_code_reception_id ?
                        true : false, selectedAccountCode.id === reception.account_code_reception_id ?
                        true : false);
                    editSelectEl.append(option).trigger('change');
                    editSelectEl.trigger({
                        type: 'select2:select',
                        params: {
                            data: selectedAccountCode.data
                        }
                    });

                }).on('hidden.bs.modal', function() {
                    const formEdit = $("#form-edit");
                    formEdit.find('[name="type[]"]').each((idx, el) => $(el).prop('checked', false))
                    formEdit.find('select[name="accountCode"]').select2('destroy');
                })

                $(createForm).on('submit', function(e) {
                    let rawTarget = document.getElementById('target').value;
                    // Remove 'Rp' and dots, then convert to number
                    let targetValue = parseInt(rawTarget.replace('-', 0).replace('Rp', '').replace(/\./g,
                        ''));
                    document.getElementById('target').value = targetValue
                })
                $("#form-edit").on('submit', function(e) {
                    let rawTarget = $("#form-edit").find('[name="target"]').val();
                    // Remove 'Rp' and dots, then convert to number
                    let targetValue = parseInt(rawTarget.replace('-', 0).replace('Rp', '').replace(/\./g,
                        ''));
                    $("#form-edit").find('[name="target"]').val(targetValue)
                })

                $(btnDeleteSome).on('click', async function() {
                    let receptionsChecked = $("tbody input[type='checkbox']:checked");

                    if (receptionsChecked.length === 0) {
                        return Swal.fire({
                            title: 'Pilih setidaknya satu data penerimaan?',
                            icon: 'warning'
                        });
                    }

                    Swal.fire({
                        title: 'Anda yakin ingin hapus?',
                        text: "Data tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            for (const inputEl of receptionsChecked) {
                                const receptionId = $(inputEl).parent().parent().data(
                                    'reception-id');
                                try {
                                    await axios.delete(
                                        `/admin/penerimaan/rekam-penerimaan/${receptionId}/hapus-beberapa`
                                    );
                                } catch (error) {
                                    Swal.fire({
                                        title: 'Gangguan!',
                                        text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                            window.location.reload();
                        }
                    });
                });


                function handleInput(e) {
                    const input = e.target;
                    const numericValue = input.value.replace(/[^0-9]/g, '');
                    input.value = numericValue; // Keep only numeric values
                    formatInputAsIDRCurrency(input); // Format as IDR currency
                }

                function formatInputAsIDRCurrency(input) {
                    let numericValue = parseInt(input.value.replace(/[^0-9]/g, ''), 10);
                    if (!isNaN(numericValue)) {
                        input.value = numericValue.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                }


            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
