<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Capo Land - @yield('title', 'Jual Beli Tanah')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lora:wght@400;500&display=swap');
        :root {
            --theme-bg: #c49a6c;
            --theme-container: #d9b999;
            --theme-dark-brown: #3b2a1a;
            --theme-white: #ffffff;
            --theme-muted-text: #5a442a;
            --theme-primary: #3b2a1a;
            --theme-secondary: #d9b999;
            --theme-light: #f8f5f0;
            --theme-accent: #a67c00;
        }

        body {
            background-color: var(--theme-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--theme-dark-brown);
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .elcapo-navbar {
            background: linear-gradient(90deg, var(--theme-dark-brown), var(--theme-muted-text));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .elcapo-navbar.scrolled {
            background: var(--theme-dark-brown);
            padding: 5px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--theme-white) !important;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover .logo-circle {
            transform: rotate(15deg) scale(1.1);
        }

        .logo-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--theme-container);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
            color: var(--theme-white);
        }

        .logo-main {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .logo-sub {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--theme-white) !important;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .dropdown-menu {
            background: var(--theme-dark-brown);
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-in-out;
        }

        .dropdown-item {
            color: var(--theme-white) !important;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--theme-muted-text) !important;
            color: var(--theme-white) !important;
        }

        /* Kartu */
        .elcapo-card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .elcapo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .elcapo-card-header {
            background: var(--theme-container);
            color: var(--theme-dark-brown);
            font-weight: 600;
            padding: 15px 20px;
        }

        /* Tombol */
        .elcapo-btn {
            background: var(--theme-dark-brown);
            color: var(--theme-white);
            border: none;
            transition: all 0.3s;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .elcapo-btn:hover {
            background: var(--theme-muted-text);
            color: var(--theme-white);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        .elcapo-footer {
            background: linear-gradient(135deg, var(--theme-dark-brown), var(--theme-muted-text));
            color: var(--theme-white);
            padding: 60px 0 30px;
            position: relative;
            overflow: hidden;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-section {
            padding: 15px;
            position: relative;
        }

        .footer-section:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            bottom: 20px;
            right: -15px;
            width: 1px;
            background: rgba(255, 255, 255, 0.15);
        }

        .footer-logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .footer-logo:hover {
            transform: rotate(10deg) scale(1.1);
        }

        .footer-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 20px;
            color: var(--theme-container);
            position: relative;
            display: inline-block;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--theme-container);
            transition: width 0.3s ease;
        }

        .footer-title:hover::after {
            width: 60px;
        }

        .footer-text {
            font-family: 'Lora', serif;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .footer-contact-item, .footer-team-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .footer-contact-item i, .footer-team-item i {
            font-size: 1.2rem;
            color: var(--theme-container);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            color: var(--theme-white);
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            color: var(--theme-container);
            transform: translateY(-3px);
        }

        .mission-vision-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        .mission-list {
            list-style: none;
            padding-left: 0;
        }

        .mission-list li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 10px;
        }

        .mission-list li::before {
            content: '\f00c';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 0;
            color: var(--theme-container);
        }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
            font-family: 'Lora', serif;
            color: rgba(255, 255, 255, 0.7);
        }

        .wave-decoration {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            overflow: hidden;
            opacity: 0.8;
        }

        .wave-decoration svg {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Styling untuk Modal Profil dan Favorit */
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--theme-container);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.05);
        }

        .modal-content {
            background: linear-gradient(135deg, var(--theme-light), #fff);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: var(--theme-container);
            color: var(--theme-dark-brown);
            border-bottom: none;
            padding: 20px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .modal-body {
            padding: 30px;
            background: var(--theme-white);
        }

        .modal-body p {
            margin: 10px 0;
            font-size: 1.1rem;
            color: var(--theme-muted-text);
        }

        .modal-body p strong {
            color: var(--theme-dark-brown);
        }

        .modal-footer {
            border-top: none;
            padding: 20px;
            background: var(--theme-white);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .modal-footer .btn-secondary {
            background: var(--theme-muted-text);
            color: var(--theme-white);
            border: none;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-secondary:hover {
            background: var(--theme-dark-brown);
            transform: translateY(-2px);
        }

        .form-label {
            color: var(--theme-dark-brown);
            font-weight: 600;
            font-size: 1rem;
        }

        .form-control {
            border: 1px solid var(--theme-container);
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--theme-accent);
            box-shadow: 0 0 8px rgba(166, 124, 0, 0.3);
        }

        .form-text a {
            color: var(--theme-accent);
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }

        /* Styling untuk Kartu di Modal Favorit */
        .favorite-card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .favorite-card img {
            height: 150px;
            object-fit: cover;
        }

        /* Fallback untuk animate-on-scroll kalau JavaScript mati */
        .animate-on-scroll {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-on-scroll.js-enabled {
            opacity: 0;
            transform: translateY(20px);
        }

        .animate-on-scroll.js-enabled.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Tambah margin-top ke main untuk mencegah overlap dengan navbar */
        main {
            margin-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }

        /* Responsivitas */
        @media (max-width: 992px) {
            .mission-vision-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .footer-section:not(:last-child)::after {
                display: none;
            }

            .footer-section {
                padding: 20px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            }

            .footer-section:last-child {
                border-bottom: none;
            }

            .footer-logo-container {
                align-items: center;
                text-align: center;
            }

            .footer-title {
                font-size: 1.3rem;
            }

            .footer-title::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .profile-img {
                width: 100px;
                height: 100px;
            }

            .favorite-card img {
                height: 120px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark elcapo-navbar" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <div class="logo-circle">
                    <img src="{{ asset('images/elcapo.png') }}" alt="El Capo Land Logo" class="logo-img">
                </div>
                <div class="logo-text">
                    <span class="logo-main">ELCAPO</span>
                    <span class="logo-sub">LAND</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check"></i> Dashboard Admin</a></li>
                            @elseif(auth()->user()->isSeller())
                                <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="bi bi-shop"></i> Dashboard Penjual</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}"><i class="bi bi-house-heart"></i> Dashboard Pembeli</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#favoriteModal"><i class="bi bi-heart-fill"></i> Tanah Favorit</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewProfileModal"><i class="bi bi-person"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Daftar</a></li>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-1">
        @if (session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="elcapo-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Kolom 1: Logo dan Deskripsi -->
                <div class="footer-section">
                    <div class="footer-logo-container">
                        <img src="{{ asset('images/elcapo.png') }}" alt="El Capo Land Logo" class="footer-logo">
                        <h3 class="footer-title">El Capo Land</h3>
                    </div>
                    <p class="footer-text">
                        Platform jual beli tanah terpercaya dengan proses mudah, aman, dan transparan. 
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Kolom 2: Kontak -->
                <div class="footer-section">
                    <h3 class="footer-title"><i class="bi bi-telephone me-2"></i>Hubungi Kami</h3>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:info@elcapoland.com" class="footer-text">info@elcapoland.com</a>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span class="footer-text">(0341) 123456</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span class="footer-text">Jl. Raya No. 123, Malang</span>
                    </div>
                </div>

                <!-- Kolom 3: Tim Kami -->
                <div class="footer-section">
                    <h3 class="footer-title"><i class="bi bi-people me-2"></i>Tim Kami</h3>
                    <div class="footer-team-item">
                        <i class="bi bi-person"></i>
                        <span class="footer-text">Fernantyo Krisnajati</span>
                    </div>
                    <div class="footer-team-item">
                        <i class="bi bi-person"></i>
                        <span class="footer-text">Ramadhony Firman S</span>
                    </div>
                    <div class="footer-team-item">
                        <i class="bi bi-person"></i>
                        <span class="footer-text">Mochamad Diko</span>
                    </div>
                </div>

                <!-- Kolom 4: Tentang Kami -->
                <div class="footer-section">
                    <h3 class="footer-title"><i class="bi bi-info-circle me-2"></i>Tentang Kami</h3>
                    <p class="footer-text">
                        El Capo Land adalah platform inovatif untuk jual beli tanah yang aman dan transparan. 
                        Kami berkomitmen menyediakan solusi digital praktis dengan data legalitas terpercaya.
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-0">© {{ date('Y') }} El Capo Land. Hak Cipta Dilindungi. | Waktu: <span id="current-time"></span></p>
            </div>
            <script>
                function updateTime() {
                    const now = new Date().toLocaleString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false });
                    const timeElement = document.getElementById('current-time');
                    if (timeElement) timeElement.textContent = now;
                    console.log('Current time:', now);
                }
                setInterval(updateTime, 1000);
                updateTime();
            </script>

            <div class="wave-decoration">
                <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,50 C300,100 600,20 900,70 C1200,120 1440,30 1440,50 L1440,100 L0,100 Z" 
                        fill="rgba(255, 255, 255, 0.15)"></path>
                </svg>
            </div>
        </div>
    </footer>

    <!-- Modal Lihat Profil -->
    @auth
    <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProfileModalLabel">Profil Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-user.jpg') }}" 
                         alt="Foto Profil" class="profile-img mb-3">
                    <h5 class="mt-2">{{ auth()->user()->name }}</h5>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Telepon:</strong> {{ auth()->user()->phone ?? 'Belum diatur' }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst(auth()->user()->status) }}</p>
                    @if(auth()->user()->ktp_path)
                        <p><strong>KTP:</strong> <a href="{{ asset('storage/' . auth()->user()->ktp_path) }}" target="_blank">Lihat KTP</a></p>
                    @endif
                    @if(auth()->user()->npwp_path)
                        <p><strong>NPWP:</strong> <a href="{{ asset('storage/' . auth()->user()->npwp_path) }}" target="_blank">Lihat NPWP</a></p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn elcapo-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal" onclick="closeModal('viewProfileModal')">Edit Profil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="text-center mb-3">
                            <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-user.jpg') }}" 
                                 alt="Foto Profil" class="profile-img">
                        </div>
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                            @if(auth()->user()->profile_photo)
                                <small class="form-text text-muted">Foto saat ini: <a href="{{ asset('storage/' . auth()->user()->profile_photo) }}" target="_blank">Lihat</a></small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                        @if(auth()->user()->isSeller())
                            <div class="mb-3">
                                <label for="ktp_path" class="form-label">Foto KTP</label>
                                <input type="file" class="form-control" id="ktp_path" name="ktp_path" accept="image/*">
                                @if(auth()->user()->ktp_path)
                                    <small class="form-text text-muted">KTP saat ini: <a href="{{ asset('storage/' . auth()->user()->ktp_path) }}" target="_blank">Lihat</a></small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="npwp_path" class="form-label">Dokumen NPWP</label>
                                <input type="file" class="form-control" id="npwp_path" name="npwp_path" accept="image/*,application/pdf">
                                @if(auth()->user()->npwp_path)
                                    <small class="form-text text-muted">NPWP saat ini: <a href="{{ asset('storage/' . auth()->user()->npwp_path) }}" target="_blank">Lihat</a></small>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#viewProfileModal" onclick="closeModal('editProfileModal')">Lihat Profil</button>
                        <button type="submit" class="btn elcapo-btn">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tanah Favorit -->
    <div class="modal fade" id="favoriteModal" tabindex="-1" aria-labelledby="favoriteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="favoriteModalLabel"><i class="bi bi-heart-fill me-2"></i>Tanah Favorit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(auth()->user() && auth()->user()->favoriteLands()->count() > 0)
                        <div class="row g-3">
                            @foreach(auth()->user()->favoriteLands()->with('user')->get() as $land)
                                <div class="col-md-6">
                                    <div class="favorite-card">
                                        @php $firstImage = $land->firstImage; @endphp
                                        <img src="{{ $firstImage ? asset('storage/' . $firstImage) : asset('images/default.jpg') }}" 
                                            class="card-img-top" 
                                            alt="{{ $land->title }}"
                                            style="height: 250px; object-fit: cover; border: 2px solid brown;">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold" style="color: var(--theme-dark-brown);">{{ $land->title }}</h5>
                                            @if($land->status === 'sold')
                                                <span class="badge bg-danger bg-opacity-25 text-danger">Terjual</span>
                                            @endif
                                            <p class="card-text">
                                                <i class="bi bi-geo-alt me-1"></i> {{ $land->location }}<br>
                                                <i class="bi bi-arrows-fullscreen me-1"></i> {{ $land->area }} m²
                                            </p>
                                            <p class="card-text fw-bold" style="color: var(--theme-muted-text);">
                                                Rp {{ number_format($land->price, 0, ',', '.') }}
                                            </p>
                                            <a href="{{ route('buyer.lands.show', $land) }}" class="btn elcapo-btn w-100 mb-2" 
                                            onclick="event.preventDefault(); checkAuthAndRedirect('{{ route('buyer.lands.show', $land) }}')">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                            <form action="{{ route('buyer.lands.toggleFavorite', $land) }}" method="POST" class="toggle-favorite-form" id="favorite-toggle-{{ $land->id }}">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-outline-danger w-100" id="favorite-btn-{{ $land->id }}">
                                                    <i class="bi bi-heart-fill me-2"></i> Hapus dari Favorit
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center py-4">
                            <i class="bi bi-info-circle fs-1 mb-3" style="color: var(--theme-dark-brown);"></i>
                            <h4 style="color: var(--theme-dark-brown);">Belum ada tanah favorit bro!</h4>
                            <p>Tambahkan tanah ke favorit dari halaman pencarian ya!</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @if(auth()->user() && auth()->user()->favoriteLands()->count() > 0)
                        <a href="{{ route('buyer.lands.favorites') }}" class="btn elcapo-btn">Lihat Semua Favorit</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Transaksi (Create, Show, Verify) -->
        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="transactionModalBody">
                        <!-- Konten akan dimuat via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    @endauth
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk notifikasi kustom
    function showCustomNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `custom-notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        // Styling dinamis
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.left = '50%';
        notification.style.transform = 'translateX(-50%)';
        notification.style.padding = '15px 25px';
        notification.style.borderRadius = '10px';
        notification.style.zIndex = '1000';
        notification.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
        notification.style.fontFamily = "'Lora', serif";
        notification.style.transition = 'all 0.5s ease';
        notification.style.opacity = '0';
        notification.style.transform = 'translate(-50%, -20px)';

        // Variasi warna berdasarkan tipe
        if (type === 'warning') {
            notification.style.backgroundColor = 'rgba(255, 193, 7, 0.9)';
            notification.style.color = '#333';
            notification.style.border = '2px solid #FFC107';
        } else if (type === 'success') {
            notification.style.backgroundColor = '#d4edda';
            notification.style.color = '#155724';
            notification.style.border = '2px solid #c3e6cb';
        } else if (type === 'error') {
            notification.style.backgroundColor = '#f8d7da';
            notification.style.color = '#721c24';
            notification.style.border = '2px solid #f5c6cb';
        }

        // Animasi masuk
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translate(-50%, 0)';
        }, 10);

        // Hilang setelah 5 detik
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translate(-50%, -20px)';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const bsModal = bootstrap.Modal.getInstance(modal);
        bsModal.hide();
    }

    // Fungsi untuk notifikasi dan redirect
    function showLoginForm(message = null) {
        const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
        const isBuyer = {{ Auth::check() && Auth::user()->isBuyer() ? 'true' : 'false' }};
        if (!isAuthenticated) {
            showCustomNotification(message || 'Yo, login atau daftar dulu bro buat lihat detail tanah!', 'warning');
            setTimeout(() => {
                window.location.href = "{{ route('register') }}";
            }, 5000);
        } else if (!isBuyer) {
            showCustomNotification(message || 'Yo, login sebagai Pembeli dulu bro buat akses fitur ini!', 'warning');
        }
        console.log("showLoginForm called with message:", message);
    }

    // Fungsi untuk memuat konten transaksi via AJAX
    function loadTransactionModal(action, id) {
        fetch(`/${action}/${id}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/html',
            },
        })
        .then(response => response.text())
        .then(html => {
            const modalBody = document.getElementById('transactionModalBody');
            modalBody.innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('transactionModal'));
            modal.show();

            // Handle form submission via AJAX
            const form = modalBody.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: form.method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showCustomNotification(data.message, 'success');
                            modal.hide();
                            location.reload();
                        } else {
                            showCustomNotification(data.message || 'Ada apa nih? Error bro!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showCustomNotification('Ada apa nih? Coba lagi nanti ya bro!', 'error');
                    });
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Animasi navbar saat scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animasi scroll untuk elemen dengan kelas animate-on-scroll
        console.log('Menginisialisasi IntersectionObserver untuk animate-on-scroll');
        const animateOnScrollElements = document.querySelectorAll('.animate-on-scroll');
        console.log('Jumlah elemen dengan animate-on-scroll:', animateOnScrollElements.length);
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    console.log('IntersectionObserver memproses elemen:', entry.target);
                    if (entry.isIntersecting) {
                        console.log('Elemen masuk viewport, menambahkan kelas is-visible:', entry.target);
                        entry.target.classList.add('is-visible');
                        const counterElement = entry.target.querySelector('[data-counter]');
                        if (counterElement) {
                            console.log('Memulai animasi counter untuk:', counterElement);
                            startCounterAnimation(counterElement);
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px' // Tambah margin untuk trigger lebih awal
            });

            animateOnScrollElements.forEach(element => {
                element.classList.add('js-enabled');
                observer.observe(element);
                console.log('Mengamati elemen:', element);
            });
        } else {
            // Fallback kalau IntersectionObserver tidak didukung
            console.log('IntersectionObserver tidak didukung, menampilkan semua elemen');
            animateOnScrollElements.forEach(element => {
                element.classList.add('is-visible');
            });
        }

        // Fungsi untuk animasi counter
        function startCounterAnimation(element) {
            const target = parseInt(element.getAttribute('data-counter'));
            let current = 0;
            const duration = 1500;
            const stepTime = 10;
            const increment = target / (duration / stepTime);

            console.log('Memulai animasi counter, target:', target);
            const timer = setInterval(() => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.ceil(current);
                } else {
                    element.textContent = target;
                    clearInterval(timer);
                    console.log('Animasi counter selesai untuk:', element);
                }
            }, stepTime);
        }

        // Trigger showLoginForm jika ada session triggerLogin
        @if(session('triggerLogin'))
            showLoginForm();
            @php
                session()->forget('triggerLogin');
            @endphp
        @endif

        // Fungsi untuk memeriksa autentikasi dan redirect
        function checkAuthAndRedirect(url) {
            const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
            const isBuyer = {{ Auth::check() && Auth::user()->isBuyer() ? 'true' : 'false' }};
            if (!isAuthenticated) {
                showCustomNotification('Yo, login atau daftar dulu bro buat lihat detail tanah!', 'warning');
                setTimeout(() => {
                    window.location.href = "{{ route('register') }}";
                }, 5000);
            } else if (!isBuyer) {
                showCustomNotification('Yo, login sebagai Pembeli dulu bro buat akses fitur ini!', 'warning');
            } else {
                window.location.href = url;
            }
        }

        // AJAX untuk toggle favorit di modal
        document.querySelectorAll('.toggle-favorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = this.querySelector('button');
                const card = this.closest('.favorite-card');
                const landId = this.id.replace('favorite-toggle-', '');

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.favorited) {
                        button.innerHTML = '<i class="bi bi-heart-fill me-2"></i> Hapus dari Favorit';
                        showCustomNotification('Tanah berhasil ditambahkan ke favorit bro!', 'success');
                    } else {
                        if (card) {
                            card.style.transition = 'opacity 0.5s';
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.remove();
                                const remainingCards = document.querySelectorAll('.favorite-card').length;
                                if (remainingCards === 0) {
                                    const modalBody = document.querySelector('#favoriteModal .modal-body');
                                    modalBody.innerHTML = `
                                        <div class="alert alert-info text-center py-4">
                                            <i class="bi bi-info-circle fs-1 mb-3" style="color: var(--theme-dark-brown);"></i>
                                            <h4 style="color: var(--theme-dark-brown);">Belum ada tanah favorit bro!</h4>
                                            <p>Cari tanah kece di halaman pencarian ya!</p>
                                        </div>
                                    `;
                                    document.querySelector('.modal-footer .btn.elcapo-btn').style.display = 'none';
                                }
                            }, 500);
                        }
                        showCustomNotification('Tanah berhasil dihapus dari favorit bro!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error toggling favorite:', error);
                    showCustomNotification('Ada apa nih? Coba lagi nanti ya bro!', 'error');
                });
            });
        });

        // Animasi loading untuk semua form
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                if (button && !button.disabled) {
                    button.disabled = true;
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i> Memproses...';
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }, 5000);
                }
            });
        });

        // Animasi Pencarian Tanah
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
                const isBuyer = {{ Auth::check() && Auth::user()->isBuyer() ? 'true' : 'false' }};
                const button = this.querySelector('button[type="submit"]');
                
                const redirectInput = this.querySelector('input[name="redirect"][value="login"]');
                if (redirectInput) {
                    e.preventDefault();
                    showCustomNotification('Yo, login sebagai Pembeli dulu bro buat cari tanah!', 'warning');
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-search me-1"></i> Cari';
                    }, 5000);
                } else {
                    button.disabled = true;
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mencari...';
                }
            });
        }

        // Panggil fungsi saat tombol transaksi diklik
        document.querySelectorAll('.btn-transaction').forEach(button => {
            button.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const id = this.getAttribute('data-id');
                document.getElementById('transactionModalLabel').textContent = `${action === 'create' ? 'Pembayaran' : 'Detail Transaksi'} #${id}`;
                loadTransactionModal(action, id);
            });
        });
    });
</script>
<style>
    .custom-notification {
        font-size: 1.1rem;
        text-align: center;
    }
    .spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
</style>
</html>