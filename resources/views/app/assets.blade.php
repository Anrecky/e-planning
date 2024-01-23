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
                <x-custom.aset.table />
            </x-custom.statbox>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Input Data Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create">
                        <div class="mb-4 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input checked class="form-check-input" type="radio" name="asset_category"
                                        id="asset_category_1" value="IT">
                                    <label class="form-check-label" for="asset_category_1">IT</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asset_category"
                                        id="asset_category_2" value="NonIT">
                                    <label class="form-check-label" for="asset_category_2">Non IT</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="selectTypeAssets" class="col-sm-2 col-form-label">Barang Aset</label>
                            <div class="col-sm-8">
                                <input readonly disabled type="text" class="form-control" id="selectTypeAssets">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-lg">...</button>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputBrand" class="col-sm-2 col-form-label">Merek</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputBrand">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="selectAcquisitionYear" class="col-sm-2 col-form-label">Tahun Perolehan</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="selectAcquisitionYear">
                                    <option selected disabled value="">Pilih Tahun...</option>
                                    @for ($tahun = 2000; $tahun <= 2035; $tahun++)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputCodeAssets" class="col-sm-2 col-form-label">Kode Aset</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCodeAssets">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputCondition" class="col-sm-2 col-form-label">Kondisi</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input checked class="form-check-input" type="radio" name="asset_condition"
                                        id="asset_category_1" value="IT">
                                    <label class="form-check-label" for="asset_category_1">Baik</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asset_condition"
                                        id="asset_category_2" value="NonIT">
                                    <label class="form-check-label" for="asset_category_2">Rusak Ringan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="asset_condition"
                                        id="asset_category_2" value="NonIT">
                                    <label class="form-check-label" for="asset_category_2">Rusak Berat</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-1 col-form-label">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 20vh"></textarea>
                                    <label for="floatingTextarea2">Keterangan</label>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
