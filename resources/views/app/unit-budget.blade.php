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
        <style>
            .table-hover tbody tr:hover {
                background-color: #f5f5f5;
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
                <div class="widget-content widget-content-area">
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
                        <table id="unit_budget-table" class="table table-bordered ">
                            <thead class="bg-light">
                                <tr class="text-center">
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Unit Kerja</th>
                                    <th scope="col">Pagu</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($unitBudgets as $unitBudget)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="form-group my-auto">
                                                <select class="form-select select-work_unit" autocomplete="false">
                                                    @foreach ($workUnits as $option)
                                                        <option value="{{ $option->id }}"
                                                            {{ $unitBudget->work_unit_id == $option->id ? 'selected' : '' }}>
                                                            {{ $option->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td class="pagu text-center">{{ $unitBudget->pagu }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-secondary text-white addRowButton">
                                                <i data-feather="plus" class="text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div class="form-group my-auto">
                                                <select class="form-select select-work_unit" autocomplete="false">
                                                    @foreach ($workUnits as $option)
                                                        <option value="{{ $option->id }}">
                                                            {{ $option->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td class="pagu text-center">{{ $unitBudget->pagu ?? 0 }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-secondary text-white addRowButton">
                                                <i data-feather="plus" class="text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div class="text-end">
                            <button id="save-unit_budgets" class="btn btn-primary btn-md">Simpan Data</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/input-mask/input-mask.js') }}"></script>
        <script>
            var workUnits = @json($workUnits);
            var selectedValues = [...getSelectedWorkUnitIds()]; // Array to keep track of selected values
            function getSelectedWorkUnitIds() {
                // Fetch all the selected work unit ids from the table
                return Array.from(document.querySelectorAll('#unit_budget-table .select-work_unit'))
                    .map(select => select.value) // get the values
                    .filter(value => value !== ''); // exclude empty (unselected) values
            }

            console.log(getSelectedWorkUnitIds())

            function canAddRow() {
                return selectedValues.length < workUnits.length;
            }

            function addRow() {
                var lastRowSelect = document.querySelector('#unit_budget-table tr:last-child .select-work_unit');
                if (!lastRowSelect || lastRowSelect.value === '' || lastRowSelect.value === 'Pilih Unit Kerja') {
                    Swal.fire("Attention", "Silahkan pilih unit kerja sebelum menambah baris baru.", "warning");
                    return;
                }
                if (!canAddRow()) {
                    Swal.fire("Full", "Unit kerja sudah terpilih semua.", "info");
                    return;
                }
                var table = document.getElementById("unit_budget-table");
                var rowCount = table.rows.length;
                var row = table.insertRow(rowCount);

                // Create and insert cells (`<td>`) in the row
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                // Populate cells
                cell1.innerHTML = rowCount; // For No.
                cell2.innerHTML =
                    '<div class="form-group my-auto"><select class="form-select select-work_unit"></select></div>';
                cell3.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format('0'); // For pagu
                cell3.className = 'pagu text-center';
                cell4.innerHTML =
                    '<button onclick="addRow()" type="button" class="btn btn-secondary text-white addRowButton"><i data-feather="plus" class="text-white"></i></button>';
                cell4.className = 'text-center';

                var newSelect = row.querySelector('.select-work_unit');
                var defaultOption = document.createElement('option');
                defaultOption.textContent = 'Pilih Unit Kerja';
                defaultOption.value = '';
                newSelect.appendChild(defaultOption);


                var existingOptions = document.querySelector('.select-work_unit').options;
                for (var i = 0; i < existingOptions.length; i++) {
                    if (!selectedValues.includes(existingOptions[i].value)) {
                        var option = existingOptions[i].cloneNode(true);
                        newSelect.appendChild(option);
                    }
                }

                // Attach event listener to new select
                newSelect.addEventListener('change', handleSelectChange);
                $(newSelect).val("")
                feather.replace();
            }

            function handleSelectChange() {
                var selectedValue = this.value;
                selectedValues.push(selectedValue); // Add the selected value to the array

                var allSelects = document.querySelectorAll('.select-work_unit');
                allSelects.forEach(function(select) {
                    if (select !== this) {
                        for (var i = 0; i < select.options.length; i++) {
                            if (select.options[i].value === selectedValue) {
                                select.remove(i);
                            }
                        }
                    }
                }.bind(this));
            }

            function makeEditable(e) {
                if (e.target.classList.contains('pagu')) {
                    var currentValue = e.target.innerHTML.replace(/[Rp. ,]/g, ''); // Remove existing formatting
                    e.target.innerHTML = '<input class="form-control text-center pagu-mask" type="text" value="' +
                        currentValue + '" onBlur="updatePagu(this)" />';
                    var inputElement = e.target.firstChild;
                    inputElement.focus();

                    // Apply Inputmask for Rupiah formatting
                    $(inputElement).inputmask({
                        alias: 'numeric',
                        groupSeparator: '.',
                        radixPoint: ',',
                        digits: 2,
                        autoGroup: true,
                        prefix: 'Rp ', // Space after Rp
                        rightAlign: false,
                        removeMaskOnSubmit: true,
                        unmaskAsNumber: true
                    });
                }
            }


            function updatePagu(inputElement) {
                // Get unmasked value
                var unmaskedValue = $(inputElement).inputmask('unmaskedvalue');
                var formattedValue = 'Rp ' + new Intl.NumberFormat('id-ID').format(unmaskedValue);
                var cell = inputElement.parentElement;
                cell.innerHTML = formattedValue;
            }

            function saveUnitBudgets() {
                var table = document.getElementById('unit_budget-table');
                var rows = table.querySelectorAll('tbody tr');
                var unitBudgets = [];

                rows.forEach(function(row, index) {
                    var unitId = row.querySelector('.select-work_unit').value;
                    var pagu = row.querySelector('.pagu').textContent.replace(/[Rp. ,]/g, '');

                    if (unitId && pagu) { // Ensure both values are present
                        unitBudgets.push({
                            work_unit_id: unitId,
                            pagu: pagu
                        });
                    }
                });

                // POST request using Axios
                axios.post('{{ route('unit_budget.store') }}', unitBudgets)
                    .then(function(response) {
                        Swal.fire("Success", "Pagu unit berhasil disimpan.", "success")
                            .then(() => window.location.reload());
                    })
                    .catch(function(error) {
                        Swal.fire("Error", "Error saving data: " + error, "error");
                    });
            }
            window.addEventListener('load', function() {
                feather.replace();
            })

            document.addEventListener('DOMContentLoaded', function() {

                $('.pagu').each(function() {
                    var oldPaguText = $(this).text();
                    $(this).text('Rp ' + new Intl.NumberFormat('id-ID').format(oldPaguText))

                })
                $('.addRowButton').on('click', addRow);
                $('#unit_budget-table').on('click', makeEditable);
                var selects = document.querySelectorAll('.select-work_unit');
                selects.forEach(function(select) {
                    select.addEventListener('change', handleSelectChange);
                });
                document.getElementById('save-unit_budgets').addEventListener('click', saveUnitBudgets);
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
