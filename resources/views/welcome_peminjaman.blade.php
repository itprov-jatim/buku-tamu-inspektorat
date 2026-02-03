<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Mobil Inspektorat Provinsi Jawa Timur</title>
    <link rel="icon" href="{{ asset('img/logo-inspektorat2.png') }}" type="image/x-icon">
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css-fonts/poppins.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js'])

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(to right, #003366, #66a3ff);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .container {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        margin: auto;
        flex-wrap: wrap;
        overflow: hidden;
    }

    .content {
        max-width: 550px;
        flex: 1 1 300px;
        padding-right: 50px;
    }

    h1 {
        margin: 0;
        font-size: 42px;
        font-weight: 700;
        color: #002244;
        line-height: 1.2;
    }

    p {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 14px 28px;
        background: #002244;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-size: 18px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        background: #001122;
    }

    .stats {
        display: flex;
        gap: 10px;
        margin-top: 25px;
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
    }

    .stat-box {
        background: #f0f5ff;
        padding: 10px;
        border-radius: 12px;
        text-align: center;
        font-weight: bold;
        color: #002244;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-box h2 {
        font-size: 20px;
        margin: 2px 0;
    }

    .stat-box p {
        font-size: 16px;
        margin: 2px 0;
    }

    .logo {
        max-width: 250px;
        flex: 1 1 150px;
        margin-top: 20px;
        object-fit: contain;
    }

    footer {
        background-color: #002244;
        color: white;
        padding: 15px 0;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        box-sizing: border-box;
        margin: 0;
    }

    .footer-content {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
        padding: 0 20px;
        box-sizing: border-box;
    }

    .footer-content .icon-text {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-size: 16px;
        text-decoration: none;
        justify-content: center;
        box-sizing: border-box;
    }

    .footer-content .icon-text i {
        font-size: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    .footer-content .icon-text:hover i {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .footer-content .icon-text span {
        font-weight: 500;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column-reverse;
            align-items: center;
            border-radius: 0;
        }

        .content {
            padding: 0;
        }

        .content h1,
        .content p {
            text-align: center;
        }

        .btn {
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
            width: 70%;
        }

        .footer-content {
            flex-direction: column;
            gap: 15px;
            padding: 10px;
            text-align: center;
        }

        .footer-content .icon-text {
            justify-content: center;
            font-size: 14px;
            flex-direction: row;
        }

        .footer-content .icon-text span {
            font-size: 14px;
        }

        .stats {
            justify-content: center;
            align-items: center;
        }

        .stat-box {
            font-size: 13px;
            padding: 12px;
            flex: 1 1 120px;
        }

        .stat-box h2 {
            font-size: 18px;
        }

        .stat-box p {
            font-size: 14px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1>Peminjaman Mobil Inspektorat</h1>
            <p>Jl. Raya Bandara Juanda No.8, Dusun Pager, Sawotratap, Kec. Gedangan, Kabupaten Sidoarjo, Jawa Timur</p>
            @if(Auth::check())
            <a href="{{ route('bukutamu.create') }}" class="btn btn-primary">Masuk</a>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
            @endif

            <!-- Statistik data kunjungan tamu per hari, per bulan, dan per tahun -->
            <div class="stats">
                <div class="stat-box">
                    <h2>{{ now()->day }}</h2>
                    <p> () Mobil Tersedia  </p>
                </div>
                <div class="stat-box">
                    <h2>{{ now()->translatedFormat('F') }}</h2>
                    <p> () Driver Tersedia </p>
                </div>
                {{-- <div class="stat-box">
                    <h2>{{ now()->year }}</h2>
                    <p> () Pengunjung</p>
                </div> --}}
            </div>
        </div>
        <img src="{{ asset('img/logo-inspektorat2.png') }}" alt="Logo Inspektorat" class="logo">
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <a href="tel:+62318540616" class="icon-text" title="Hubungi Kami">
                <i class="fas fa-phone"></i>
                <span>+62 31 854 0616</span>
            </a>
            <a href="https://inspektorat.jatimprov.go.id" target="_blank" class="icon-text"
                title="Website Inspektorat Jatim">
                <i class="fas fa-globe"></i>
                <span>inspektorat.jatimprov.go.id</span>
            </a>
            <a href="https://www.instagram.com/inspektoratprovinsijawatimur" target="_blank" class="icon-text"
                title="Instagram Inspektorat Jatim">
                <i class="fab fa-instagram"></i>
                <span>@inspektoratprovinsijawatimur</span>
            </a>
        </div>
    </footer>
</body>

</html>