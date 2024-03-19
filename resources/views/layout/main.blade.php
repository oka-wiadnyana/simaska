<!DOCTYPE html>



<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html lang="en" class="light-style layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <title>Simaska</title>
    
    <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('template-assets/vendor/fonts/boxicons.css') }}" />
    
    

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template-assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template-assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template-assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('template-assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
   integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
   crossorigin=""></script> --}}

   <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
   <script src="{{ asset('leaflet/leaflet.js') }}"></script>

   <!-- Load Esri Leaflet from CDN -->
   <script src="https://unpkg.com/esri-leaflet@3.0.10/dist/esri-leaflet.js"></script>

   <!-- Load Esri Leaflet Vector from CDN -->
   <script src="https://unpkg.com/esri-leaflet-vector@4.1.0/dist/esri-leaflet-vector.js" crossorigin=""></script>

    <!-- Page CSS -->
    
    <!-- Helpers -->
    <script src="{{ asset('template-assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('template-assets/js/config.js') }}"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="async" src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID');
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css">
    <!-- Custom notification for demo -->
    <!-- beautify ignore:end -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@stack('style')


</head>

<body>

  <!-- Layout wrapper -->

  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
      <!-- Menu -->
      @include('layout.aside')

      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        @include('layout.navbar')

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y ">
            @yield('content')
          </div>
          <!-- / Content -->

          <!-- Footer -->
          @include('layout.footer')
          <!-- / Footer -->


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>



    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="modal-presensi">

    </div>


  </div>
  @stack('thescript')
  <!-- / Layout wrapper -->
  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  {{-- <script src="{{ asset('template-assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
  <script src="{{ asset('template-assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('template-assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('template-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

  <script src="{{ asset('template-assets/vendor/js/menu.js') }}"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('template-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('template-assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('template-assets/js/dashboards-analytics.js') }}"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>



  <script>
    $(document).ready(function () {
      @if($errors->any())
      @php
      $msg="";
      foreach($errors->all() as $error) {
        $msg .=$error.", ";
      }
      @endphp
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '{{ $msg }}',
 
})
      @endif
    });

    @if ($message = Session::get('success'))
    Swal.fire({
  icon: 'success',
  title: 'Berhasil',
  text: '{{ $message }}',
})
    @endif

    @if ($message = Session::get('fail'))
    Swal.fire({
  icon: 'error',
  title: 'Gagal',
  text: '{{ $message }}',
})
    @endif

    $(window).on('load', function () { 
      $('.spinner-border').hide(500);
     })


     $.ajax({
      type: "get",
      url: "{{ url('notifikasiorder') }}",
      // data: "data",
      dataType: "json",
      success: function (response) {
        console.log(response);
        if(response.jml) {
          $('#notifikasi-order').text(response.jml);
        }else {
          $('#notifikasi-order').hide();
        }
      }
     });

     $.ajax({
      type: "get",
      url: "{{ url('leave/notifikasicuti') }}",
      // data: "data",
      dataType: "json",
      success: function (response) {
        console.log(response);
        if(response.jml) {
          $('#notifikasi-cuti').text(response.jml);
        }else {
          $('#notifikasi-cuti').hide();
        }
      }
     });

     $.ajax({
      type: "get",
      url: "{{ url('permission/notifikasi') }}",
      // data: "data",
      dataType: "json",
      success: function (response) {
        console.log(response);
        if(response.jml) {
          $('#notifikasi-keluar-kantor').text(response.jml);
        }else {
          $('#notifikasi-keluar-kantor').hide();
        }
      }
     });

  
  </script>
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      $('.presensi').click(function(e){
        e.preventDefault();
        let mobile=/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone/i;
        if(!mobile.test(navigator.userAgent)){
          alert('Lakukan presensi dengan smartphone!');
          return false;
        } 
        $('.layout-overlay.layout-menu-toggle').trigger('click');
       
        $.ajax({
          type: "post",
          url: "{{ url('presensi/modal_presensi') }}",
          data: "data",
          dataType: "json",
          success: function (response) {
            $('.modal-presensi').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('.modal-presensi .modal_presensi'));
                modal.show();
           
          }
        });
      })

     

      // Comment out the below code to see the difference.
      $('.modal_presensi').on('shown.bs.modal', function() {
        map.invalidateSize();
      });
      // var map = L.map('map').setView([51.505, -0.09], 13);
      // map.invalidateSize();
    });
  </script>
</body>

</html>