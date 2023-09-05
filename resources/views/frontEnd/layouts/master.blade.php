<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php
        $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
    ?>
  <link title="Favicon" rel="icon" href="@isset($generalSettings) {{ asset('img/' . $generalSettings->favicon) }} @endisset" />
  <title> @yield('title','Wardan') </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontEnd/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('frontEnd/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('frontEnd/assets/css/style.css') }}" rel="stylesheet">

  @stack('css')
</head>

<body>

  <!-- ======= Header ======= -->
    @include('frontEnd.include.header')
  <!-- End Header -->
  <?php
        $bannerSetting = App\Models\FrontEnd\BannerSetting::first();
    ?>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center" style="background: {{ isset($bannerSetting) ? $bannerSetting->color : ''}}">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1 style="color: {{ isset($bannerSetting) ?  $bannerSetting->title_color : ''}}">{{ isset($bannerSetting) ?  $bannerSetting->title : ''}}</h1>
          <h2 style="color: {{ isset($bannerSetting) ?  $bannerSetting->text_color : ''}}">{{ isset($bannerSetting) ?  $bannerSetting->sub_title : '' }}</h2>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="@isset($bannerSetting) {{ asset('img/' . $bannerSetting->banner_image) }} @endisset" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->


  <!-- ======= Main ======= -->
    @yield('main-content')
  <!-- End #main -->

  <!-- ======= Footer ======= -->
   @include('frontEnd.include.footer')
  <!-- End Footer -->

  {{-- <div id="preloader"></div> --}}
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('frontEnd/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('frontEnd/assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('frontEnd/assets/js/main.js') }}"></script>
  @stack('js')

</body>

</html>
