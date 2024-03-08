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
            .input-group .toggle-password {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-right: 0;
            }

            td,
            th {
                border-radius: 0px !important;
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
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}

                        <div id="messageContainer" style="display: none;">
                            <div id="successMessage" class="alert alert-success"></div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('errors') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                    </div>

                    <div class="text-start">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20 ms-4" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input User
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="zero-config" class="table table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">User Role</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="width:40px;">{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span>{{ $role->formatted_name }}</span>{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td class="text-center ">
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                                <i class="text-white" data-feather="edit-2"></i>
                                            </button>

                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                                onclick="confirmDelete({{ $user->id }});">
                                                <i class="text-white" data-feather="trash-2"></i>
                                            </a>
                                            <!-- Hidden form for delete request -->
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('user.delete', $user->id) }}" method="POST"
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input User</h5>
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
                    <form id="form-create" action="{{ route('user.store') }}" method="POST" novalidate>
                        @csrf
                        <div id="user-inputs" class="mt-2">
                            <div class="mb-4 row align-items-center">
                                <label for="selectTypeRole" class="col-sm-4 col-form-label">Pilih Role</label>
                                <div class="col-sm-8">
                                    <select class="form-select @error('user_role') is-invalid @enderror"
                                        id="selectTypeRole" name="user_role" required>
                                        <option selected disabled value="">Pilih Jenis Role...</option>
                                        @foreach ($formattedRoles as $role)
                                            <option value="{{ $role['name'] }}"
                                                {{ old('user_role') == $role['name'] ? 'selected' : '' }}>
                                                {{ $role['formatted_name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label for="inputFullName" class="col-sm-4 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control @error('user_name') is-invalid @enderror"
                                        id="inputFullName" name="user_name" value="{{ old('user_name') }}" required>
                                    @error('user_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label for="inputNumberId" class="col-sm-4 col-form-label">NIP/NIK/NIDN</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        class="form-control @error('identity_number') is-invalid @enderror"
                                        id="inputNumberId" name="identity_number"
                                        value="{{ old('identity_number') }}" required>
                                    @error('identity_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email"
                                        class="form-control @error('user_email') is-invalid @enderror" id="inputEmail"
                                        name="user_email" value="{{ old('user_email') }}" required>
                                    @error('user_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="submitButton" class="btn btn-primary" type="submit">
                                    <span class="icon-name">Simpan</span>
                                </button>
                            </div>
                        </div>
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
                    <h5 class="modal-title" id="editModalTitle">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        {{-- <div class="form-group">
                            <label>Pilih Role</label>
                            <select class="form-select @error('user_role') is-invalid @enderror" id="selectTypeRole"
                                name="user_role" required>
                                <option selected disabled value="">Pilih Jenis Role...</option>
                                <option value="admin" {{ old('user_role') == 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="operator" {{ old('user_role') == 'operator' ? 'selected' : '' }}>
                                    Operator</option>
                                <option value="bendahara_penerimaan"
                                    {{ old('user_role') == 'bendahara_penerimaan' ? 'selected' : '' }}>
                                    Bendahara Penerimaan</option>
                                <option value="pengelola_aset"
                                    {{ old('user_role') == 'pengelola_aset' ? 'selected' : '' }}>Pengelola Aset
                                </option>
                                <option value="staf_ppk" {{ old('user_role') == 'staf_ppk' ? 'selected' : '' }}>Staf
                                    PPK</option>
                            </select>
                            @error('user_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="form-group mt-3">
                            <label>Nama Lengkap</label>
                            <input type="text" id="user_name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Email</label>
                            <input type="text" id="user_email" name="email" class="form-control" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password Baru? (opsional)</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password Baru" value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Add other fields as needed -->
                        {{-- <button type="submit" class="btn btn-primary mt-3">Update</button> --}}
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" type="submit">
                                <span class="icon-name">Update</span>
                            </button>
                        </div>
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
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

        <script>
            window.onload = function() {
                document.querySelectorAll('input[type="password"]').forEach(function(input) {
                    input.value = '';
                });
            };

            function openEditModal(id, name, email) {
                // Populate the form fields
                document.getElementById('user_name').value = name;
                document.getElementById('user_email').value = email;

                // Update the form action URL
                document.getElementById('edit-form').action = '/admin/pengaturan/user/' + id + '/update';

                // Show the modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            window.addEventListener('load', function() {
                feather.replace();
            })

            // Function to toggle password visibility
            function togglePasswordVisibility(event) {
                const button = event.target.tagName === 'I' ? event.target.parentNode : event.target;
                const passwordInput = button.previousElementSibling;

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    button.innerHTML = '<i data-feather="eye-off" class="feather icon-eye-off"></i>';
                } else {
                    passwordInput.type = 'password';
                    button.innerHTML = '<i data-feather="eye" class="feather icon-eye"></i>';
                }
                feather.replace();
            }

            function updateNumbering() {
                const missionInputs = document.querySelectorAll('#user-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                $('#zero-config').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
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

                $(document).ready(function() {
                    $('#form-create, #edit-form').submit(function(e) {
                        e.preventDefault(); // Mencegah form dari submit biasa

                        var form = $(this);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize(), // Mengumpulkan semua inputan form
                            success: function(data) {
                                // Simpan pesan sukses ke sessionStorage
                                sessionStorage.setItem('successMessage', data.success ||
                                    'User berhasil ditambahkan!');

                                // Reload halaman
                                window.location.reload();
                            },
                            error: function(response) {
                                $('.invalid-feedback').remove();
                                $('.form-control, .form-select').removeClass('is-invalid');

                                if (response.responseJSON && response.responseJSON.errors) {
                                    var errors = response.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        var input = form.find('[name="' + key +
                                            '"]');
                                        input.addClass('is-invalid').after(
                                            '<div class="invalid-feedback">' +
                                            value[0] +
                                            '</div>'
                                        );
                                    });
                                } else {
                                    // Tampilkan pesan error generik atau log untuk debugging
                                    console.error(
                                        "Terjadi kesalahan server. Silakan coba lagi.");
                                }
                            }
                        });
                    });

                    // Cek sessionStorage untuk pesan sukses setelah reload
                    var successMessage = sessionStorage.getItem('successMessage');
                    if (successMessage) {
                        // Tampilkan pesan sukses
                        $('#messageContainer').show();
                        $('#successMessage').text(successMessage);

                        // Hapus pesan sukses dari sessionStorage
                        sessionStorage.removeItem('successMessage');

                        // Opsional: Sembunyikan pesan sukses setelah beberapa detik
                        setTimeout(function() {
                            $('#messageContainer').fadeOut('slow');
                        }, 5000);
                    }
                });
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
