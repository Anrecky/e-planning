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

        <style>
            #add-account_code_btn,
            #add-expenditure_detail_btn {
                opacity: 0;
                visibility: hidden;
            }

            #add-account_code_btn.show,
            #add-expenditure_detail_btn.show {
                opacity: 1;
                visibility: visible;
            }

            th,
            tr td:first-child {
                font-weight: bold !important;
            }

            tr.selected td {
                background-color: #2196f3 !important;
                color: white;
            }

            tr.activity-row td {
                background-color: wheat;
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
            <div class="statbox widget box box-shadow">
                <div style="min-height:50vh;" class="widget-content widget-content-area">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive my-4">
                        <div class="d-flex flex-wrap justify-content-between py-2 my-2">
                            <div class="d-flex flex-wrap gap-1 my-2">
                                <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#createModal">Rekam SubKomp</button>
                                <button id="add-account_code_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                                    class="btn btn-primary shadow-sm">Rekam Akun</button>
                                <button id="add-expenditure_detail_btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal" class="btn btn-primary shadow-sm">Rekam
                                    Detail</button>
                            </div>
                            <div class="d-flex flex-wrap gap-1 my-2">
                                <button id="save-dipa" class="btn btn-outline-primary shadow-sm bs-tooltip"
                                    title="Simpan data DIPA"><i data-feather="save"></i></button>
                                <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip"
                                    title="Edit data DIPA"><i data-feather="edit"></i></button>
                                <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip"
                                    title="Hapus data DIPA"><i data-feather="trash"></i></button>
                            </div>
                        </div>

                        <table id="budget_implementation-table" class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Kode</th>
                                    <th scope="col">SubKomponen</th>
                                    <th scope="col">Volume</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga Satuan</th>
                                    <th scope="col">Jumlah Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalTitle">Input Sub Komponen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create">
                        <div id="create-input_container" class="input-group my-2">
                        </div>
                        <button class="btn btn-success text-center align-items-center mt-1 mt-2 py-auto" type="submit">
                            <i data-feather="save"></i><span class="icon-name ms-1">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/input-mask/input-mask.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));

                const tableBody = document.querySelector('tbody');
                const form = document.getElementById('form-create');
                const table = document.getElementById('budget_implementation-table');
                const createModalEl = document.getElementById('createModal');

                createModalEl.addEventListener('show.bs.modal', event => {
                    const btnShowModalId = event.relatedTarget.id;
                    const createInputContainer = document.getElementById('create-input_container');
                    if (btnShowModalId === 'add-activity_btn') return createInputContainer.innerHTML =
                        ` <input type="text" name="activity_code" required class="form-control" style="max-width: 160px !important;" placeholder="KD.Keg"> <input type="text" required name="activity_name" class="form-control" placeholder="Uraian">`;
                    if (btnShowModalId === 'add-account_code_btn') return createInputContainer.innerHTML =
                        ` <input type="text" name="account_code" required class="form-control" style="max-width: 160px !important;" placeholder="KD.Akun"> <input type="text" required name="account_name" class="form-control" placeholder="Uraian">`;
                    if (btnShowModalId === 'add-expenditure_detail_btn') {
                        createInputContainer.innerHTML =
                            `<input type="text" required name="expenditure_description" class="form-control" placeholder="Uraian Detail">
                                          <input type="text" required name="expenditure_volume" class="form-control" style="max-width: 100px !important;" placeholder="Volume">
                                          <input type="text" name="unit" required class="form-control" style="max-width: 100px !important;" placeholder="Satuan">
                                          <input type="text" name="unit_price" required class="form-control" placeholder="Harga Satuan">`;

                        // Apply Inputmask for IDR format
                        Inputmask('decimal', {
                            groupSeparator: '.',
                            radixPoint: ',',
                            digits: 2,
                            autoGroup: true,
                            prefix: 'Rp ', // Space after Rp is important
                            rightAlign: false,
                            oncleared: function() {
                                self.Value('');
                            }
                        }).mask(createInputContainer.querySelector('input[name="unit_price"]'));

                        // For 'expenditure_volume', you can use a simple numeric mask
                        Inputmask('numeric').mask(createInputContainer.querySelector(
                            'input[name="expenditure_volume"]'));
                    }
                })


                tableBody.addEventListener('click', handleRowClick);
                form.addEventListener('submit', handleFormSubmit);
            });

            function handleRowClick(e) {
                if (e.target.closest('tr')) {
                    clearSelectedRows();
                    e.target.closest('tr').classList.add('selected');
                    toggleButtonsBasedOnRow(e.target.closest('tr'));
                }
            }

            function clearSelectedRows() {
                document.querySelectorAll('tr.selected').forEach(row => row.classList.remove('selected'));
            }

            function toggleButtonsBasedOnRow(row) {
                const isActivityRow = row.classList.contains('activity-row');
                const isAccountRow = row.classList.contains('account-row');
                toggleButtonVisibility('add-expenditure_detail_btn', !isActivityRow);
                toggleButtonVisibility('add-account_code_btn', isActivityRow || isAccountRow);
            }

            function toggleButtonVisibility(buttonId, show) {
                const button = document.getElementById(buttonId);
                button.classList.toggle('show', show);
            }

            function handleFormSubmit(event) {
                event.preventDefault();
                const formElements = Array.from(event.target.elements).filter(element => element.name);

                // Convert form elements to an object
                const formData = formElements.reduce((obj, element) => {
                    obj[element.name] = element.value;
                    return obj;
                }, {});

                // Check the type of form data
                const isActivity = formData.activity_code || formData.activity_name;
                const isAccount = formData.account_code || formData.account_name;
                const activityOrAccount = isAccount !== undefined ? "account" : "activity";

                createAndAppendRow(formData, activityOrAccount);
                event.target.reset();

            }

            function createAndAppendRow(data, type) {
                const newRow = document.createElement('tr');
                newRow.innerHTML =
                    `<td class="text-center">${(data.activity_code || data.account_code) ?? "" }</td><td>${(data.activity_name || data.account_name) ?? ""}</td><td>${data.volume ?? ""}</td><td>${data.unit ?? ""}</td><td>${data.unit_price ?? ""}</td><td>${data.total ?? ""}</td>`;
                if (type === 'activity') {
                    newRow.classList.add('activity-row');
                } else {
                    newRow.classList.add('account-row');
                }
                if (type === 'account') {
                    refElem = document.querySelector('tr.selected')
                    return refElem.insertAdjacentElement('afterend', newRow);
                }
                return document.querySelector('#budget_implementation-table tbody').appendChild(newRow);
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
