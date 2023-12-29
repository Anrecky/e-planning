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
        <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
        <style>
            .filepond--root {
                font-size: 16px;
                border-radius: 0.375rem;
                border: 1px solid #ced4da;
            }

            .filepond--drop-label {
                color: #495057;
                background-color: #e9ecef;
                padding: 10px;
                white-space: pre-wrap;
                text-align: center;
                border-bottom: 1px solid #ced4da;
            }

            .filepond--label-action {
                text-decoration: none;
                font-weight: bold;
                color: #007bff;
                /* Bootstrap primary color */
            }

            .filepond--panel-root {
                border-radius: 0.375rem;
            }

            .filepond--item {
                background-color: #f8f9fa;
                border-radius: 0.25rem;
                margin-bottom: 5px;
                border: 1px solid #ced4da;
            }

            .btn-outline-danger .feather-upload {
                stroke: #ff0000;
                /* Normal state color */
            }

            .btn-outline-danger:hover .feather-upload {
                stroke: white;
                /* Hover state color */
            }

            .btn-outline-success .feather-upload {
                stroke: #00ab55;
                /* Normal state color */
            }

            .btn-outline-success:hover .feather-upload {
                stroke: white;
            }


            .recap-description:hover {
                background-color: lightyellow;
                cursor: pointer;
                color: black;
                opacity: 1;
            }

            .recap-description {
                transition: 0.305s ease-in-out all;
                opacity: 0.95;
            }

            .valid-row td {
                background-color: #00ab55;
                color: white;
            }

            .valid-row button.btn-success {
                background: white;
                color: #00ab55 !important;
            }

            .valid-row button.btn-success:hover {
                background: black !important;
                color: white !important;
            }

            .invalid-row button.btn-danger {
                background: white;
                color: #e7515a !important;
            }

            .invalid-row button.btn-danger:hover {
                background: black !important;
                color: white !important;
            }

            .invalid-row td {
                background-color: #e7515a;
                color: white;
            }

            .invalid-row .feather-upload.accept {
                stroke: white;
            }

            .invalid-row button.btn-success:hover .feather-upload.accept {
                stroke: blue;
            }

            .invalid-row button.btn-success:hover .icon-name {
                color: blue !important;
            }

            .invalid-row button.btn-success:hover {
                background: white !important;
            }

            .valid-row .feather-upload.reject {
                stroke: white;
            }

            .valid-row button.btn-danger:hover .feather-upload.reject {
                stroke: blue;
            }

            .valid-row button.btn-danger:hover .icon-name {
                color: blue !important;
            }

            .valid-row button.btn-danger:hover {
                background: white !important;
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
                    <table id="activity_recap-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Kode</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Total</th>
                                <th scope="col">Upload Data Dukung</th>
                                <th style="width:20rem" scope="col">Aksi</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                <tr class="{{ $activity->activityRecap?->is_valid ? 'valid-row' : 'invalid-row' }}">
                                    <td id="activity-{{ $activity->id }}">{{ $activity->code }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->calculateTotalSumFormatted() }}</td>
                                    <td>
                                        @if ($activity->activityRecap && $activity->activityRecap?->attachment_path)
                                            @php
                                                $filePath = Storage::disk(App\Supports\Disk::ActivityRecapAttachment)->path($activity->activityRecap?->attachment_path);
                                                $fileMimeType = mime_content_type($filePath);
                                            @endphp

                                            {{-- "View File" Link/Button --}}
                                            <a href="{{ route('activity-recap.show-file', $activity->activityRecap) }}"
                                                class="btn btn-primary btn-sm"
                                                @if ($fileMimeType == 'application/pdf') target="_blank"
                                               @elseif ($fileMimeType == 'application/zip') download @endif>
                                                <i class="feather icon-eye"></i> Lihat File
                                            </a>

                                            {{-- "Change File" Button --}}
                                            <button type="button" class="btn btn-secondary btn-sm ms-2"
                                                onclick="showFilePondInput('{{ $activity->id }}');">
                                                <i class="feather icon-edit"></i> Ganti File
                                            </button>

                                            {{-- Hidden FilePond Input --}}
                                            <input type="file" id="filepond-{{ $activity->id }}"
                                                class="filepond d-none mt-3" name="filepond" />
                                        @else
                                            {{-- File Input for New Upload --}}
                                            <input type="file" class="filepond" name="filepond" />
                                        @endif
                                    </td>


                                    <td style="width: 15rem">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            {{-- Reject Button --}}
                                            <button type="button"
                                                class="btn-lg btn btn-danger text-center d-flex justify-content-center align-items-center gap-1 update-status"
                                                data-activity-id="{{ $activity->id }}" data-new-status="0">
                                                <i data-feather="x-square" class="feather-upload reject"></i><span
                                                    class="icon-name">Tolak</span>
                                            </button>
                                            {{-- Accept Button --}}
                                            <button type="button"
                                                class="btn-lg btn btn-success text-center d-flex justify-content-center align-items-center gap-1 update-status"
                                                data-activity-id="{{ $activity->id }}" data-new-status="1">
                                                <i data-feather="check-square" class="feather-upload accept"></i><span
                                                    class="icon-name">Terima</span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="recap-description">
                                        {{ $activity->activityRecap?->description ?? '' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="bg-light" style="height:5rem">Tidak Ada Data...</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="text-end">
                        <button id="save-activity_recap" class="btn btn-primary btn-md">Simpan Data</button>
                    </div>
                </div>

            </x-custom.statbox>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
        <script>
            let ponds = [];

            function showFilePondInput(activityId) {
                var filePondInput = document.getElementById('filepond-' + activityId);
                if (filePondInput) {
                    $(filePondInput).toggleClass('d-none');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                FilePond.registerPlugin(
                    FilePondPluginFileValidateType,
                    FilePondPluginFileValidateSize
                );
                FilePond.setOptions({
                    labelIdle: `<span class="filepond--label-action"><i data-feather="upload"></i> Upload Data Dukung</span>`
                });

                const theadTh = document.querySelectorAll('thead tr th');
                const fileInputs = document.querySelectorAll('.filepond');
                const recapDescriptions = document.querySelectorAll('.recap-description');
                const trActivityRecaps = document.querySelectorAll('tbody tr');
                const btnSave = document.getElementById('save-activity_recap');

                theadTh.forEach(th => th.classList.add('bg-primary'));

                // Event listener for status update buttons
                document.querySelectorAll('.update-status').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var activityId = this.getAttribute('data-activity-id');
                        var newStatus = this.getAttribute('data-new-status');

                        updateActivityStatus(activityId, newStatus);
                    });
                });

                fileInputs.forEach(inputElement => {
                    // Create FilePond instance
                    const pond = FilePond.create(inputElement, {
                        acceptedFileTypes: [
                            'application/pdf',
                            '.rar',
                            'application/zip',
                            'application/octet-stream' // Additional MIME type for ZIP files
                        ],
                        fileValidateTypeLabelExpectedTypesMap: {
                            'application/pdf': '.pdf',
                            'application/zip': '.zip',
                            'application/octet-stream': '.zip',
                            '.rar': 'RAR Archive'
                        }
                    });
                    ponds.push(pond);
                    setTimeout(() => feather.replace(), 0);
                });
                recapDescriptions.forEach(function(cell) {
                    cell.addEventListener('click', function() {
                        // Make the cell editable when clicked
                        cell.setAttribute('contenteditable', 'true');
                        cell.focus(); // Optional: to immediately focus the cell
                    });

                    cell.addEventListener('blur', function() {
                        // Remove the contenteditable attribute when focus is lost
                        cell.removeAttribute('contenteditable');

                        const editedText = cell.innerText;
                    });
                });
                btnSave.addEventListener('click', handleSaveActivityRecapRows);

                async function handleSaveActivityRecapRows() {
                    let formData = new FormData();

                    trActivityRecaps.forEach((row, index) => {
                        // Get the corresponding FilePond instance
                        const pond = ponds[index];
                        if (pond && pond.getFiles().length > 0) {
                            const file = pond.getFiles()[0].file;
                            formData.append(`files[${index}]`, file, file.name);
                        }

                        // Get activity ID from the first cell
                        const activityID = row.querySelector('td:first-child').id.replace('activity-', '');

                        // Get description from the recap-description cell
                        let descriptionEl = row.querySelector('.recap-description');
                        const description = descriptionEl ? descriptionEl.textContent : '';

                        formData.append(`activityIDs[${index}]`, activityID);
                        formData.append(`descriptions[${index}]`, description);
                    });

                    // Axios POST request
                    try {
                        const response = await axios.post('{{ route('activity_recap.store') }}', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil menyimpan data rekap kegiatan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the window when the user clicks "OK"
                            window.location.reload();
                        });
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

                // Function to send AJAX request to update status
                function updateActivityStatus(activityId, newStatus) {
                    axios.post('{{ route('activity_recap.update_status') }}', {
                            activity_id: activityId,
                            is_valid: newStatus
                        })
                        .then(function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil mengubah status validitas.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reload the window when the user clicks "OK"
                                window.location.reload();
                            });
                        })
                        .catch(function(error) {
                            Swal.fire({
                                title: 'Gangguan!',
                                text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }


            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
