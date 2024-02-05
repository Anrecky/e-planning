<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        <style>
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

            table.table thead .sorting:after,
            table.table thead .sorting_asc:after,
            table.table thead .sorting_desc:after {
                color: yellow;
                opacity: 0.6 !important;
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
                <x-custom.aset.table :assets="$assets" />
            </x-custom.statbox>
        </div>
    </div>
    <!-- Create Modal -->
    <!-- Edit Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Input Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18">
                            </line>
                            <line x1="6" y1="6" x2="18" y2="18">
                            </line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-create" method="POST" action="{{ route('asset.store') }}">
                        @csrf
                        <div class="mb-4 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input checked class="form-check-input" type="radio" name="asset_item_category"
                                        id="asset_item_category_1" value="IT">
                                    <label class="form-check-label" for="asset_item_category_1">IT</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asset_item_category"
                                        id="asset_item_category_2" value="NonIT">
                                    <label class="form-check-label" for="asset_item_category_2">Non IT</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="selectAssetItem" class="col-sm-2 col-form-label">Barang Aset</label>
                            <div class="col-sm-8">
                                <select required class="form-select" aria-label="Pilih Barang Aset" name="asset_item"
                                    id="selectAssetItem">
                                    <option selected value="">Pilih Barang Aset</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputBrand" class="col-sm-2 col-form-label">Merek</label>
                            <div class="col-sm-8">
                                <input name="brand" type="text" class="form-control" id="inputBrand">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="selectAcquisitionYear" class="col-sm-2 col-form-label">Tahun Perolehan</label>
                            <div class="col-sm-8">
                                <select required name="year_acquisition" class="form-select" id="selectAcquisitionYear">
                                    <option selected disabled value="">Pilih Tahun...</option>
                                    @for ($year = 2000; $year <= 2035; $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputCodeAssets" class="col-sm-2 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input required name="code" type="text" class="form-control"
                                    id="inputCodeAssets">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputCondition" class="col-sm-2 col-form-label">Kondisi</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input checked class="form-check-input" type="radio" name="condition"
                                        id="asset_condition_1" value="good">
                                    <label class="form-check-label" for="asset_condition_1">Baik</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condition"
                                        id="asset_condition_2" value="slightly">
                                    <label class="form-check-label" for="asset_condition_2">Rusak Ringan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condition"
                                        id="asset_condition_3" value="heavy">
                                    <label class="form-check-label" for="asset_condition_3">Rusak Berat</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="enableDescriptionTextArea" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-1 col-form-label">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 description-checkbox" type="checkbox"
                                        value="" aria-label="Enable textarea checkbox">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-floating">
                                    <textarea disabled class="form-control" name="description" placeholder="Isikan keterangan disini" id="description"
                                        style="height: 20vh"></textarea>
                                    <label for="description">Keterangan</label>
                                </div>
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
    <x-custom.aset.edit-modal />

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary', 'text-white'));

                // datatable inisialization
                $('#assets-table').DataTable({
                    columnDefs: [{
                        targets: 7,
                        className: "",
                        orderable: !1,
                        searchable: false,
                    }],
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });

                // add enable or disable description when the checkbox checked
                $('.description-checkbox').on('change', function(e) {
                    if ($(this).is(':checked')) {
                        // Enable or disable textarea based on checkbox state
                        $('textarea[name="description"]').prop('readonly', false);
                    } else {
                        // Enable or disable textarea based on checkbox state
                        $('textarea[name="description"]').prop('readonly', true);
                    }
                });

                // editBtn handle click
                $('#assets-table tbody').on('click', '.editBtn', async function(e) {
                    const assetId = $(e.currentTarget).data('id');
                    let assetData = await getAssetData(assetId);
                    var editModalEl = document.querySelector('#editModal');
                    var editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
                    editModal.show();
                    // Update the form action URL
                    document.getElementById('form-edit').action = '/admin/aset/rekam-aset/' +
                        assetData.id;

                    $('#form-edit').find('input[name="asset_item_category"]').each((index, radio) => {
                        $(radio).on('change', async () => {
                            if (radio.checked) {
                                let selectedCategory = $(radio).val();
                                const selectAssetItemEl = document.querySelector(
                                    ".modal.show form select[name='asset_item']"
                                );
                                let assetItemsData = await getAssetItemOptions(
                                    selectedCategory)
                                populateAssetItemOptions(assetItemsData,
                                    selectAssetItemEl)
                                $('#form-edit').find('select#selectAssetItem').val(
                                    assetData.asset_item.id);
                            }
                        })
                    })

                    // Populate form data
                    $(`#form-edit input[name='asset_item_category'][value="${assetData.asset_item.category}"]`)
                        .prop('checked', true);
                    $(`#form-edit input[name='brand']`).val(assetData.brand);
                    $(`#form-edit select[name='year_acquisition']`).val(assetData.year_acquisition)
                    $(`#form-edit input[name='code']`).val(assetData.code)
                        .change();
                    $(`#form-edit input[name='condition'][value='${assetData.condition}']`).prop('checked',
                        true).change();
                    $(`#form-edit textarea[name='description']`).val(assetData.description);
                })

                $('#editModal').on('shown.bs.modal', function() {
                    $('#form-edit').find('input[name="asset_item_category"]').change();
                })
                async function getAssetData(id) {
                    try {
                        const {
                            data
                        } = await axios.get(`/admin/aset/rekam-aset/${id}/edit`);
                        return data;
                    } catch (error) {
                        throw new Error('Gagal mengambil data aset');
                    }
                }

                $('#createModal').on('shown.bs.modal', function() {
                    $('#form-create').find('input[name="asset_item_category"]').change()
                })
                // addBtn handle click
                $("#addBtn").on('click', function() {
                    var createModalEl = document.querySelector('#createModal');
                    var createModal = bootstrap.Modal.getOrCreateInstance(createModalEl);
                    createModal.show();

                    $('#form-create').find('input[name="asset_item_category"]').each((index, radio) => {
                        $(radio).on('change', async () => {
                            if (radio.checked) {
                                let selectedCategory = $(radio).val();
                                const selectAssetItemEl = document.querySelector(
                                    ".modal.show form select[name='asset_item']"
                                );
                                let assetItemsData = await getAssetItemOptions(
                                    selectedCategory)
                                populateAssetItemOptions(assetItemsData, selectAssetItemEl)
                            }
                        })
                    })

                })

                async function getAssetItemOptions(selectedCategory) {
                    try {
                        const {
                            data
                        } = await axios.get(`/admin/api/asset-items/${selectedCategory}`);
                        return data;
                    } catch (error) {
                        throw new Error('Gagal mengambil item aset');
                    }
                }

                function populateAssetItemOptions(assetItems, selectEl) {
                    selectEl.innerHTML = '<option selected value="">Pilih Barang Aset</option>';
                    assetItems.forEach(assetItem => {
                        const option = new Option(assetItem.name, assetItem.id);
                        selectEl.appendChild(option);
                    });
                }
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
