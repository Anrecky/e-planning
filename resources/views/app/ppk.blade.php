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
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        <style>
            td,
            th {
                border-radius: 0px !important;
            }

            th {
                color: white !important;
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
                <div style="min-height:50vh;" class="widget-content widget-content-area">
                    <div class="p-3 container">
                        <x-custom.alerts />
                    </div>

                    <div class="d-flex justify-content-center justify-content-sm-start">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20 ms-4" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input Data PPK
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="zero-config" class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">NIP/NIK/NIDN</th>
                                    <th scope="col">Akun PPK</th>
                                    <th scope="col">Akun Staf</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ppks as $ppk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $ppk->position }}
                                        </td>
                                        <td>
                                            {{ $ppk->name }}
                                        </td>
                                        <td>
                                            {{ $ppk->nik }}
                                        </td>
                                        <td>
                                            {!! $ppk->user_account
                                                ? $ppk->user->name . '<br>' . $ppk->user->identity_number . '<br>' . $ppk->user->email
                                                : '' !!}
                                        </td>
                                        <td>
                                            {!! $ppk->staff_account
                                                ? $ppk->staff->name . '<br>' . $ppk->staff->identity_number . '<br>' . $ppk->staff->email
                                                : '' !!}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-bs-target="#editModal" data-bs-toggle="modal"
                                                data-ppk="{{ $ppk }}"
                                                data-update-url="{{ route('ppk.update', $ppk) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit-2">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                                onclick="window.confirmDelete({{ $ppk->id }});">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </a>
                                            <!-- Hidden form for delete request -->
                                            <form id="delete-form-{{ $ppk->id }}"
                                                action="{{ route('ppk.destroy', $ppk->id) }}" method="POST"
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
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Data PPK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ppk.store') }}" method="POST">
                        @csrf
                        <div class="form-group d-flex align-items-center my-2">
                            <button type="button" id="add-ppk" class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <h2 class="ms-2 py-0 mb-0 h5">PPK</h2>
                        </div>

                        <div id="ppk-inputs" class="mt-2 ppk-inputs">
                            <div class="input-group mb-2">
                                <span class="input-group-text">1.</span>
                                <input required type="text" name="ppk_name[]" class="form-control"
                                    placeholder="Nama PPK">
                                <input required type="text" name="ppk_nik[]" class="form-control"
                                    placeholder="NIK PPK">
                                <input required type="text" name="ppk_position[]" class="form-control"
                                    placeholder="Jabatan PPK">
                                <select required name="ppk_user_account[]" class=" createSelectUsers form-control">
                                </select>
                                <select required name="ppk_staff_account[]"
                                    class=" createSelectStaffUsers form-control">
                                </select>
                                <button type="button" class="btn btn-danger remove-ppk">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-success text-center align-items-center mt-1 mt-2 py-auto"
                            type="submit">
                            <i data-feather="save"></i><span class="icon-name ms-1">Simpan</span>
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
                    <h5 class="modal-title" id="editModalTitle">Edit Data PPK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-edit" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-2">
                            <label>Nama</label>
                            <input required type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label>NIP/NIK/NIDN</label>
                            <input required type="text" name="nik" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label>Jabatan</label>
                            <input required type="text" name="position" class="form-control">
                        </div>
                        <div class="form-group mb-2 w-100">
                            <label>Akun PPK</label>
                            <select required name="user_account" style="width: 100%"
                                class="w-100 createSelectUsersEdit form-control">
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Akun Staff</label>
                            <select required name="staff_account"
                                style="width: 100%"class=" createSelectStaffUsersEdit form-control">
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn mt-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })


            function renderSelect2() {
                $('.createSelectUsers').select2({
                    dropdownParent: $("#exampleModalCenter"),
                    placeholder: 'Pilih Akun PPK',
                    theme: 'bootstrap-5',
                    ajax: {
                        transport: function(params, success, failure) {
                            // Using Axios to fetch the data
                            axios.get(`{{ url('api/search-user') }}`, {
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
                                                text: item.name + ' - ' +
                                                    item
                                                    .identity_number
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

                $('.createSelectStaffUsers').select2({
                    dropdownParent: $("#exampleModalCenter"),
                    placeholder: 'Pilih Akun Staff',
                    theme: 'bootstrap-5',
                    ajax: {
                        transport: function(params, success, failure) {
                            // Using Axios to fetch the data
                            axios.get(`{{ url('api/search-user') }}`, {
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
                                                text: item.name + ' - ' +
                                                    item
                                                    .identity_number
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
            }
            renderSelect2();

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
                const missionInputs = document.querySelectorAll('#ppk-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                const ppkNikInputs = document.querySelectorAll('input[name="ppk_nik[]"]');
                const editModalEl = document.getElementById('editModal');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                ppkNikInputs.forEach(function(input) {
                    // Restrict keyboard input
                    $(input).on('keydown', allowOnlyNumericInput);
                    // Handle paste events
                    $(input).on('paste', handlePaste);
                });
                $('#zero-config').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'btn btn-danger', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'PDF_Export_' + n;
                            },
                            customize: function(doc) {
                                doc.styles.tableHeader.alignment = 'left'; // Contoh penyesuaian
                                // Tambahkan kustomisasi pdfmake Anda di sini
                                doc.content[1].table.widths = ['auto', '*', '*'];
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-success', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'Excel_Export_' + n;
                            },
                        }
                    ],
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });
                const PPKContainer = document.getElementById('ppk-inputs');

                document.getElementById('add-ppk').addEventListener('click', function() {
                    const index = PPKContainer.querySelectorAll('.input-group').length;
                    const newInputGroup = `<div class="input-group mb-2">
                                <span class="input-group-text">${index+1}.</span>
                                <input required type="text" name="ppk_name[]" class="form-control" placeholder="Nama PPK">
                                <input required type="text" name="ppk_nik[]" class="form-control" placeholder="NIK PPK">
                                <input required type="text" name="ppk_position[]" class="form-control"
                                    placeholder="Jabatan PPK">
                                <select required name="ppk_staff" class=" createSelectUsers form-control">
                                </select>
                                <button type="button" class="btn btn-danger remove-ppk">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>`;
                    PPKContainer.insertAdjacentHTML('beforeend', newInputGroup);
                    const ppkNikInputs = document.querySelectorAll('input[name="ppk_nik[]"]');
                    ppkNikInputs.forEach(function(input) {
                        // Restrict keyboard input
                        $(input).on('keydown', allowOnlyNumericInput);
                        // Handle paste events
                        $(input).on('paste', handlePaste);
                    });
                    feather.replace();
                    renderSelect2();

                });

                PPKContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-ppk')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });

                $(editModalEl).on('show.bs.modal', async function(e) {
                    let ppk = $(e.relatedTarget).data('ppk');
                    let updateUrl = $(e.relatedTarget).data('updateUrl');
                    const formEdit = $("#form-edit");

                    formEdit.attr('action', updateUrl);

                    formEdit.find('[name="name"]').val(ppk.name);
                    formEdit.find('[name="nik"]').val(ppk.nik);
                    // Restrict keyboard input
                    formEdit.find('[name="nik"]').on('keydown', allowOnlyNumericInput);
                    // Handle paste events
                    formEdit.find('[name="nik"]').on('paste', handlePaste);
                    formEdit.find('[name="position"]').val(ppk.position);
                    $('.createSelectUsersEdit').select2({
                        dropdownParent: $("#editModal"),
                        placeholder: 'Pilih Akun PPK',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ url('api/search-user') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results
                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item.id,
                                                    text: item.name +
                                                        ' - ' +
                                                        item
                                                        .identity_number
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

                    $('.createSelectStaffUsersEdit').select2({
                        dropdownParent: $("#editModal"),
                        placeholder: 'Pilih Akun Staff',
                        theme: 'bootstrap-5',
                        ajax: {
                            transport: function(params, success, failure) {
                                // Using Axios to fetch the data
                                axios.get(`{{ url('api/search-user') }}`, {
                                        params: {
                                            search: params.data.term,
                                            limit: 10
                                        }
                                    })
                                    .then(function(response) {
                                        // Call the `success` function with the formatted results
                                        success({
                                            results: response.data.map(function(
                                                item) {
                                                return {
                                                    id: item.id,
                                                    text: item.name +
                                                        ' - ' +
                                                        item
                                                        .identity_number
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
                    if (ppk.user_account) {
                        formEdit.find('[name="user_account"]').append('<option value=' + ppk.user_account +
                            '>' + ppk.user.name + ' - ' + ppk.user.identity_number + '</option>');
                        formEdit.find('[name="user_account"]').val(ppk.user_account).trigger('change');
                    } else {
                        formEdit.find('[name="user_account"]').val('').trigger('change');
                    }
                    if (ppk.staff_account) {
                        formEdit.find('[name="staff_account"]').append('<option value=' + ppk
                            .staff_account +
                            '>' + ppk.staff.name + ' - ' + ppk.staff.identity_number + '</option>');
                        formEdit.find('[name="staff_account"]').val(ppk.staff_account).trigger('change');
                    } else {
                        formEdit.find('[name="staff_account"]').val('').trigger('change');
                    }
                })

                function updateNumbering() {
                    const inputGroups = PPKContainer.querySelectorAll('.input-group');
                    inputGroups.forEach((group, index) => {
                        group.querySelector('.input-group-text').textContent = `${index + 1}.`;
                    });
                }
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
