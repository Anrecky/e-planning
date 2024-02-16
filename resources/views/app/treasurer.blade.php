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
                            Input Data Bendahara
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
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($treasurers as $treasurer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $treasurer->position }}
                                        </td>
                                        <td>
                                            {{ $treasurer->name }}
                                        </td>
                                        <td>
                                            {{ $treasurer->nik }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                data-bs-target="#editModal" data-bs-toggle="modal"
                                                data-treasurer="{{ $treasurer }}"
                                                data-update-url="{{ route('treasurer.update', $treasurer) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit-2">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                                onclick="window.confirmDelete({{ $treasurer->id }});">
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
                                            <form id="delete-form-{{ $treasurer->id }}"
                                                action="{{ route('treasurer.destroy', $treasurer->id) }}"
                                                method="POST" style="display: none;">
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Data Bendahara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('treasurer.store') }}" method="POST">
                        @csrf
                        <div class="form-group d-flex align-items-center my-2">
                            <button type="button" id="add-treasurer" class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <h2 class="ms-2 py-0 mb-0 h5">Bendahara</h2>
                        </div>

                        <div id="treasurer-inputs" class="mt-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">1.</span>
                                <input required type="text" name="treasurer_name[]" class="form-control"
                                    placeholder="Nama Bendahara">
                                <input required type="text" name="treasurer_nik[]" class="form-control"
                                    placeholder="NIK Bendahara">
                                <input required type="text" name="treasurer_position[]" class="form-control"
                                    placeholder="Jabatan Bendahara">

                                <button type="button" class="btn btn-danger remove-treasurer">
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
                    <h5 class="modal-title" id="editModalTitle">Edit Data Bendahara</h5>
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
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <script>
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
                const missionInputs = document.querySelectorAll('#treasurer-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }
            // Function to allow only numeric input
            function allowOnlyNumericInput(event) {
                // Check if the input value is not numeric
                if (isNaN(event.key)) {
                    // Prevent the default behavior of the event (i.e., typing non-numeric characters)
                    event.preventDefault();
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                const treasurerNikInputs = document.querySelectorAll('input[name="treasurer_nik[]"]');
                const editModalEl = document.getElementById('editModal');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                treasurerNikInputs.forEach(function(input) {
                    input.addEventListener('keydown', allowOnlyNumericInput);
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
                const TreasurerContainer = document.getElementById('treasurer-inputs');

                document.getElementById('add-treasurer').addEventListener('click', function() {
                    const index = TreasurerContainer.querySelectorAll('.input-group').length;
                    const newInputGroup = `<div class="input-group mb-2">
                                <span class="input-group-text">${index+1}.</span>
                                <input required type="text" name="treasurer_name[]" class="form-control" placeholder="Nama Bendahara">
                                <input required type="text" name="treasurer_nik[]" class="form-control" placeholder="NIK Bendahara">
                                <input required type="text" name="treasurer_position[]" class="form-control"
                                    placeholder="Jabatan Bendahara">

                                <button type="button" class="btn btn-danger remove-treasurer">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>`;
                    TreasurerContainer.insertAdjacentHTML('beforeend', newInputGroup);
                    const treasurerNikInputs = document.querySelectorAll('input[name="treasurer_nik[]"]');
                    treasurerNikInputs.forEach(function(input) {
                        input.addEventListener('keydown', allowOnlyNumericInput);
                    });
                    feather.replace();
                });

                TreasurerContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-treasurer')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });

                $(editModalEl).on('show.bs.modal', async function(e) {
                    let treasurer = $(e.relatedTarget).data('treasurer');
                    let updateUrl = $(e.relatedTarget).data('updateUrl');
                    const formEdit = $("#form-edit");

                    formEdit.attr('action', updateUrl);

                    formEdit.find('[name="name"]').val(treasurer.name);
                    formEdit.find('[name="nik"]').val(treasurer.nik);
                    formEdit.find('[name="nik"]').on('keydown', allowOnlyNumericInput);
                    formEdit.find('[name="position"]').val(treasurer.position);

                })

                function updateNumbering() {
                    const inputGroups = TreasurerContainer.querySelectorAll('.input-group');
                    inputGroups.forEach((group, index) => {
                        group.querySelector('.input-group-text').textContent = `${index + 1}.`;
                    });
                }
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
