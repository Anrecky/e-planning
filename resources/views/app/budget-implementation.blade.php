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
                background-color: #fcf5e9;
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
                                    data-bs-target="#createModal">Rekam Sub Komponen</button>
                                <button id="add-account_code_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                                    class="btn btn-primary shadow-sm">Rekam Akun</button>
                                <button id="add-expenditure_detail_btn" data-bs-toggle="modal"
                                    data-bs-target="#createModal" class="btn btn-primary shadow-sm">Rekam
                                    Detail</button>
                            </div>
                            <div class="d-flex flex-wrap gap-1 my-2 mx-1">
                                <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip"
                                    title="Simpan data DIPA"><i data-feather="save"></i>
                                </button>
                                <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip"
                                    title="Edit data DIPA"><i data-feather="edit"></i>
                                </button>
                                <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip"
                                    title="Hapus data DIPA"><i data-feather="trash"></i>
                                </button>
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
                        <button class="btn btn-primary text-center align-items-center mt-1 mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
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
                        `<input type="text" name="activity_code" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Keg"> <input type="text" required name="activity_name" class="form-control" placeholder="Uraian">`;
                    if (btnShowModalId === 'add-account_code_btn') return createInputContainer.innerHTML =
                        `<input type="text" name="account_code" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Akun"> <input type="text" required name="account_name" class="form-control"placeholder="Uraian">`;
                    if (btnShowModalId === 'add-expenditure_detail_btn') {
                        createInputContainer.innerHTML =
                            `<input type="text" required name="expenditure_description" class="form-control" placeholder="Uraian Detail"><input type="text" required name="expenditure_volume" class="form-control"style="max-width: 100px !important;" placeholder="Volume"><input type="text" name="unit" required class="form-control" style="max-width: 100px !important;" placeholder="Satuan"><input type="text" name="unit_price" required class="form-control" placeholder="Harga Satuan"><input type="text" name="total" required class="form-control" placeholder="total">`;

                        // Now add the event listeners
                        const volumeInput = createInputContainer.querySelector(
                            'input[name="expenditure_volume"]');
                        const priceInput = createInputContainer.querySelector('input[name="unit_price"]');
                        const totalInput = createInputContainer.querySelector('input[name="total"]');

                        volumeInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                            priceInput, totalInput));
                        priceInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                            priceInput, totalInput));
                        volumeInput.addEventListener('keypress', enforceNumericInput);
                    }

                })

                tableBody.addEventListener('click', handleRowClick);
                form.addEventListener('submit', handleFormSubmit);
            });

            function formatAsIDRCurrency(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(value);
            }

            function enforceNumericInput(event) {
                const charCode = (event.which) ? event.which : event.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    event.preventDefault();
                }
            }

            function calculateAndUpdateTotal(volumeInput, priceInput, totalInput) {
                const volume = parseFloat(volumeInput.value.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                let unitPrice = parseFloat(priceInput.value.replace(/Rp\s?|,00/g, '').replace(/\./g, '').replace(/[^\d]/g, ''));

                if (!isNaN(volume) && !isNaN(unitPrice)) {
                    const total = volume * unitPrice;
                    totalInput.value = formatAsIDRCurrency(total);
                    priceInput.value = formatAsIDRCurrency(unitPrice);
                } else {
                    totalInput.value = '';
                }
            }

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
                const isExpenditureRow = row.classList.contains('expenditure-row');
                toggleButtonVisibility('add-expenditure_detail_btn', !isActivityRow);
                toggleButtonVisibility('add-account_code_btn', isActivityRow || isAccountRow || isExpenditureRow);
                row.classList.add(isActivityRow ? 'activity-parent' : (isAccountRow ? 'account-parent' : ''));
            }

            function toggleButtonVisibility(buttonId, show) {
                const button = document.getElementById(buttonId);
                button.classList.toggle('show', show);
            }

            function determineRowType(formData) {
                // Check if it's an Activity
                if (formData.activity_code || formData.activity_name) {
                    return 'activity';
                }
                // Check if it's an Account
                else if (formData.account_code || formData.account_name) {
                    return 'account';
                }
                // Check if it's an Expenditure
                else if (formData.expenditure_description || formData.expenditure_volume) {
                    return 'expenditure';
                }

                return null; // or some default type if necessary
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
                const isExpenditure = formData.expenditure_description || formData.expenditure_volume;
                const trType = determineRowType(formData);

                createAndAppendRow(formData, trType);
                event.target.reset();
                // Hide the modal after form submission
                $('#createModal').modal('hide');
            }


            function createAndAppendRow(data, type) {
                if (type === null) {
                    alert("Terdapat kesalahan pemrosesan...");
                    return;
                }
                const newRow = document.createElement('tr');
                const tableBody = document.querySelector('tbody');
                newRow.innerHTML =
                    `<td class="text-center">${data.activity_code || data.account_code || ""}</td><td>${data.activity_name || data.account_name || data.expenditure_description || ""}</td><td>${data.expenditure_volume || ""}</td><td>${data.unit || ""}</td><td>${data.unit_price || ""}</td><td>${data.total || ""}</td>`;
                newRow.classList.add(`${type}-row`);

                if (type === 'activity') {
                    tableBody.appendChild(newRow);
                } else {
                    insertRowBasedOnType(newRow, type);
                }
            }

            function insertRowBasedOnType(newRow, type) {
                const tableBody = document.querySelector('tbody');
                const selectedRow = document.querySelector('tr.selected');
                if (!selectedRow) {
                    return;
                }

                let referenceRow = selectedRow;
                // Logic for inserting an activity row.
                if (type === 'activity') {
                    referenceRow = tableBody.lastElementChild;
                    while (referenceRow && !referenceRow.classList.contains('activity-row')) {
                        referenceRow = referenceRow.previousElementSibling;
                    }
                }
                // Logic for inserting an account row.
                else if (type === 'account') {
                    while (referenceRow.nextElementSibling &&
                        (referenceRow.nextElementSibling.classList.contains('account-row') ||
                            referenceRow.nextElementSibling.classList.contains('expenditure-row'))) {
                        referenceRow = referenceRow.nextElementSibling;
                    }
                }
                // Logic for inserting an expenditure row.
                else if (type === 'expenditure') {
                    while (referenceRow.nextElementSibling && referenceRow.nextElementSibling.classList.contains(
                            'expenditure-row')) {
                        referenceRow = referenceRow.nextElementSibling;
                    }
                }

                // Perform the insertion after the determined reference row.
                if (referenceRow === tableBody.lastElementChild) {
                    tableBody.appendChild(newRow); // Append at the end if referenceRow is the last child.
                } else {
                    referenceRow.insertAdjacentElement('afterend', newRow); // Insert after the reference row.
                }
            }


            function handleRowClick(e) {
                if (e.target.closest('tr')) {
                    clearSelectedRows();
                    const clickedRow = e.target.closest('tr');
                    clickedRow.classList.add('selected');
                    toggleButtonsBasedOnRow(clickedRow);

                    // Mark the clicked row as the parent for the next entry
                    if (clickedRow.classList.contains('activity-row')) {
                        clickedRow.classList.add('activity-parent');
                        // Remove the account-parent class if it exists
                        clickedRow.classList.remove('account-parent');
                    } else if (clickedRow.classList.contains('account-row')) {
                        clickedRow.classList.add('account-parent');
                    }
                }
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
