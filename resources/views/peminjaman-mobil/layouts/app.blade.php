<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Mobil Inspektorat Provinsi Jawa Timur</title>
    <link rel="icon" href="{{ asset('img/logo-inspektorat2.png') }}" type="image/x-icon">
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css-fonts/poppins.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js','resources/css/peminjaman.css'])


</head>

<body>

      @yield('content')
      
  @include('peminjaman-mobil.layouts.footer')
</body>

</html>