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
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo logo-dark"
                            alt="logo">
                        <img src="{{ Vite::asset('resources/images/logo2.svg') }}" class="navbar-logo logo-light"
                            alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"> E-Planning </a>
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
                        <img src="{{ Vite::asset('resources/images/profile-30.png') }}" alt="avatar">
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
                    </svg><span>PERENCANAAN</span></div>
            </li>

            <li class="menu {{ Request::is('*/renstra/*') ? 'active' : '' }}">
                <a href="#renstra" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('*/renstra/*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="award"></i><span class="icon-name"> RENSTRA</span>
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
                    <li class="{{ Request::routeIs('renstra.visi') ? 'active' : '' }}">
                        <a href="{{ route('renstra.visi') }}"> Visi </a>
                    </li>
                    <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                        <a href="{{ getRouterValue() }}/user/settings"> Misi </a>
                    </li>
                    <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                        <a href="{{ getRouterValue() }}/user/settings"> Indikator Kinerja<br /> Utama </a>
                    </li>
                    <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                        <a href="{{ getRouterValue() }}/user/settings"> Capaian Kinerja <br /> Tahun Sebelumnya </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#authentication" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Authentication</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="authentication" data-bs-parent="#accordionExample">
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/boxed/signin"> Sign In </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/boxed/signup"> Sign Up </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/boxed/lockscreen"> Unlock </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/boxed/password-reset"> Reset </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/boxed/2-step-verification"> 2 Step </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/cover/signin"> Sign In Cover </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/cover/signup"> Sign Up Cover </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/cover/lockscreen"> Unlock Cover </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/cover/password-reset"> Reset Cover </a>
                    </li>
                    <li>
                        <a href="{{ getRouterValue() }}/authentication/cover/2-step-verification"> 2 Step Cover </a>
                    </li>
                </ul>
            </li>

        </ul>

    </nav>

</div>
