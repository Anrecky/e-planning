<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
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
                        <div class="alert alert-light-success alert-dismissible fade show border-0 mb-4" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="alert">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg></button> <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    @endif


                    <div class="container mt-4">
                        <div class="row px-4 mb-4">
                            <div class="col-md-6">

                                @if (isset($sbmsbi) && Storage::disk('public')->exists($sbmsbi->sbm_path))
                                    <a href="{{ Storage::disk('public')->url($sbmsbi->sbm_path) }}" target="_blank"><i
                                            data-feather="eye"></i> Lihat SBM</a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if (isset($sbmsbi) && Storage::disk('public')->exists($sbmsbi->sbi_path))
                                    <a href="{{ Storage::disk('public')->url($sbmsbi->sbi_path) }}" target="_blank"><i
                                            data-feather="eye"></i> Lihat SBI</a>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('sbm_sbi.store') }}" method="POST" enctype="multipart/form-data"
                            class="mt-4">
                            @csrf
                            <input type="hidden" name="sbmsbi_id" value="{{ $sbmsbi?->id }}">
                            <div class="row px-4">
                                <div class="my-1 form-group col-md-6 ">
                                    <label
                                        for="formFileSBM">{{ !empty($sbmsbi) || isset($sbmsbi) ? 'Update' : 'Upload' }}
                                        SBM</label>
                                    <input class="form-control file-upload-input" type="file" name="sbm"
                                        id="formFileSBM" required>
                                </div>
                                <div class="my-1 form-group col-md-6">
                                    <label
                                        for="formFileSBI">{{ !empty($sbmsbi) || isset($sbmsbi) ? 'Update' : 'Upload' }}
                                        SBI</label>
                                    <input class="form-control file-upload-input" type="file" name="sbi"
                                        id="formFileSBI" required>
                                </div>
                                <div class="text-center form-group w-50 mx-auto my-4">
                                    <button type="submit"
                                        class="btn {{ !empty($sbmsbi) || isset($sbmsbi) ? 'btn-warning' : 'btn-success' }} w-100">{{ !empty($sbmsbi) || isset($sbmsbi) ? 'Update' : 'Simpan' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    {{-- <h1 style="margin-top:10vh;" class="text-center fw-bold">{{ $renstra->vision }}</h1> --}}
                </div>
            </div>
        </div>
    </div>
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
