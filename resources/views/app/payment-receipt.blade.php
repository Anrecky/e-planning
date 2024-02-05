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
                            <div class="table-responsive my-4">
                                <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
                                    <div class="d-flex flex-wrap gap-1 my-2">
                                        <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">Rekam Kuitansi Pembayaran
                                        </button>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 my-2">
                                        <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
                                        <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
                                        <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
                                    </div>
                                </div>
                                <table id="assets-table" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Jenis Kuitansi</th>
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

                                    </tbody>
                                </table>
                            </div>
                        </x-custom.statbox>
                    </div>
                </div>
                <!-- Create Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalTitle">Rekam Data Kuitansi Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <form id="form-create">
                                    <div class="mb-4 row">
                                        <label for="selectTypeReceipt" class="col-sm-2 col-form-label">Jenis Kuitansi</label>
                                        <div class="col-sm-8">
                                            <select class="form-select" id="selectTypeReceipt">
                                                <option selected disabled value="">Pilih Jenis Kuitansi...</option>
                                                <option value="">Pembayaran Langsung</option>
                                                <option value="">Pembayaran Langsung (Bendahara)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Uraian Pencairan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="inputDisbursementDescription">
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputActivityDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="date" id="inputActivityDate" name="tanggal" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="inputAmount">
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputSupplierName" class="col-sm-2 col-form-label">Pelaksana Kegiatan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="inputSupplierName">
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="selectActivityExecutor" class="col-sm-2 col-form-label">Bendahara</label>
                                        <div class="col-sm-8">
                                            <input readonly disabled type="text" class="form-control" id="selectActivityExecutor">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary btn-lg">...</button>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="selectVerifier" class="col-sm-2 col-form-label">PPK</label>
                                        <div class="col-sm-8">
                                            <input readonly disabled type="text" class="form-control" id="selectVerifier">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary btn-lg">...</button>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="inputSupplierName" class="col-sm-2 col-form-label">Penyedia</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="inputSupplierName">
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="selectApprove" class="col-sm-2 col-form-label">Detail COA</label>
                                        <div class="col-sm-8">
                                            <input readonly disabled type="text" class="form-control" id="selectApprove">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary btn-lg">...</button>
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

                        document.getElementById('tglPickerButton').addEventListener('click', function() {
                            document.getElementById('tanggal').click();
                        });
                    </script>
                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>