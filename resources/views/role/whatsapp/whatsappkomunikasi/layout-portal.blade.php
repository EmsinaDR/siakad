<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal WhatsApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        #main-content {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
    </style>
</head>

<body>

    <!-- Navbar di Atas -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-0 rounded shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WA Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('jemputan') || request()->is('izin') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown">Layanan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('whatsapp.jemputan.siswa') }}">Minta
                                    Jemputan</a></li>
                            <li><a class="dropdown-item" href="{{ url('/izin') }}">Izin Tidak Masuk</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="navbar-text">Selamat datang, Orang Tua</span>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <header class="mb-4">
        <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="container mb-5">
        <div id="main-content">
            {{-- Konten dinamis diatur pakai routing normal Laravel --}}
            @yield('content')
        </div>
    </main>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
