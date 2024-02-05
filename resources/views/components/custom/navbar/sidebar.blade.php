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
                  <img src="{{ Vite::asset('resources/images/1.svg') }}" class="navbar-logo logo-dark" alt="logo">
                  <img src="{{ Vite::asset('resources/images/1.svg') }}" class="navbar-logo logo-light" alt="logo">
               </a>
            </div>
            <div class="nav-item theme-text">
               <a href="{{ route('user.index') }}" class="nav-link"> E-Planning </a>
            </div>
         </div>
         <div class="nav-item sidebar-toggle">
            <div class="btn-toggle sidebarCollapse">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
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
               <img src="{{ Vite::asset('resources/images/1.svg') }}" alt="avatar">
            </div>
            <div class="profile-content">
               <h6 class="">{{ auth()->user()->name }}</h6>
            </div>
         </div>
      </div>
      @endif
      <ul class="list-unstyled menu-categories" id="accordionExample">
         <li class="menu {{ Request::routeIs('reception.index') ? 'active' : '' }}">
            <a href="{{ route('reception.index') }}" aria-expanded="{{ Request::is('*/penerimaan/*') && !Request::is('*/pengaturan/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/penerimaan/*') && !Request::is('*/pengaturan/*') ? 'collapsed' : '' }}">
               <div>
                  <span class="fw-bold">PENERIMAAN</span>
               </div>
            </a>
         </li>

         <li class="menu {{ Request::routeIs('asset.index') ? 'active' : '' }}">
            <a href="{{ route('asset.index') }}" aria-expanded="{{ Request::is('*/aset/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/aset/*') ? 'collapsed' : '' }}">
               <div>
                  <span class="fw-bold">ASET</span>
               </div>
            </a>
         </li>

         <li class="menu {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'active' : '' }}">
            <a href="#perencanaan" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'collapsed' : '' }}">
               <div class="">
                  <span class="fw-bold">PERENCANAAN</span>
               </div>
               <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                     <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
               </div>
            </a>
            <ul class="collapse submenu list-unstyled {{ Request::is('*/renstra/*') || Request::is('*/perkin/*') ? 'show' : '' }}" id="perencanaan" data-bs-parent="#accordionExample">
               <li class="submenu">
                  <a href="#renstra" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/renstra/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/renstra/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">RENSTRA</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/renstra/*') ? 'show' : '' }}" id="renstra" data-bs-parent="#perencanaan">
                     <li class="{{ Request::routeIs('vision.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('vision.index') }}" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">VISI</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('mission.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('mission.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">MISI</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('iku.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('iku.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Indikator Kinerja
                                 <br>Utama</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                        <a class="ssubmenu" href="javascript:void(0);">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Capaian Kinerja
                                 <br> Tahun Sebelumnya</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="submenu">
                  <a href="#rkt" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">RKT</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu" id="rkt" data-bs-parent="#perencanaan">
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">VISI</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">MISI</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Indikator Kinerja
                                 <br>Utama</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="javascript:void(0);">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Capaian Kinerja
                                 <br> Tahun Sebelumnya</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="submenu">
                  <a href="#perkin" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/perkin/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/perkin/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">PERKIN</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/perkin/*') ? 'show' : '' }}" id="perkin" data-bs-parent="#perencanaan">
                     <li class="{{ Request::routeIs('program_target.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('program_target.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Sasaran
                                 Program</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('performance_indicator.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('performance_indicator.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Indikator
                                 Kinerja</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
            </ul>
         </li>

         <li class="menu {{ Request::is('*/penganggaran/*') ? 'active' : '' }}">
            <a href="#penganggaran" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/penganggaran/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/penganggaran/*') ? 'collapsed' : '' }}">
               <div>
                  <span class="fw-bold">PENGANGGARAN</span>
               </div>
               <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                     <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
               </div>
            </a>
            <ul class="collapse submenu list-unstyled {{ Request::is('*/penganggaran/*') ? 'show' : '' }}" id="penganggaran" data-bs-parent="#accordionExample">
               <li class="submenu {{ Request::routeIs('budget_implementation.index') ? 'active' : '' }}">
                  <a href="{{ route('budget_implementation.index') }}" aria-expanded="false" class="dropdown-toggle">
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
               <li class="submenu {{ Request::routeIs('withdrawal_plan.index') ? 'active' : '' }}">
                  <a href="{{ route('withdrawal_plan.index') }}" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">RENCANA <br>PENARIKAN DANA</span>
                     </div>
                  </a>
               </li>
               <li class="submenu {{ Request::routeIs('activity_recap.index') ? 'active' : '' }}">
                  <a href="{{ route('activity_recap.index') }}" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">REKAP KEGIATAN <br>DAN UPLOAD DATA<br>DUKUNG</span>
                     </div>
                  </a>
               </li>
            </ul>
         </li>

         <li class="menu {{ Request::is('*/pembayaran/*') || Request::is('*/ruh-pembayaran/*') ? 'active' : '' }}">
            <a href="#pembayaran" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/pembayaran/*') || Request::is('*/ruh-pembayaran/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/pembayaran/*') || Request::is('*/ruh-pembayaran/*') ? 'collapsed' : '' }}">
               <div>
                  <span class="fw-bold">PEMBAYARAN</span>
               </div>
               <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                     <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
               </div>
            </a>
            <ul class="collapse submenu list-unstyled {{ Request::is('*/pembayaran/*') || Request::is('*/ruh-pembayaran/*') ? 'show' : '' }}" id="pembayaran" data-bs-parent="#accordionExample">
               <li class="submenu">
                  <a href="#ruh-pembayaran" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/ruh-pembayaran/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/ruh-pembayaran/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">RUH <br>PEMBAYARAN</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/ruh-pembayaran/*') ? 'show' : '' }}" id="ruh-pembayaran" data-bs-parent="#pembayaran">
                     <li class="{{ Request::routeIs('payment-receipt.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('payment-receipt.index') }}" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Rekam
                                 Kuitansi</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('payment-verification.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('payment-verification.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Rekam
                                 Verifikasi</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="submenu">
                  <a href="#cetakPembayaran" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/cetakPembayaran/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/cetakPembayaran/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">CETAK</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/cetakPembayaran/*') ? 'show' : '' }}" id="cetakPembayaran" data-bs-parent="#pembayaran">
                     <li class="">
                        <a class="ssubmenu" href="#" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Cetak
                                 Kuitansi</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Cetak
                                 Verifikasi</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="submenu">
                  <a href="#" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">CATAT/UPLOAD</span>
                     </div>
                  </a>
               </li>
            </ul>
         </li>

         <li class="menu {{ Request::is('*/pelaporan/*') || Request::is('*/cetak-laporan/*') ? 'active' : '' }}">
            <a href="#pelaporan" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/pelaporan/*') || Request::is('*/cetak-laporan/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/pelaporan/*') || Request::is('*/cetak-laporan/*') ? 'collapsed' : '' }}">
               <div>
                  <span class="fw-bold">PELAPORAN</span>
               </div>
               <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                     <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
               </div>
            </a>
            <ul class="collapse submenu list-unstyled {{ Request::is('*/pelaporan/*') || Request::is('*/cetak-laporan/*') ? 'show' : '' }}" id="pelaporan" data-bs-parent="#accordionExample">
               <li class="submenu">
                  <a href="#cetak-laporan" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/cetak-laporan/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/cetak-laporan/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">CETAK LAPORAN</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/cetak-laporan/*') ? 'show' : '' }}" id="cetak-laporan" data-bs-parent="#pelaporan">
                     <li class="{{ Request::routeIs('detailed-FA-report.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('detailed-FA-report.index') }}" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Laporan FA
                                 Detail</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
            </ul>
         </li>

         <li class="menu {{ Request::is('*/pengaturan/*') || Request::is('*/codeAccount/*') ? 'active' : '' }}">
            <a href="#pengaturan" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/pengaturan/*') || Request::is('*/codeAccount/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/pengaturan/*') || Request::is('*/codeAccount/*') ? 'collapsed' : '' }}">
               <div class="">
                  <span class="fw-bold">ADMINISTRASI</span>
               </div>
               <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                     <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
               </div>
            </a>
            <ul class="collapse submenu list-unstyled {{ Request::is('*/pengaturan/*') || Request::is('*/codeAccount/*') ? 'show' : '' }}" id="pengaturan" data-bs-parent="#accordionExample">
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
                  <a href="{{ route('expenditure_unit.index') }}" aria-expanded="false" class="dropdown-toggle">
                     <div class="">
                        <i data-feather="folder"></i>
                        <span class="icon-name fw-bold">SATUAN BELANJA</span>
                     </div>
                  </a>
               </li>
               <li class="submenu {{ Request::routeIs('kode-akun.index') ? 'active' : '' }}">
                  <a href="#codeAccount" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/codeAccount/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/codeAccount/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">KODE AKUN</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/codeAccount/*') ? 'show' : '' }}" id="codeAccount" data-bs-parent="#pengaturan">
                     <li class="{{ Request::routeIs('account_code.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('account_code.index') }}" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Penganggaran &
                                 <br />
                                 Pembayaran</span>
                           </div>
                        </a>
                     </li>
                     <li class="{{ Request::routeIs('account_code_reception.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('account_code_reception.index') }}" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Penerimaan</span>
                           </div>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="submenu">
                  <a href="#passet" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/passet/*', '*/barang-aset') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/passet/*', '*/barang-aset') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">ASET</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/barang-aset') ? 'show' : '' }}" id="passet" data-bs-parent="#pengaturan">
                     <li class="{{ Request::routeIs('asset_item.index') ? 'active' : '' }}">
                        <a class="ssubmenu" href="{{ route('asset_item.index') }}">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Barang</span>
                           </div>
                        </a>
                     </li>

                  </ul>
               </li>
               <li class="submenu">
                  <a href="#sttpembayaran" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/sttpembayaran/*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('*/sttpembayaran/*') ? 'collapsed' : '' }}">
                     <div>
                        <i data-feather="folder"></i><span class="icon-name fw-bold">PEMBAYARAN</span>
                     </div>
                     <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                           <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                     </div>
                  </a>
                  <ul class="collapse list-unstyled sub-submenu {{ Request::is('*/sttpembayaran/*') ? 'show' : '' }}" id="sttpembayaran" data-bs-parent="#pengaturan">
                     <li class="">
                        <a class="ssubmenu" href="#" aria-expanded="false">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Bendahara</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">PPK</span>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a class="ssubmenu" href="#">
                           <div>
                              <i data-feather="file"></i><span class="icon-name fw-bold">Verifikator</span>
                           </div>
                        </a>
                     </li>
                  </ul>
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