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
                        <h6 class="">Shaun Park</h6>
                        <p class="">Project Leader</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Route::is('admin.dashboard') ? 'active' : '' }}">
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
            </li>


            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span class="fw-bold">PERENCANAAN</span></div>
            </li>

            <li class="menu {{ Request::is('*/renstra/*') ? 'active' : '' }}">
                <a href="#renstra" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/renstra/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="target"></i><span class="icon-name fw-bold"> RENSTRA</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/renstra/*') ? 'show' : '' }}" id="renstra"
                    data-bs-parent="#accordionExample">
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
            <li class="menu {{ Request::is('*/rkt/*') ? 'active' : '' }}">
                <a href="#rkt" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/rkt/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="trending-up"></i><span class="icon-name fw-bold">RKT</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/rkt/*') ? 'show' : '' }}" id="rkt"
                    data-bs-parent="#accordionExample">
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
            <li class="menu {{ Request::is('*/perkin/*') ? 'active' : '' }}">
                <a href="#perkin" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/perkin/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="file-text"></i><span class="icon-name fw-bold"> PERKIN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('*/perkin/*') ? 'show' : '' }}"
                    id="perkin" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('program_target.index') ? 'active' : '' }}">
                        <a href="{{ route('program_target.index') }}"> Sasaran Program </a>
                    </li>
                    <li class="{{ Request::routeIs('performance_indicator.index') ? 'active' : '' }}">
                        <a href="{{ route('performance_indicator.index') }}"> Indikator Kinerja </a>
                    </li>
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span class="fw-bold">PENGANGGARAN</span></div>
            </li>
            <li class="menu">
                <a href="#" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="check-square"></i>
                        <span class="icon-name fw-bold">USULAN DIPA</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="#" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="edit"></i>
                        <span class="icon-name fw-bold">REVISI DIPA</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span class="fw-bold">PENGATURAN</span></div>
            </li>
            <li class="menu {{ Request::routeIs('work_unit.index') ? 'active' : '' }}">
                <a href="{{ route('work_unit.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="briefcase"></i>
                        <span class="icon-name fw-bold">UNIT KERJA</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('ins_budget.index') ? 'active' : '' }}">
                <a href="{{ route('ins_budget.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layout"></i>
                        <span class="icon-name fw-bold">INPUT PAGU LEMBAGA</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('unit_budget.index') ? 'active' : '' }}">
                <a href="{{ route('unit_budget.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="trello"></i>
                        <span class="icon-name fw-bold">PEMBAGIAN PAGU UNIT</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('expenditure_unit.index') ? 'active' : '' }}">
                <a href="{{ route('expenditure_unit.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="dollar-sign"></i>
                        <span class="icon-name fw-bold">SATUAN BELANJA</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::routeIs('account_code.index') ? 'active' : '' }}">
                <a href="{{ route('account_code.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="hash"></i>
                        <span class="icon-name fw-bold">KODE AKUN</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('sbm_sbi.index') ? 'active' : '' }}">
                <a href="{{ route('sbm_sbi.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="file"></i>
                        <span class="icon-name fw-bold">SBM&SBI</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('user.index') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="users"></i>
                        <span class="icon-name fw-bold">KELOLA USER</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
