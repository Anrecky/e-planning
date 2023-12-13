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
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


        <style>
            td,
            th {
                border-radius: 0px !important;
            }

            td{
                white-space: normal !important;
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

            .select2-container--open {
                z-index: 999999 !important;
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
                    <div class="p-2 container">
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
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                    </div>

                    <div class="text-start">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input Indikator Kinerja
                        </button>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Sasaran Program</th>
                                    <th scope="col">Indikator Kinerja</th>
                                    <th scope="col">Target</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programTargetsHasPerformanceIndicators as $programTarget)
                                    @foreach ($programTarget->performanceIndicators as $index => $performanceIndicator)
                                        <tr>
                                            @if ($index == 0)
                                                <td rowspan="{{ count($programTarget->performanceIndicators) }}">
                                                    {{ $loop->parent->iteration }}</td>
                                                <td rowspan="{{ count($programTarget->performanceIndicators) }}">
                                                    {{ $programTarget->name }}</td>
                                            @endif
                                            <td>{{ $performanceIndicator->name }}</td>
                                            <td>{{ number_format((float) $performanceIndicator->value, 2, '.') }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="openEditModal({{ $performanceIndicator->id }}, '{{ $performanceIndicator->name }}','{{ number_format((float) $performanceIndicator->value, 2, '.') }}')">
                                                    <i class="text-white" data-feather="edit-2"></i>
                                                </button>

                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                                    role="button"
                                                    onclick="confirmDelete({{ $performanceIndicator->id }});">
                                                    <i class="text-white" data-feather="trash-2"></i>
                                                </a>
                                                <!-- Hidden form for delete request -->
                                                <form id="delete-form-{{ $performanceIndicator->id }}"
                                                    action="{{ route('performance_indicator.delete', $performanceIndicator->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{ $programTargetsHasPerformanceIndicators->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Indikator Kinerja
                    </h5>
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
                    <form action="{{ route('performance_indicator.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="program_target">Sasaran Program</label>
                            <select id="program_target" name="program_target_id" class="form-control select2">
                                <option value="">Pilih Sasaran Program</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>

                        <div class="form-group d-flex align-items-center my-2">
                            <button type="button" id="add-performance_indicator"
                                class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <label for="performance_indicator" class="ms-2 py-0 mb-0">Indikator Kinerja</label>
                        </div>

                        <div id="performance_indicator-inputs" class="mt-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">1.</span>
                                <input type="text" name="performance_indicator[]" class="form-control">
                                <button type="button" class="btn btn-danger remove-performance_indicator">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-success text-center align-items-center mt-1 mt-2 py-auto"
                            type="submit">
                            <i data-feather="save"></i><span class="icon-name">Simpan</span>
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Indikator Kinerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Indikator Kinerja</label>
                            <input type="text" id="performance_indicator_name" name="name"
                                class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Target</label>
                            <input type="text" id="performance_indicator_value" name="value"
                                class="form-control" required>
                        </div>
                        <!-- Add other fields as needed -->
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            function openEditModal(id, name, value) {
                // Populate the form fields
                document.getElementById('performance_indicator_name').value = name;
                document.getElementById('performance_indicator_value').value = value;

                // Update the form action URL
                document.getElementById('edit-form').action = '/admin/perkin/indikator-kinerja/' + id + '/update';

                // Show the modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            window.addEventListener('load', function() {
                feather.replace();
            })

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Anda yakin ingin hapus?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            function updateNumbering() {
                const missionInputs = document.querySelectorAll('#performance_indicator-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }
            document.addEventListener('DOMContentLoaded', function() {
                const missionContainer = document.getElementById('performance_indicator-inputs');

                document.getElementById('add-performance_indicator').addEventListener('click', function() {
                    const newInput = `<div class="input-group mb-2">
                        <span class="input-group-text"></span>
                        <input type="text" name="performance_indicator[]" class="form-control">
                        <button type="button" class="btn btn-danger remove-performance_indicator">
                            <i data-feather="trash"></i>
                        </button>
                      </div>`;
                    missionContainer.insertAdjacentHTML('beforeend', newInput);
                    feather.replace();
                    updateNumbering();
                });

                missionContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-performance_indicator')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });
            });
            $('#exampleModalCenter').on('shown.bs.modal', function() {
                $('#program_target').select2({
                    dropdownParent: $('#exampleModalCenter'),
                    placeholder: 'Pilih Sasaran Program',
                    theme: 'bootstrap-5',
                    ajax: {
                        transport: function(params, success, failure) {
                            // Using Axios to fetch the data
                            axios.get(`{{ route('program-targets.index') }}`, {
                                    params: {
                                        search: params.data.term,
                                        limit: 10
                                    }
                                })
                                .then(function(response) {
                                    // Call the `success` function with the formatted results
                                    success({
                                        results: response.data.map(function(item) {
                                            return {
                                                id: item.id,
                                                text: item.name
                                            };
                                        })
                                    });
                                })
                                .catch(function(error) {
                                    // Call the `failure` function in case of an error
                                    failure(error);
                                });
                        },
                        delay: 250,
                        cache: true
                    }
                });

            }).on('hidden.bs.modal', function() {
                $('#program_target').select2('destroy');
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
