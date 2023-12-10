{{--

/**
*
* Created a new component <x-menu.vertical-menu/>.
*
*/

--}}


<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('user.index') }}">
                        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo logo-dark"
                            alt="logo">
                        <img src="{{ Vite::asset('resources/images/logo2.svg') }}" class="navbar-logo logo-light"
                            alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('user.index') }}" class="nav-link"> E-Planning </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        @if (!Request::is('collapsible-menu/*'))
            <div class="profile-info">
                <div class="user-info">
                    <div class="profile-img">
                        {{-- <img src="{{ Vite::asset('resources/images/profile-30.png') }}" alt="avatar"> --}}
                    </div>
                    <div class="profile-content">
                        <h6 class="">{{ auth()->user()->name }}</h6>
                    </div>
                </div>
            </div>
        @endif
        <ul class="list-unstyled menu-categories" id="accordionExample">
            {{-- <li class="menu {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li> --}}

            <li class="menu {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'active' : '' }}">
                <a href="#perencanaan" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'collapsed' : '' }}">
                    <div class="">
                        <span class="fw-bold">PERENCANAAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'show' : '' }}"
                    id="perencanaan" data-bs-parent="#accordionExample">
                    <li class="submenu">
                        <a href="#renstra" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <div>
                                <i data-feather="folder"></i><span class="icon-name fw-bold">RENSTRA</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse list-unstyled sub-submenu" id="renstra" data-bs-parent="#perencanaan">
                            <li class="{{ Request::routeIs('vision.index') ? 'active' : '' }}">
                                <a class="ssubmenu" href="{{ route('vision.index') }}" aria-expanded="false">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Visi</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('mission.index') ? 'active' : '' }}">
                                <a class="ssubmenu" href="{{ route('mission.index') }}">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Misi</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('iku.index') ? 'active' : '' }}">
                                <a class="ssubmenu" href="{{ route('iku.index') }}">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Indikator Kinerja Utama</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                                <a class="ssubmenu" href="javascript:void(0);">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Capaian Kinerja <br> Tahun Sebelumnya</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#rkt" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <div>
                                <i data-feather="folder"></i><span class="icon-name fw-bold">RKT</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse list-unstyled sub-submenu" id="rkt" data-bs-parent="#perencanaan">
                            <li class="">
                                <a class="ssubmenu" href="#">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Visi</span>
                                    </div>
                                </a>
                            </li>
                            <li class="">
                                <a class="ssubmenu" href="#">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Misi</span>
                                    </div>
                                </a>
                            </li>
                            <li class="">
                                <a class="ssubmenu" href="#">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Indikator Kinerja Utama</span>
                                    </div>
                                </a>
                            </li>
                            <li class="">
                                <a class="ssubmenu" href="javascript:void(0);">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Capaian Kinerja <br> Tahun Sebelumnya</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#perkin" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle collapsed">
                            <div>
                                <i data-feather="folder"></i><span class="icon-name fw-bold">PERKIN</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse list-unstyled sub-submenu" id="perkin" data-bs-parent="#perencanaan">
                            <li class="{{ Request::routeIs('program_target.index') ? 'active' : '' }}">
                                <a class="ssubmenu" href="{{ route('program_target.index') }}">
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Sasaran Program</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ Request::routeIs('performance_indicator.index') ? 'active' : '' }}">
                                <a class="ssubmenu" href="{{ route('performance_indicator.index') }}">                                    
                                    <div>
                                        <i data-feather="file"></i><span class="icon-name fw-bold">Indikator Kinerja</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu {{ Request::is('*/perencanaan/*') ? 'active' : '' }}">
                <a href="#perencanaan" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/perencanaan/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div>
                        <span class="fw-bold">PERENCANAAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/perencanaan/*') ? 'show' : '' }}"
                    id="perencanaan">
                    <!-- Submenu for RENSTRA with Dropdown -->
                    <li class="submenu">
                        <a href="#renstra" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::is('*/renstra/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                            <div>
                                <i data-feather="target"></i><span class="icon-name fw-bold">RENSTRA</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="list-unstyled sub-submenu collapse {{ Request::is('*/renstra/*') ? 'show' : '' }}"
                            id="renstra" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('vision.index') ? 'active' : '' }}">
                                <a href="{{ route('vision.index') }}"> Visi </a>
                            </li>
                            <li class="{{ Request::routeIs('mission.index') ? 'active' : '' }}">
                                <a href="{{ route('mission.index') }}"> Misi </a>
                            </li>
                            <li class="{{ Request::routeIs('iku.index') ? 'active' : '' }}">
                                <a href="{{ route('iku.index') }}"> Indikator Kinerja<br /> Utama </a>
                            </li>
                            <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                                <a href="#"> Capaian Kinerja <br /> Tahun Sebelumnya </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Submenu for RKT with Dropdown -->
                    <li class="submenu">
                        <a href="#rkt" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::is('*/rkt/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                            <div>
                                <i data-feather="calendar"></i><span class="icon-name fw-bold">RKT</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse sub-submenu list-unstyled {{ Request::is('*/rkt/*') ? 'show' : '' }}"
                            id="rkt" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('vision.index') ? 'active' : '' }}">
                                <a href="{{ route('vision.index') }}"> Visi </a>
                            </li>
                            <li class="{{ Request::routeIs('mission.index') ? 'active' : '' }}">
                                <a href="{{ route('mission.index') }}"> Misi </a>
                            </li>
                            <li class="{{ Request::routeIs('iku.index') ? 'active' : '' }}">
                                <a href="{{ route('iku.index') }}"> Indikator Kinerja<br /> Utama </a>
                            </li>
                            <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                                <a href="#"> Capaian Kinerja <br /> Tahun Sebelumnya </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Submenu for PERKIN with Dropdown -->
                    <li class="submenu">
                        <a href="#perkin" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::is('*/perkin/*') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div>
                                <i data-feather="file-text"></i><span class="icon-name fw-bold">PERKIN</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse sub-submenu list-unstyled {{ Request::is('*/perkin/*') ? 'show' : '' }}"
                            id="perkin" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('program_target.index') ? 'active' : '' }}">
                                <a href="{{ route('program_target.index') }}"> Sasaran Program </a>
                            </li>
                            <li class="{{ Request::routeIs('performance_indicator.index') ? 'active' : '' }}">
                                <a href="{{ route('performance_indicator.index') }}"> Indikator Kinerja </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}

            <li class="menu {{ Request::is('*/penganggaran/*') ? 'active' : '' }}">
                <a href="#penganggaran" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/penganggaran/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div>
                        <span class="fw-bold">PENGANGGARAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/penganggaran/*') ? 'show' : '' }}"
                    id="penganggaran" data-bs-parent="#accordionExample">
                    <li class="submenu {{ Request::routeIs('budget_implementation.index') ? 'active' : '' }}">
                        <a href="{{ route('budget_implementation.index') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">USULAN DIPA</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="#" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">REVISI DIPA</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ Request::is('*/pengaturan/*') ? 'active' : '' }}">
                <a href="#pengaturan" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/perencanaan/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div>
                        <span class="fw-bold">PENGATURAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/pengaturan/*') ? 'show' : '' }}"
                    id="pengaturan" data-bs-parent="#accordionExample">
                    <li class="submenu {{ Request::routeIs('work_unit.index') ? 'active' : '' }}">
                        <a href="{{ route('work_unit.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">UNIT KERJA</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu {{ Request::routeIs('ins_budget.index') ? 'active' : '' }}">
                        <a href="{{ route('ins_budget.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">PAGU LEMBAGA</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu {{ Request::routeIs('unit_budget.index') ? 'active' : '' }}">
                        <a href="{{ route('unit_budget.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">PAGU UNIT</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu {{ Request::routeIs('expenditure_unit.index') ? 'active' : '' }}">
                        <a href="{{ route('expenditure_unit.index') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">SATUAN BELANJA</span>
                            </div>
                        </a>
                    </li>

                    <li class="submenu {{ Request::routeIs('account_code.index') ? 'active' : '' }}">
                        <a href="{{ route('account_code.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">KODE AKUN</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu {{ Request::routeIs('sbm_sbi.index') ? 'active' : '' }}">
                        <a href="{{ route('sbm_sbi.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">SBM DAN SBI</span>
                            </div>
                        </a>
                    </li>
                    <li class="submenu {{ Request::routeIs('user.index') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="folder"></i>
                                <span class="icon-name fw-bold">MANAJEMEN USER</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

    </nav>

</div>
