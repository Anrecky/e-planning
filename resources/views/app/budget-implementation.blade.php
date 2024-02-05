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
                            <x-custom.budget-implementation.table :totalSum="$totalSum" :groupedBI="$groupedBI" />
                        </x-custom.statbox>
                    </div>
                </div>
                <!-- Create Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle" aria-hidden="true">
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
                <!-- Edit Modal -->
                <x-custom.budget-implementation.edit-modal />

                <!--  BEGIN CUSTOM SCRIPTS FILE  -->
                <x-slot:footerFiles>
                    <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
                    <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
                    <script>
                        const accountCodes = @json($accountCodes);
                        const expenditureUnits = @json($expenditureUnits);
                        document.addEventListener('DOMContentLoaded', function() {
                            const theadTh = document.querySelectorAll('thead tr th');
                            theadTh.forEach(th => th.classList.add('bg-primary'));
                            const tdMoney = document.querySelectorAll(
                                'tr.expenditure-row td:nth-child(5),tr.expenditure-row td:nth-child(6)')

                            const tableBody = document.querySelector('tbody');
                            const form = document.getElementById('form-create');
                            const table = document.getElementById('budget_implementation-table');
                            const createModalEl = document.getElementById('createModal');
                            const saveDipaBtn = document.getElementById('save-dipa');
                            const editDipaBtn = document.getElementById('edit-dipa');
                            const deleteDipaBtn = document.getElementById('delete-dipa');
                            const editModalEl = document.getElementById('editModal');
                            const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl)

                            editDipaBtn.addEventListener('click', event => {
                                const trSelected = document.querySelector('tr.selected');

                                if (!trSelected) {
                                    Swal.fire({
                                        title: 'Pilih dipa!',
                                        text: 'Silahkan pilih dipa untuk di edit terlebih dahulu.',
                                        icon: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    editModal.show();
                                }
                            });

                            deleteDipaBtn.addEventListener('click', event => {
                                const trSelected = document.querySelector('tr.selected');
                                if (!trSelected) {
                                    Swal.fire({
                                        title: 'Pilih dipa!',
                                        text: 'Silahkan pilih dipa untuk di edit terlebih dahulu.',
                                        icon: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    if (trSelected.classList.contains('activity-row')) return confirmDelete('activity',
                                        trSelected.dataset.bi, trSelected.children[0].textContent);
                                    if (trSelected.classList.contains('account-row')) return confirmDelete('account',
                                        trSelected.dataset.bi, trSelected.children[0].textContent);
                                    if (trSelected.classList.contains('expenditure-row')) return confirmDelete('detail',
                                        trSelected.dataset.expenditure, trSelected.children[1].textContent);
                                    return;
                                }
                            });

                            editModalEl.addEventListener('show.bs.modal', function(event) {
                                const trSelected = document.querySelector('tr.selected');
                                const editInputContainer = document.getElementById('edit-input_container');

                                if (trSelected.classList.contains('activity-row')) {
                                    editModalTitle.textContent = "Input Sub Komponen";
                                    editInputContainer.innerHTML =
                                        `<input type="hidden" name="id" value="${trSelected.dataset.bi}"><input type="hidden" name="type" value="activity"><input type="text" name="code" value="${trSelected.children[0].textContent}" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Keg"> <input type="text" value="${trSelected.children[1].textContent}" required name="name" class="form-control" placeholder="Uraian">`
                                } else if (trSelected.classList.contains('account-row')) {
                                    editModalTitle.textContent = "Input Kode Akun";

                                    let options = accountCodes.map(code =>
                                        `<option value="${code.code}" data-account-name="${code.name}">${code.code}</option>`
                                    ).join('');

                                    editInputContainer.innerHTML =
                                        `<input type="hidden" name="id" value="${trSelected.dataset.bi}"><input type="hidden" name="type" value="account"><select name="code" id="account-code-select" required class="form-control" style="max-width: 200px !important;"><option value="">Pilih Kode Akun</option>${options}</select><input type="text" id="account-name-input" disabled required name="name" class="form-control" placeholder="Uraian">`;

                                    // Set the value of the select element
                                    const accountCodeSelect = document.getElementById('account-code-select');
                                    accountCodeSelect.value = trSelected.children[0].textContent;

                                    // Add event listener for change event
                                    accountCodeSelect.addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];
                                        const accountName = selectedOption.getAttribute('data-account-name');
                                        document.getElementById('account-name-input').value = accountName || '';
                                    });

                                    // Manually trigger the change event
                                    accountCodeSelect.dispatchEvent(new Event('change'));
                                } else {
                                    editModalTitle.textContent = "Input Detail";

                                    let options = expenditureUnits.map(unit =>
                                        `<option value="${unit.code}">${unit.code}</option>`
                                    ).join('');

                                    editInputContainer.innerHTML =
                                        `<input type="hidden" name="id" value="${trSelected.dataset.expenditure}"><input type="hidden" name="type" value="detail"><input type="text" required name="name" value="${trSelected.children[1].textContent}" class="form-control" placeholder="Uraian Detail">
                            <input type="text" required name="volume" value="${trSelected.children[2].textContent}" class="form-control" style="max-width: 100px !important;" placeholder="Volume">
                            <select name="unit" required class="form-control" style="max-width: 150px !important;">${options}</select>
                            <input type="text" name="unit_price" value="${trSelected.children[4].textContent}" required class="form-control" placeholder="Harga Satuan">
                            <input type="text" name="total" value="${trSelected.children[5].textContent}" required class="form-control" placeholder="Total">`;

                                    // Set the correct unit in the dropdown
                                    const unitSelect = editInputContainer.querySelector('select[name="unit"]');
                                    unitSelect.value = trSelected.children[3].textContent;

                                    // Now add the event listeners
                                    const volumeInput = editInputContainer.querySelector(
                                        'input[name="volume"]');
                                    const priceInput = editInputContainer.querySelector('input[name="unit_price"]');
                                    const totalInput = editInputContainer.querySelector('input[name="total"]');

                                    volumeInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                        priceInput, totalInput));
                                    priceInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                        priceInput, totalInput));
                                    volumeInput.addEventListener('keypress', window.enforceNumericInput);
                                }
                            });

                            createModalEl.addEventListener('show.bs.modal', event => {
                                const btnShowModalId = event.relatedTarget.id;
                                const createModalTitle = document.getElementById('createModalTitle');

                                const modalTitles = {
                                    'add-activity_btn': 'Input Sub Komponen',
                                    'add-account_code_btn': 'Input Kode Akun',
                                    default: 'Input Detail'
                                };

                                createModalTitle.textContent = modalTitles[event.relatedTarget.id] || modalTitles.default;

                                const createInputContainer = document.getElementById('create-input_container');
                                if (btnShowModalId === 'add-activity_btn') return createInputContainer.innerHTML =
                                    `<input type="text" name="activity_code" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Keg"> <input type="text" required name="activity_name" class="form-control" placeholder="Uraian">`;
                                if (btnShowModalId === 'add-account_code_btn') {
                                    let options = accountCodes.map(code =>
                                        `<option value="${code.code}" data-account-name="${code.name}">${code.code}</option>`
                                    ).join('');
                                    createInputContainer.innerHTML =
                                        `<select name="account_code" id="account-code-select" required class="form-control" style="max-width: 200px !important;"><option value="">Pilih Kode Akun</option>${options}</select><input type="text" id="account-name-input" disabled required name="account_name" class="form-control" placeholder="Uraian">`;

                                    // Add event listener for change event
                                    document.getElementById('account-code-select').addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];
                                        const accountName = selectedOption.getAttribute('data-account-name');
                                        document.getElementById('account-name-input').value = accountName || '';
                                    });
                                }
                                if (btnShowModalId === 'add-expenditure_detail_btn') {
                                    let options = expenditureUnits.map(unit =>
                                        `<option value="${unit.code}">${unit.code}</option>`
                                    ).join('');
                                    createInputContainer.innerHTML =
                                        `<input type="text" required name="expenditure_description" class="form-control" placeholder="Uraian Detail"><input type="text" required name="expenditure_volume" class="form-control"style="max-width: 100px !important;" placeholder="Volume"><select name="unit" required class="form-control" style="max-width: 150px !important;"><option value="">Pilih Satuan</option>${options}</select><input type="text" disabled name="unit_price" required class="form-control" placeholder="Harga Satuan"><input disabled type="text" name="total" required class="form-control" placeholder="total">`;

                                    // Now add the event listeners
                                    const volumeInput = createInputContainer.querySelector(
                                        'input[name="expenditure_volume"]');
                                    const priceInput = createInputContainer.querySelector('input[name="unit_price"]');
                                    const totalInput = createInputContainer.querySelector('input[name="total"]');
                                    if (volumeInput && priceInput && totalInput) {
                                        volumeInput.addEventListener('input', function() {
                                            const isVolumeFilled = volumeInput.value.trim() !== '';
                                            priceInput.disabled = !isVolumeFilled;
                                            totalInput.disabled = !isVolumeFilled;

                                            if (!isVolumeFilled) {
                                                // Clear values when volume is not filled
                                                priceInput.value = '';
                                                totalInput.value = '';
                                            }
                                        });
                                    }
                                    volumeInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                        priceInput, totalInput));
                                    priceInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                        priceInput, totalInput));
                                    volumeInput.addEventListener('keypress', window.enforceNumericInput);
                                }

                            })

                            tableBody.addEventListener('click', handleRowClick);
                            form.addEventListener('submit', handleFormSubmit);
                            saveDipaBtn.addEventListener('click', handleSaveDipaClick);
                        });

                        function handleSaveDipaClick() {
                            const dipaData = groupRows();
                            const endpoint = window.Laravel.routes.budgetImplementationStore;

                            // Show a loading indicator
                            Swal.fire({
                                title: 'Menyimpan data...',
                                text: 'Mohon menunggu data untuk disimpan terlebih dahulu.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            axios.post(endpoint, {
                                    dipa: dipaData
                                })
                                .then(response => {
                                    // Success feedback
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Data berhasil untuk disimpan.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();

                                    });
                                })
                                .catch(error => {
                                    // Error handling

                                    Swal.fire({
                                        title: 'Gangguan!',
                                        text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }


                        function groupRows() {
                            let rows = document.querySelectorAll('tr');
                            let groupedRows = [];
                            let currentActivity = null;
                            let currentAccount = null;

                            rows.forEach(row => {
                                if (row.classList.contains('activity-row')) {
                                    let activityData = {
                                        id: row.dataset.activity,
                                        code: row.children[0].textContent,
                                        name: row.children[1].textContent
                                    };
                                    currentActivity = {
                                        bi: row.dataset.bi,
                                        activity: activityData,
                                        accounts: []
                                    };
                                    groupedRows.push(currentActivity);
                                } else if (row.classList.contains('account-row')) {
                                    let accountData = {
                                        id: row.dataset.accountCode,
                                        code: row.children[0].textContent,
                                        name: row.children[1].textContent
                                    };
                                    currentAccount = {
                                        account: accountData,
                                        expenditures: []
                                    };
                                    if (currentActivity) {
                                        currentActivity.accounts.push(currentAccount);
                                    }
                                } else if (row.classList.contains('expenditure-row')) {
                                    let unit_price = row.children[4].textContent.replace(/Rp|\./g, '').trim();
                                    let total = row.children[5].textContent.replace(/Rp|\./g, '').trim();

                                    let expenditureData = {
                                        id: row.dataset.expenditure,
                                        description: row.children[1].textContent,
                                        volume: row.children[2].textContent,
                                        unit: row.children[3].textContent,
                                        unit_price: unit_price,
                                        total: total
                                    };
                                    if (currentAccount) {
                                        currentAccount.expenditures.push(expenditureData);
                                    }
                                }
                            });

                            return groupedRows;
                        }

                        function confirmDelete(rowType, id, name) {
                            let rowTypeName = rowType === 'detail' ? 'detail' : (rowType === 'activiy' ? "Kode Keg" : "Kode Akun");
                            Swal.fire({
                                title: `Anda yakin ingin hapus \n(${rowTypeName} : ${name})?`,
                                text: "Data tidak dapat dikembalikan!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.delete(`/admin/penganggaran/hapus-dipa/${rowType}/${id}`)
                                        .then(res => {
                                            Swal.fire({
                                                title: 'Terhapus!',
                                                text: 'Data berhasil dihapus.',
                                                icon: 'success'
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        })
                                        .catch(error => {
                                            console.error(error);
                                            Swal.fire({
                                                title: 'Gangguan!',
                                                text: 'Gagal menghapus data.',
                                                icon: 'error'
                                            });
                                        });
                                }
                            });
                        }


                        function calculateAndUpdateTotal(volumeInput, priceInput, totalInput) {
                            const volume = parseFloat(volumeInput.value.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                            let unitPrice = parseFloat(priceInput.value.replace(/Rp\s?|,00/g, '').replace(/\./g, '').replace(/[^\d]/g, ''));

                            if (!isNaN(volume) && !isNaN(unitPrice)) {
                                const total = volume * unitPrice;
                                totalInput.value = window.formatAsIDRCurrency(total);
                                priceInput.value = window.formatAsIDRCurrency(unitPrice);
                            } else {
                                totalInput.value = '';
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
                                    clickedRow.classList.remove('account-parent');
                                } else if (clickedRow.classList.contains('account-row')) {
                                    clickedRow.classList.add('account-parent');
                                } else {

                                }
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
                            if (!isExpenditureRow) {
                                row.classList.add(isActivityRow ? 'activity-parent' : (isAccountRow ? 'account-parent' : ''));
                            }
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
                    </script>
                    </x-slot>
                    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>