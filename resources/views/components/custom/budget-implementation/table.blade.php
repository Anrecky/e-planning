<div class="table-responsive my-4">
    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
        <div class="d-flex flex-wrap gap-1 my-2">
            <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#createModal">Rekam SubKomp</button>
            <button id="add-account_code_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                class="btn btn-primary shadow-sm">Rekam Akun</button>
            <button id="add-expenditure_detail_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                class="btn btn-primary shadow-sm">Rekam
                Detail</button>
        </div>
        <div class="d-flex flex-wrap gap-2 my-2">
            <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
            <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
            <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
        </div>
    </div>
    <table id="budget_implementation-table" class="table table-bordered">
        <thead>
            <tr>
                <th class="invisible"></th>
                <th style="background:none !important;border:none !important;border-radius:0 !important;width:fit-content !important;text-decoration-color:red !important;text-decoration-thickness:0.225rem !important;"
                    class="text-dark h3 text-center fw-bold text-decoration-underline">
                    Rp {{ number_format($totalSum, 0, ',', '.') }}
                </th>
            </tr>
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
            @foreach ($groupedBI as $activityCode => $accountGroups)
                @php $isActivityDisplayed = false; @endphp
                @foreach ($accountGroups as $accountCode => $budgetImplementations)
                    <!-- Activity Row -->
                    @if (!$isActivityDisplayed)
                        <tr data-activity="{{ $budgetImplementations->first()->activity->id }}"
                            data-bi="{{ $budgetImplementations->first()->id }}" class="activity-row">
                            <td>{{ $budgetImplementations->first()->activity->code }}</td>
                            <td>{{ $budgetImplementations->first()->activity->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Rp {{ number_format($budgetImplementations->first()->activity_total_sum, 0, ',', '.') }}
                            </td>
                        </tr>
                        @php $isActivityDisplayed = true; @endphp
                    @endif

                    @foreach ($budgetImplementations as $budgetImplementation)
                        @if ($budgetImplementation->accountCode)
                            <!-- Account Code Row -->
                            <tr data-bi="{{ $budgetImplementations->first()->id }}"
                                data-account-code="{{ $budgetImplementation->accountCode->id }}" class="account-row">
                                <td>{{ $budgetImplementation->accountCode->code }}</td>
                                <td>{{ $budgetImplementation->accountCode->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Rp
                                    {{ number_format($budgetImplementations->first()->account_total_sum, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif

                        @foreach ($budgetImplementation->details as $detail)
                            @if ($detail)
                                <!-- Expenditure Detail Row -->
                                <tr data-expenditure="{{ $detail->id }}" class="expenditure-row">
                                    <td></td> <!-- Empty cells for activity and account columns -->
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->volume }}</td>
                                    <td>{{ $detail->expenditureUnit->code }}</td>
                                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
