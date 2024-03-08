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
            .profile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1rem;
                /* Sesuaikan sesuai kebutuhan */
            }

            .profile-header h5 {
                /* Menghilangkan margin bawah default */
                margin-bottom: 0;
                /* Tinggi h5 */
                line-height: 24px;
                font-weight: bold;
            }

            .profile-header .btn-edit {
                /* Tinggi button */
                height: 32.1px;
            }

            .user-photo {
                width: 160px;
                height: 160px;
                border: 1px solid black;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-lg-8 layout-spacing">
            <div class="statbox widget box box-shadow mt-3 mt-md-0">
                <div class="widget-content widget-content-area">
                    <x-custom.alerts />
                    <!-- User Profile Title and Edit Button -->
                    <div class="profile-header">
                        <h5>User Profile</h5>
                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">Edit</a>
                    </div>

                    <div style="min-height:40vh;">
                        <div class="row">
                            <!-- User photo -->
                            <div class="col-md-12 text-start mb-3">
                                <img src="{{ Vite::asset('resources/images/user.svg') }}" class="user-photo rounded"
                                    alt="User Photo" style="width: 160px; height: 160px;">
                            </div>

                            <!-- User info dibagi menjadi dua kolom -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Name"
                                        value="{{ $user->name }}" readonly>
                                    <label for="floatingName">Nama Lengkap</label>
                                </div>
                                @foreach ($user->roles as $index => $role)
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingRole{{ $index }}"
                                            placeholder="Role" value="{{ $role->formatted_name ?? 'Tidak ada role' }}"
                                            readonly>
                                        <label for="floatingRole{{ $index }}">Role Pengguna</label>
                                    </div>
                                @endforeach
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingId" placeholder="Id"
                                        value="{{ $user->identity_number }}" readonly>
                                    <label for="floatingId">ID Pengguna</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingEmail" placeholder="Email"
                                        value="{{ $user->email }}" readonly>
                                    <label for="floatingEmail">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingField" placeholder="Field"
                                        value="{{ $user->work_unit_id }}" readonly>
                                    <label for="floatingField">Unit Kerja</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingBirthdate"
                                        placeholder="Birth Date" value="{{ $user->dob }}" readonly>
                                    <label for="floatingBirthdate">Tanggal Lahir</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingAddress"
                                        placeholder="Address" value="{{ $user->address }}" readonly>
                                    <label for="floatingAddress">Alamat</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingPhone"
                                        placeholder="Phone Number" value="{{ $user->phone }}" readonly>
                                    <label for="floatingPhone">Nomor Telepon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- this feature will be launch soon --}}
        {{-- <div class="col-lg-4 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="profile-header">
                        <h5>Activity Log</h5>
                    </div>
                    <div style="min-height:40vh;">
                        <!-- Space for additional content if needed -->
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalTitle">Edit Profile</h5>
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
                    <form id="editProfile-form" action="{{ route('my-profile.update', Auth::user()) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <!-- User photo -->
                            <div class="col-md-12 text-start mb-3">
                                <!-- Gambar yang akan diklik -->
                                <img src="{{ Vite::asset('resources/images/user.svg') }}" class="user-photo rounded"
                                    alt="User Photo" style="width: 160px; height: 160px; cursor: pointer;"
                                    onclick="document.getElementById('fileInput').click();">

                                <!-- Input file yang disembunyikan -->
                                <input type="file" name="photo" id="fileInput" class="form-control"
                                    style="display: none;" onchange="previewImage();">
                            </div>

                            <!-- User info dibagi menjadi dua kolom -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingName" name="name"
                                        placeholder="Name" value="{{ $user->name }}">
                                    <label for="floatingName">Nama Lengkap</label>
                                </div>
                                @foreach ($user->roles as $index => $role)
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control"
                                            id="floatingRole{{ $index }}" placeholder="Role"
                                            value="{{ $role->formatted_name ?? 'Tidak ada role' }}" readonly>
                                        <label for="floatingRole{{ $index }}">Role Pengguna</label>
                                    </div>
                                @endforeach
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingId"
                                        name="identity_number" placeholder="Id"
                                        value="{{ $user->identity_number }}">
                                    <label for="floatingId">ID Pengguna</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingEmail" name="email"
                                        placeholder="Email" value="{{ $user->email }}" readonly>
                                    <label for="floatingEmail">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingField"
                                        name="work_unit_id" placeholder="Field" value="{{ $user->work_unit_id }}">
                                    <label for="floatingField">Unit Kerja</label>
                                </div> --}}
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="floatingField" name="work_unit_id">
                                        <option value="">Pilih Unit Kerja...</option>
                                        @foreach ($workUnits as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ $user->work_unit_id == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingField">Unit Kerja</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingBirthdate" name="dob"
                                        placeholder="Birth Date" value="{{ $user->dob }}">
                                    <label for="floatingBirthdate">Tanggal Lahir</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingAddress" name="address"
                                        placeholder="Address" value="{{ $user->address }}">
                                    <label for="floatingAddress">Alamat</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingPhone" name="phone"
                                        placeholder="Phone Number" value="{{ $user->phone }}">
                                    <label for="floatingPhone">Nomor Telepon</label>
                                </div>

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
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            function previewImage() {
                var file = document.getElementById('fileInput').files;
                if (file.length > 0) {
                    var fileReader = new FileReader();

                    fileReader.onload = function(event) {
                        document.querySelector('.user-photo').setAttribute('src', event.target.result);
                    };

                    fileReader.readAsDataURL(file[0]);
                }
            }

            function openEditModal(id, name, email, identityNumber) {
                // Populate the form fields
                document.getElementById('floatingName').value = name;
                document.getElementById('floatingEmail').value = email;
                document.getElementById('floatingId').value = identityNumber;

                // Update the form action URL
                document.getElementById('editProfile-form').action =
                    '/profile'; // Menggunakan URL dasar untuk resource 'profile'


                // Show the modal
                new bootstrap.Modal(document.getElementById('editProfileModal')).show();
            }
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
