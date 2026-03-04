<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="icon" href="{{ asset('img/logo-inspektorat2.png') }}" type="image/x-icon">
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css-fonts/nunito.css') }}" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">
        @include('peminjaman-mobil.layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('peminjaman-mobil.layouts.navbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('peminjaman-mobil.layouts.admin-footer')
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>

    <!-- Load jQuery UI -->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery-ui/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('sbadmin/vendor/jquery/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sbadmin/vendor/jquery/jquery-ui/themes/base/theme.css') }}">

    <!-- Load DataTables -->
    <link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
</body>

@stack('scripts')

</html>