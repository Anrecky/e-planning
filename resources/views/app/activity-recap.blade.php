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
        @vite(['resources/scss/light/assets/custom.scss'])
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

            /* Style for Feather icons */
            .feather {
                width: 24px;
                height: 24px;
                stroke-width: 2;
                stroke: #007bff;
                /* Bootstrap primary color */
                fill: none;
                stroke-linecap: round;
                stroke-linejoin: round;
            }

            .btn-outline-danger .feather-upload {
                stroke: #ff0000;
                /* Normal state color */
            }

            .btn-outline-danger:hover .feather-upload {
                stroke: white;
                /* Hover state color */
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
                                <th scope="col">Upload Data Bukti</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->code }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                        <input type="file" class="filepond" name="filepond" />
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn-lg btn btn-outline-danger text-center d-flex justify-content-center align-items-center gap-1">
                                            <i data-feather="x-square" class="feather-upload"></i><span
                                                class="icon-name">
                                                Tolak</span>
                                        </button>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            document.addEventListener('DOMContentLoaded', function() {
                FilePond.registerPlugin(
                    FilePondPluginFileValidateType,
                    FilePondPluginFileValidateSize
                );
                FilePond.setOptions({
                    labelIdle: `<span class="filepond--label-action"><i data-feather="upload"></i> Upload Data Bukti</span>`
                });

                const theadTh = document.querySelectorAll('thead tr th');
                const fileInputs = document.querySelectorAll('.filepond');

                theadTh.forEach(th => th.classList.add('bg-primary'));

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
                    setTimeout(() => feather.replace(), 0);
                });
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
