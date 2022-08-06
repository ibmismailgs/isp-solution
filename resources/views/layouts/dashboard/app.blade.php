<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') </title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('backend/dist/css/custom.css') }}">

        {{--Include CSS--}}
        @stack('css')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            {{-- Navigation Top Bar --}}
            @include('layouts.dashboard.partials.navigation')

            <!-- Main Sidebar Container -->
            @include('layouts.dashboard.partials.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container">
                        {{ $header }}
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- jQuery -->
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
        {{--Include JS--}}
        <script>
            $.ajaxSetup({
                headers:{
                "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content"),
                }
            });
        </script>
        @stack('js')
    </body>
</html>
