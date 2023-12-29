<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Login') }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/authentication/auth-cover.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-cover.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>

                    <div class="auth-cover">

                        <div class="position-relative">

                            <img src="{{ Vite::asset('resources/images/1.svg') }}" alt="auth-img">

                            <h2 class="mt-5 text-white font-weight-bolder px-2">Sistem Perencanaan Digitalisasi Moderen
                            </h2>
                            <p class="text-white px-2">Sistem yang memiliki fitur kalkulasi otomatisasi, efektif, dan
                                terintegrasi</p>
                        </div>

                    </div>

                </div>
                <div
                    class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h2>Masuk ke Sistem</h2>
                                        <p>Silahkan masukkan email dan password anda untuk masuk ke sistem</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Email</label>
                                        <input name="email" type="email" class="form-control"
                                            id="validationCustom01" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <label class="form-label">Password</label>
                                        <div class="input-group has-validation">
                                            <input name="password" type="password" class="form-control"
                                                id="password-field" required>
                                            <span class="input-group-text">
                                                <i data-feather="eye" class="feather icon-eye" id="togglePassword"
                                                    style="cursor: pointer;"></i>
                                            </span>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 my-2">
                                        <div class="mb-3">
                                            <div class="form-check form-check-primary form-check-inline">
                                                <input class="form-check-input me-3" type="checkbox"
                                                    id="form-check-default" name="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="form-check-default">
                                                    Ingat Saya
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
                document.getElementById('togglePassword').addEventListener('click', function(e) {
                    // toggle the type attribute
                    const password = document.getElementById('password-field');
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    // toggle the eye / eye off icon
                    this.classList.toggle('feather-icon-eye-off');
                });
            });
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        </script>
        @vite(['resources/assets/js/forms/bootstrap_validation/bs_validation_script.js'])
    </x-slot>

    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
