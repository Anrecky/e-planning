<!-- <div class="text-start">
    <button type="button" id="btnCreateModal" class="btn btn-primary btn-md w-20 ms-4" data-bs-toggle="modal" data-bs-target="#createModal">Rekam Data Penerimaan</button>
</div> -->

<div class="table-responsive px-4 my-4">
    <div class="d-flex flex-wrap justify-content-between my-2 me-1">
        <div class="my-2">
            <button id="btnCreateModal" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#createModal">Rekam Data Penerimaan</button>
        </div>
    </div>
    <table id="reception-table" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col" class="text-white">KD Akun</th>
                <th scope="col" class="text-white">Uraian</th>
                <th scope="col" class="text-white">Perpajakan</th>
                <th scope="col" class="text-white">Umum</th>
                <th scope="col" class="text-white">Fungsional</th>
                <th scope="col" class="text-white">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receptions as $reception)
                <tr>
                    <td>{{ $reception->accountCodeReception->code }}</td>
                    <td>{{ $reception->description }}</td>
                    <td>{{ in_array('pajak', $reception->type) ? 'Rp ' . number_format($reception->revenue_target, 0, ',', '.') : '-' }}
                    </td>
                    <td>{{ in_array('umum', $reception->type) ? 'Rp ' . number_format($reception->revenue_target, 0, ',', '.') : '-' }}
                    </td>
                    <td>{{ in_array('fungsional', $reception->type) ? 'Rp ' . number_format($reception->revenue_target, 0, ',', '.') : '-' }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-target="#editModal"
                            data-bs-toggle="modal" data-reception="{{ $reception }}"
                            data-update-url="{{ route('reception.update', $reception) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit-2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </button>

                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                            onclick="window.confirmDelete({{ $reception->id }});">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                        <!-- Hidden form for delete request -->
                        <form id="delete-form-{{ $reception->id }}"
                            action="{{ route('reception.delete', $reception->id) }}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
