<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Select2 -->
    
    <!-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- page style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/user/feedback_form.css') }}">
    <!-- sweetalert2 -->
    <link  rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}"></link>
    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper d-flex flex-column justify-content-center">
            <!-- Content Header (Page header) -->
            <section class="content-header p-3">
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12 text-center">
                    <h1>Disconnection of the PEOTV Connection</h1>
                    </div>
                </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content p-3">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{ now()->year }} {{ _('Powered By SLT') }} .</strong> All rights reserved.
        </footer>
        <!-- /.footer -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{ asset('assets/dist/js/demo.js') }}"></script> -->
    @stack('js')
</body>
</html>
