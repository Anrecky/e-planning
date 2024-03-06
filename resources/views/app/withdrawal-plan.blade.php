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
            .month-filter-wrapper {
                /* Add custom styling as per your application's design */
                margin-bottom: 15px;
            }

            .month-filter-wrapper select {
                flex-grow: 1;
            }

            .month-filter-wrapper label {
                /* Styling for label */
                margin-bottom: 5px;
                display: block;
            }

            /* Responsive styling */
            @media (max-width: 576px) {
                .month-filter-wrapper .d-flex {
                    flex-direction: column;
                }

                .month-filter-wrapper select {
                    margin-bottom: 10px;
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
                    <table id="withdrawal_plan-table" class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="bg-primary" scope="col">Kode</th>
                                <th class="bg-primary" scope="col">Deskripsi</th>
                                <th class="bg-primary" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                <tr title="Klik untuk lihat detail rencana penarikan dana"
                                    class="activity-row bs-tooltip" data-activity-id="{{ $activity->id }}"
                                    data-activity-accumulated-sum="{{ $activity->calculateTotalSum() }}"
                                    data-activity-code="{{ $activity->code }}"
                                    data-activity-name="{{ $activity->name }}" data-toggle="modal"
                                    data-target="#withdrawalPlanModal">
                                    <td>{{ $activity->code }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                        {{ $activity->calculateTotalSumFormatted() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Data masih kosong...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </x-custom.statbox>
        </div>
    </div>

    <!-- Withdrawal Plan Modal -->
    <div class="modal fade" id="withdrawalPlanModal" tabindex="-1" role="dialog"
        aria-labelledby="withdrawalPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawalPlanModalLabel">Withdrawal Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <!-- Inside the modal body -->
                <div class="modal-body">
                    <!-- Hidden input for storing activity ID -->
                    <input type="hidden" id="currentActivityId" value="">
                    <h2 class="mb-2 text-center fw-bold text-white bg-primary p-2" id="accumulatedTotalSum"></h2>

                    <!-- Year Filter Section -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Tahun di Tampilkan:</label>
                        <select name="select_year" id="select_year" class="form-select w-25 d-inline-block">
                            @for ($i = 2000; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" @if ($i == date('Y')) selected @endif>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>


                    <!-- Month Filter Section -->
                    <div class="month-filter-wrapper mb-3">
                        <label class="form-label">Pilih Bulan di Tampilkan:</label>
                        <div class="row month-checkboxes">
                            @foreach ($months as $index => $month)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input checked class="form-check-input month-checkbox" type="checkbox"
                                            value="{{ $index + 1 }}" id="monthCheckbox{{ $index + 1 }}">
                                        <label class="form-check-label" for="monthCheckbox{{ $index + 1 }}">
                                            {{ $month->getName() }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button id="toggleAllMonths" class="btn btn-primary btn-sm mt-2">Pilih Semua</button>
                    </div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="bg-primary text-center">Bulan</th>
                                <th class="bg-primary text-center">Jumlah Penarikan</th>
                            </tr>
                        </thead>
                        <tbody id="withdrawalPlanModalBody">
                            @foreach ($months as $index => $month)
                                <tr data-month="{{ $month->value }}" class="month-row">
                                    <td>{{ $month->getName() }}</td>
                                    <td>
                                        <input type="text" class="form-control editable-amount"
                                            id="amount-{{ $index + 1 }}" value="-">
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th
                                    class="border-top border-bottom border-start border-end border-primary bg-primary text-center">
                                    Total Akumulasi
                                </th>
                                <td class="border-top border-bottom border-end border-start-0 border-primary"
                                    id="totalAccumulated">-</td>
                            </tr>
                            <tr>
                                <th
                                    class="border-top border-bottom border-start border-end border-warning bg-warning text-center">
                                    Sisa
                                </th>
                                <td class="border-top border-bottom border-end border-start-0 border-warning"
                                    id="residual">-</td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="btnSaveWithdrawalPlan" class="btn btn-lg btn-success ms-auto d-block">Simpan</button>

                </div>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setupActivityRows();
                setupEditableAmounts();
                setupMonthCheckboxes();
                setupToggleAllButton();
                document.getElementById('btnSaveWithdrawalPlan').addEventListener('click', function() {
                    let rows = document.querySelectorAll('#withdrawalPlanModalBody tr.month-row');
                    let savedData = [];
                    rows.forEach((row) => {
                        let rawAmount = document.getElementById(
                            `amount-${row.getAttribute('data-month')}`).value;

                        // Remove 'Rp' and dots, then convert to number
                        let amount = parseInt(rawAmount.replace('-', 0).replace('Rp', '').replace(/\./g,
                            ''));

                        let rowData = {
                            'month': row.getAttribute('data-month'),
                            'amount_withdrawn': amount
                        };
                        savedData.push(rowData);
                    });

                    savingWithdrawalPlans(savedData);
                });
            });

            // Add the onchange event select_year withdrawal plans data
            document.getElementById('select_year').addEventListener('change', function(e) {
                let activityID = document.getElementById('currentActivityId').value;
                const activity = getActivityData(document.querySelector(`[data-activity-id="${activityID}"]`))
                resetModalAmounts();
                fetchAndPopulateModal(activity);
            })

            async function savingWithdrawalPlans(withdrawalPlans) {
                try {
                    let activityId = document.getElementById('currentActivityId').value;
                    let year = document.querySelector('select[name="select_year"]').value;
                    const response = await axios.post('/admin/penganggaran/rencana-penarikan-dana', {
                        "activityId": activityId,
                        "withdrawalPlans": withdrawalPlans,
                        "year": year
                    });

                    if (response.status === 200) {
                        // Assuming the server sends back a success message
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.data.message || 'Data penarikan dana berhasil disimpan.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                $('#withdrawalPlanModal').modal('hide'); // Close the modal
                                location.reload(); // Reload the page
                            }
                        });
                    } else {
                        // If the server response status is not 200
                        Swal.fire({
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!',
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    // Handling any errors that occur during the HTTP request
                    console.error(error);

                    let errorMessage = 'Gagal untuk simpan data.';
                    if (error.response && error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }

                    Swal.fire({
                        title: 'Kesalahan',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            }

            function setupActivityRows() {
                document.querySelectorAll('.activity-row').forEach(row => {
                    row.addEventListener('click', () => {
                        const activity = getActivityData(row);
                        resetModalAmounts();
                        fetchAndPopulateModal(activity);
                    });
                });
            }

            function setupEditableAmounts() {
                document.querySelectorAll('.editable-amount').forEach(input => {
                    input.addEventListener('input', handleInput);
                    input.addEventListener('blur', formatAmountOnBlur);
                });
            }

            function setupMonthCheckboxes() {
                document.querySelectorAll('.month-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', filterMonths);
                });
            }

            function setupToggleAllButton() {
                const toggleAllButton = document.getElementById('toggleAllMonths');
                toggleAllButton.addEventListener('click', () => {
                    let allChecked = Array.from(document.querySelectorAll('.month-checkbox')).every(checkbox => checkbox
                        .checked);
                    document.querySelectorAll('.month-checkbox').forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });
                    filterMonths();
                });
            }

            function filterMonths() {
                let selectedMonths = Array.from(document.querySelectorAll('.month-checkbox:checked')).map(checkbox => checkbox
                    .value);

                document.querySelectorAll('#withdrawalPlanModalBody tr.month-row').forEach(row => {
                    const monthIndex = row.getAttribute('data-month');
                    row.style.display = selectedMonths.includes(monthIndex) ? '' : 'none';
                });
            }

            function handleInput(e) {
                const input = e.target;
                const numericValue = input.value.replace(/[^0-9]/g, '');
                input.value = numericValue; // Keep only numeric values
                formatInputAsIDRCurrency(input); // Format as IDR currency
                recalculateResidual(); // Recalculate residual after input change
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

            function formatAmountOnBlur(e) {
                const input = e.target;
                const numericValue = parseInt(input.value.replace(/[^0-9]/g, ''), 10);

                if (isNaN(numericValue) || numericValue === 0) {
                    input.value = '-';
                } else {
                    input.value = numericValue.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                }
                recalculateResidual(); // Recalculate residual after input change
            }

            function recalculateResidual() {
                let totalInputAmount = 0;
                document.querySelectorAll('.editable-amount').forEach(input => {
                    const amount = parseFloat(input.value.replace(/Rp\s?|,00/g, '').replace(/\./g, '').replace(/[^\d]/g,
                        ''));
                    if (!isNaN(amount)) {
                        totalInputAmount += amount;
                    }
                });
                let activityID = document.getElementById('currentActivityId').value;
                let activityData = getActivityData(document.querySelector(`[data-activity-id="${activityID}"]`));
                let residual = activityData.accumulatedSum - totalInputAmount;

                if (residual < 0) {
                    document.getElementById('residual').classList.add('bg-danger')
                } else {
                    document.getElementById('residual').classList.remove('bg-danger')
                }
                document.getElementById('btnSaveWithdrawalPlan').disabled = residual < 0;

                document.getElementById('residual').innerText = window.formatAsIDRCurrency(residual);
            }

            function getActivityData(row) {
                return {
                    id: row.dataset.activityId,
                    code: row.dataset.activityCode,
                    name: row.dataset.activityName,
                    accumulatedSum: row.dataset.activityAccumulatedSum
                };
            }

            function resetModalAmounts() {
                for (let i = 1; i <= 12; i++) {
                    const monthElement = document.getElementById(`amount-${i}`);
                    if (monthElement) {
                        monthElement.value = '-';
                    }
                }
            }

            async function fetchAndPopulateModal(activity) {
                try {
                    const response = await axios.get(
                        `/admin/api/withdrawal-plans/${activity.id}/${document.getElementById('select_year').value}`);
                    populateModalWithData(response.data, activity);
                } catch (error) {
                    showErrorAlert('Kesalahan', 'Gagal memuat data penarikan dana.');
                }
            }

            function populateModalWithData(data, activity) {
                let totalAccumulated = 0;

                data.forEach(plan => {
                    const monthElement = document.getElementById(`amount-${plan.month}`);
                    if (monthElement) {
                        const amount = parseFloat(plan.amount_withdrawn) || 0;
                        monthElement.value = amount === 0 ? "-" : window.formatAsIDRCurrency(amount);
                        totalAccumulated += amount;
                    }
                });

                let residual = activity.accumulatedSum - totalAccumulated;
                document.getElementById('withdrawalPlanModalLabel').innerText = `${activity.code} - ${activity.name}`;
                document.getElementById('totalAccumulated').textContent = window.formatAsIDRCurrency(totalAccumulated);
                document.getElementById('accumulatedTotalSum').innerText = window.formatAsIDRCurrency(activity.accumulatedSum);
                document.getElementById('residual').innerText = window.formatAsIDRCurrency(residual);
                document.getElementById('currentActivityId').value = activity.id;
                $('#withdrawalPlanModal').modal('show');
            }

            function showErrorAlert(title, message) {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'error'
                });
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
