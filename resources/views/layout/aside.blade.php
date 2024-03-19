<style>
  .blink-bg {

    animation: blinkingBackground 2s infinite;
  }

  @keyframes blinkingBackground {
    0% {
      background-color: #cfe8f7;
    }

    25% {
      background-color: #78a3e4;
    }

    50% {
      background-color: #2581eb;
    }

    75% {
      background-color: #295899;
      color: #fff;
    }

    100% {
      background-color: #03485f;
      color: #fff;

    }
  }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">


  <div class="app-brand demo ">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">

        {{-- <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink">
          <defs>
            <path
              d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
              id="path-1"></path>
            <path
              d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
              id="path-3"></path>
            <path
              d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
              id="path-4"></path>
            <path
              d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
              id="path-5"></path>
          </defs>
          <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
              <g id="Icon" transform="translate(27.000000, 15.000000)">
                <g id="Mask" transform="translate(0.000000, 8.000000)">
                  <mask id="mask-2" fill="white">
                    <use xlink:href="#path-1"></use>
                  </mask>
                  <use fill="#696cff" xlink:href="#path-1"></use>
                  <g id="Path-3" mask="url(#mask-2)">
                    <use fill="#696cff" xlink:href="#path-3"></use>
                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                  </g>
                  <g id="Path-4" mask="url(#mask-2)">
                    <use fill="#696cff" xlink:href="#path-4"></use>
                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                  </g>
                </g>
                <g id="Triangle"
                  transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                  <use fill="#696cff" xlink:href="#path-5"></use>
                  <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                </g>
              </g>
            </g>
          </g>
        </svg> --}}

        <img src="{{ asset('img/logo pt.png') }}" alt="" width="40rem">

      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">simaska</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>



  <ul class="menu-inner py-1">

    <!-- Dashboard -->
    <li class="menu-item @if(Request::segment(1)=='dashboard') active @endif">
      <a href="{{ url('') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>




    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">TU & Keuangan</span>
    </li>
    @if(session('employee_level') != 'user')
    <li class="menu-item @if(Request::segment(1)=='mails' && Request::segment(2)=='kpt') active @endif">
      <a href="{{ url('mails/kpt') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-envelope"></i>
        <div data-i18n="Analytics">Surat KPT</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='mails' && Request::segment(2)=='pan') active @endif">
      <a href="{{ url('mails/pan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-envelope"></i>
        <div data-i18n="Analytics">Surat Panitera</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='mails' && Request::segment(2)=='sek') active @endif">
      <a href="{{ url('mails/sek') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-envelope"></i>
        <div data-i18n="Analytics">Surat Sekretaris</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='orders') active @endif">
      <a href="{{ url('orders') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-store-alt"></i>
        <div data-i18n="Analytics">Pesanan barang <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            id="notifikasi-order">
            <span class="visually-hidden">unread messages</span>
          </span></div>
      </a>

    </li>
    @endif
    <li class="menu-item @if(Request::segment(1)=='template_mail') active @endif">
      <a href="{{ url('template_mail') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-envelope"></i>
        <div data-i18n="Analytics">Template surat</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='salary'&&!Request::segment(2)) active @endif">
      <a href="{{ url('salary') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Analytics">Slip Gaji</div>
      </a>
    </li>
    @if(Session::get('renprog')==true||Session::get('kepegawaian')==true||Session::get('tu_rt')==true||Session::get('keuangan')==true)
    <li class="menu-item @if(Request::segment(1)=='salary'&&Request::segment(2)=='slip_umum') active @endif">
      <a href="{{ url('salary/slip_umum') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Analytics">Slip Umum</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='salary'&&Request::segment(2)=='admin_list') active @endif">
      <a href="{{ url('salary/admin_list') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Analytics">Input Gaji</div>
      </a>
    </li>
    @endif
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Kepegawaian</span>
    </li>
    @if(Session::get('kepegawaian')==true||Session::get('tu_rt')==true)
    <li class="menu-item @if(Request::segment(1)=='surat_keputusan') active @endif">
      <a href="{{ url('surat_keputusan') }}" class="menu-link">
        <i class='menu-icon bx bxs-file'></i>
        <div data-i18n="Analytics">Nomor SK </div>
      </a>

    </li>
    @endif
    <li class="menu-header small text-uppercase mt-0">
      <span class="menu-header-text">Cuti</span>
    </li>
    <li class="menu-item @if(Request::segment(1)=='leave'&&!Request::segment(2)) active @endif">
      @if(Session::get('kepegawaian')==true)

      <a href="{{ url('leave') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-glasses-alt"></i>
        <div data-i18n="Analytics">Data Umum </div>
      </a>
      @endif
    </li>
    @if(Session::get('is_atasan_langsung')==true)
    <li class="menu-item @if(Request::segment(1)=='leave'&&Request::segment(2)=='permohonan') active @endif">

      <a href="{{ session('employee_level')=='ketua'?url('leave/permohonan/ketua'):url('leave/permohonan/non_ketua') }}"
        class="menu-link">
        <i class="menu-icon tf-icons bx bx-briefcase-alt"></i>
        <div data-i18n="Analytics">Permohonan Baru <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            id="notifikasi-cuti">
            <span class="visually-hidden">unread messages</span>
          </span></div>
      </a>
    </li>
    @endif
    @if (session('employee_nip')!='-'&&session('employee_nip')!=null&&session('employee_level')!='ketua')
    <li class="menu-item @if(Request::segment(1)=='leave_user') active @endif">
      <a href="{{ url('leave_user/user') }}" class="menu-link">
        <i class='menu-icon bx bx-shape-square'></i>
        <div data-i18n="Analytics">Pengajuan </div>
      </a>

    </li>
    @endif

    @if(Session::get('kepegawaian')==true)
    <li class="menu-item @if(Request::segment(1)=='leave'&&Request::segment(2)=='sisa_cuti') active @endif">
      <a href="{{ url('leave/sisa_cuti') }}" class="menu-link">
        <i class='menu-icon bx bxs-plane-take-off'></i>
        <div data-i18n="Analytics">Sisa cuti </div>
      </a>

    </li>
    @endif
    <li class="menu-header small text-uppercase mt-0">
      <span class="menu-header-text">IZIN</span>
    </li>
    @if (session('employee_level')!='ketua')
    <li class="menu-item @if(Request::segment(1)=='permission'&&Request::segment(2)=='pribadi') active @endif">
      <a href="{{ url('permission/pribadi') }}" class="menu-link">
        <i class='menu-icon bx bx-log-out-circle'></i>
        <div data-i18n="Analytics">Keluar Kantor</div>
      </a>

    </li>
    @endif
    @if(session('kepegawaian')==true)
    <li class="menu-item @if(Request::segment(1)=='permission'&&!Request::segment(2)) active @endif">
      <a href="{{ url('permission') }}" class="menu-link">
        <i class='menu-icon bx bx-log-out-circle'></i>
        <div data-i18n="Analytics">Keluar Kantor Umum</div>
      </a>

    </li>
    @endif
    @if(session('is_atasan_langsung'))
    <li class="menu-item @if(Request::segment(1)=='permission'&&Request::segment(2)=='permohonan') active @endif">
      <a href="{{ url('permission/permohonan') }}" class="menu-link">
        <i class='menu-icon bx bx-log-out-circle'></i>
        <div data-i18n="Analytics">Permohonan <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            id="notifikasi-keluar-kantor"><span></div>
      </a>

    </li>
    @endif
    
    <li class="menu-header small text-uppercase mt-0">
      <span class="menu-header-text">PRESENSI</span>
    </li>

    <li class=" menu-item @if(Request::segment(1)=='presensi' &&! Request::segment(2)) active @endif ">
      <a href="{{ url('presensi') }}" class="menu-link presensi blink-bg ">
        <i class='menu-icon bx bx-fingerprint'></i>
        <div data-i18n="Analytics">Presensi Siang</div>
      </a>

    </li>
    @if(session('kepegawaian')==true)
    <li class="menu-item @if(Request::segment(1)=='presensi' && Request::segment(2)=='laporan_umum' ) active @endif">
      <a href="{{ url('presensi/laporan_umum') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Laporan Umum</div>
      </a>

    </li>
    @endif
    <li class="menu-item @if(Request::segment(1)=='presensi' && Request::segment(2)=='laporan_pribadi') active @endif">
      <a href="{{ url('presensi/laporan_pribadi') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Laporan Pribadi</div>
      </a>

    </li>
    @if(Session::get('ppnpn')==false)
    <li class="menu-header small text-uppercase mt-0">
      <span class="menu-header-text">Review</span>
    </li>
    @endif
    @if(Session::get('kepegawaian')==true)
    
    <li class="menu-item @if(Request::segment(1)=='review' && Request::segment(2)=='ptsp') active @endif">
      <a href="{{ url('review/ptsp') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Review PTSP</div>
      </a>

    </li>
    <li class="menu-item @if(Request::segment(1)=='review' && Request::segment(2)=='petugas_ptsp') active @endif">
      <a href="{{ url('review/petugas_ptsp') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Petugas PTSP</div>
      </a>

    </li>
    <li class="menu-item @if(Request::segment(1)=='review' && Request::segment(2)=='satpam') active @endif">
      <a href="{{ url('review/satpam') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Review Satpam</div>
      </a>

    </li>
    <li class="menu-item @if(Request::segment(1)=='review' && Request::segment(2)=='petugas_satpam') active @endif">
      <a href="{{ url('review/petugas_satpam') }}" class="menu-link">
        <i class='menu-icon bx bx-file'></i>
        <div data-i18n="Analytics">Satpam</div>
      </a>

    </li>
    
    @endif
    @if(session('ppnpn')==false)
    <li class="menu-item @if(Request::segment(1)=='ppnpn'&&Request::segment(2)=='daftar_assessment') active @endif">
      <a href="{{ url('ppnpn/daftar_assessment') }}" class="menu-link">
        <i class='menu-icon bx bx-log-out-circle'></i>
        <div data-i18n="Analytics">Daftar Review PPNPN </div>
      </a>

    </li>
    @endif


    @if(Session::get('renprog')==true||Session::get('kepegawaian')==true||Session::get('tu_rt')==true||Session::get('keuangan')==true)
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pengaturan</span>
    </li>
    <li class="menu-item @if(Request::segment(1)=='employees') active @endif">
      <a href="{{ url('employees') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">Pegawai</div>
      </a>
    </li>

    <li class="menu-item @if(Request::segment(1)=='positions') active @endif">
      <a href="{{ url('positions') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user-badge"></i>
        <div data-i18n="Analytics">Jabatan</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='units') active @endif">
      <a href="{{ url('units') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building"></i>
        <div data-i18n="Analytics">Bagian</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='akuns') active @endif">
      <a href="{{ url('akuns') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user-account"></i>
        <div data-i18n="Analytics">Akun</div>
      </a>
    </li>
    @endif
    @if(Session::get('tu_rt')==true||Session::get('keuangan')==true)
    <li class="menu-item @if(Request::segment(1)=='goods'&&!Request::segment(2)) active @endif">
      <a href="{{ url('goods') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user-account"></i>
        <div data-i18n="Analytics">Ref Barang</div>
      </a>
    </li>
    <li class="menu-item @if(Request::segment(1)=='goods'&&Request::segment(2)=='ref_jenis_barang') active @endif">
      <a href="{{ url('goods/ref_jenis_barang') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-user-account"></i>
        <div data-i18n="Analytics">Ref Jenis Barang</div>
      </a>
    </li>
    @endif
    <li class="menu-item ">
      <a href="" class="menu-link">

      </a>
    </li>
    <li class="menu-item ">
      <a href="" class="menu-link">

      </a>
    </li>
    <li class="menu-item ">
      <a href="" class="menu-link">

      </a>
    </li>

    {{-- <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pengaturan</span>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">Account Settings</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="pages-account-settings-account.html" class="menu-link">
            <div data-i18n="Account">Account</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="pages-account-settings-notifications.html" class="menu-link">
            <div data-i18n="Notifications">Notifications</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="pages-account-settings-connections.html" class="menu-link">
            <div data-i18n="Connections">Connections</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Authentications">Authentications</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="auth-login-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Login</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="auth-register-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Register</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Forgot Password</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
        <div data-i18n="Misc">Misc</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="pages-misc-error.html" class="menu-link">
            <div data-i18n="Error">Error</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="pages-misc-under-maintenance.html" class="menu-link">
            <div data-i18n="Under Maintenance">Under Maintenance</div>
          </a>
        </li>
      </ul>
    </li> --}}

  </ul>

</aside>