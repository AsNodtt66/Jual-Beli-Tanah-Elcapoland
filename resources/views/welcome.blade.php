@extends('layouts.app')

@section('content')

    @if(session('message'))
        <div class="container mt-3">
            <div class="alert alert-{{ session('message_type') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @php
            session()->forget(['message', 'message_type']);
        @endphp
    @endif

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0 animate-fadeInUp">
                    <h1 class="display-3 fw-bold mb-4 text-white text-shadow">Temukan Tanah Impian Anda</h1>
                    <p class="lead mb-5 text-white text-shadow">Platform jual beli tanah terpercaya dengan proses mudah, aman, dan transparan. Mulai perjalanan properti Anda hari ini!</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        @auth
                            @if(auth()->user()->isBuyer())
                                <a href="{{ route('buyer.lands.index') }}" class="btn btn-light btn-lg px-4 py-3 shadow">
                                    <i class="bi bi-search me-2"></i>Cari Tanah
                                </a>
                            @else
                                <button type="button" class="btn btn-light btn-lg px-4 py-3 shadow" onclick="showLoginForm('Yo, login sebagai Pembeli dulu bro buat cari tanah!')">
                                    <i class="bi bi-search me-2"></i>Cari Tanah
                                </button>
                            @endif
                        @else
                            <a href="{{ route('buyer.lands.index') }}" class="btn btn-light btn-lg px-4 py-3 shadow">
                                <i class="bi bi-search me-2"></i>Cari Tanah
                            </a>
                        @endauth
                        @auth
                            @if(auth()->user()->isSeller())
                                <a href="{{ route('seller.lands.create') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                                    <i class="bi bi-plus-circle me-2"></i>Jual Tanah
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 animate-fadeInUp delay-1">
                    <div class="position-relative">
                        <div class="hero-image-main">
                            <img src="{{ asset('images/hero-land.jpg') }}" alt="Tanah Impian" class="img-fluid">
                        </div>
                        <div class="position-absolute top-0 start-0 translate-middle bg-white p-2 rounded-circle shadow-sm d-none d-md-block">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="bi bi-shield-check fs-3"></i>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 translate-middle bg-white p-2 rounded-circle shadow-sm d-none d-md-block">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="bi bi-currency-exchange fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg elcapo-card">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="text-center mb-4 fw-bold">Cari Tanah Impian Anda</h2>
                            <form action="{{ route('buyer.lands.index') }}" method="GET" id="searchForm">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                            <input type="text" name="search" class="form-control border-start-0" 
                                                placeholder="Lokasi atau kata kunci..." 
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="price_range" class="form-select form-select-lg">
                                            <option value="">Rentang Harga</option>
                                            <option value="0-500000000">Rp 0 - 500 Juta</option>
                                            <option value="500000000-1000000000">Rp 500 Juta - 1 Miliar</option>
                                            <option value="1000000000-5000000000">Rp 1 Miliar - 5 Miliar</option>
                                            <option value="5000000000-">> Rp 5 Miliar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="area" class="form-select form-select-lg">
                                            <option value="">Luas Tanah</option>
                                            <option value="0-500">< 500 m²</option>
                                            <option value="500-1000">500 - 1000 m²</option>
                                            <option value="1000-5000">1000 - 5000 m²</option>
                                            <option value="5000-">> 5000 m²</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn w-100 btn-lg elcapo-btn" id="searchButton">
                                            <i class="bi bi-search me-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                                @auth
                                    @if(!auth()->user()->isBuyer())
                                        <input type="hidden" name="redirect" value="login">
                                    @endif
                                @else
                                    <input type="hidden" name="redirect" value="login">
                                @endauth
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Featured Lands Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="display-5 fw-bold mb-3">Tanah Tersedia</h2>
                <p class="lead text-muted">Berbagai pilihan tanah terbaik dengan lokasi strategis</p>
            </div>

            @if($lands->count() > 0)
                <div class="row g-4">
                    @foreach($lands as $land)
                        <div class="col-md-6 col-lg-4 animate-on-scroll">
                            <div class="card elcapo-card h-100 border-0 shadow-hover">
                                <div class="position-relative">
                                    @php
                                        $firstImage = $land->firstImage;
                                        \Log::info('Welcome blade image check', [
                                            'land_id' => $land->id,
                                            'firstImage' => $firstImage,
                                            'file_exists' => $firstImage ? Storage::disk('public')->exists($firstImage) : false,
                                            'url' => $firstImage ? asset('storage/' . $firstImage) : asset('images/default-land.jpg')
                                        ]);
                                    @endphp
                                    <img src="{{ $firstImage ? asset('storage/' . $firstImage) : asset('images/default-land.jpg') }}"
                                        class="card-img-top"
                                        alt="{{ $land->title }}"
                                        style="height: 250px; object-fit: cover; border: 2px solid brown;">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-primary bg-opacity-90 py-2 px-3">
                                            <i class="bi bi-star-fill me-1"></i> Featured
                                        </span>
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-50 text-white">
                                        <h5 class="mb-0">{{ $land->title }}</h5>
                                        @if($land->status === 'sold')
                                            <span class="badge bg-danger bg-opacity-25 text-danger">Terjual</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold fs-5 text-primary">{{ formatPrice($land->price) }}</span>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-arrows-fullscreen me-1"></i> {{ $land->area }} m²
                                        </span>
                                    </div>
                                    <p class="card-text mb-4">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $land->location }}
                                    </p>
                                    <div class="d-grid">
                                        @if(auth()->check() && auth()->user()->isBuyer())
                                            <a href="{{ route('buyer.lands.show', $land) }}" class="btn elcapo-btn">
                                                <i class="bi bi-eye me-1"></i> Lihat Detail
                                            </a>
                                        @else
                                            <button type="button" class="btn elcapo-btn" onclick="showLoginForm()">
                                                <i class="bi bi-eye me-1"></i> Lihat Detail ({{ auth()->check() ? 'Login sebagai Buyer' : 'Login' }})
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-5">
                    {{ $lands->links() }}
                </div>
            @else
                <div class="text-center py-5 animate-on-scroll">
                    <div class="mb-4">
                        <i class="bi bi-search display-1 text-muted"></i>
                    </div>
                    <h4 class="mb-3">Belum ada tanah yang tersedia</h4>
                    <p class="text-muted mb-4">Silakan coba kata kunci pencarian yang berbeda</p>
                    <a href="{{ route('home') }}" class="btn elcapo-btn">
                        <i class="bi bi-arrow-repeat me-1"></i> Reset Pencarian
                    </a>
                </div>
            @endif
        </div>
    </section>



    <!-- How It Works Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="display-5 fw-bold mb-3">Cara Kerja Kami</h2>
                <p class="lead text-muted">Proses mudah untuk mendapatkan tanah impian Anda</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 animate-on-scroll">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="icon-wrapper mx-auto mb-4">
                            <div class="icon-bg bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-search display-5"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">Cari Tanah</h5>
                        <p class="text-muted">Temukan tanah yang sesuai dengan kriteria Anda menggunakan fitur pencarian kami</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 animate-on-scroll delay-1">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="icon-wrapper mx-auto mb-4">
                            <div class="icon-bg bg-success bg-opacity-10 text-success">
                                <i class="bi bi-eye display-5"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">Lihat Detail</h5>
                        <p class="text-muted">Pelajari detail lengkap tanah termasuk lokasi, luas, dan fasilitas sekitar</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 animate-on-scroll delay-2">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="icon-wrapper mx-auto mb-4">
                            <div class="icon-bg bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-chat-dots display-5"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">Hubungi Penjual</h5>
                        <p class="text-muted">Ajukan pertanyaan atau negosiasi langsung dengan penjual melalui platform</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 animate-on-scroll delay-3">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="icon-wrapper mx-auto mb-4">
                            <div class="icon-bg bg-info bg-opacity-10 text-info">
                                <i class="bi bi-check-circle display-5"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">Transaksi Aman</h5>
                        <p class="text-muted">Lakukan transaksi aman dengan jaminan keamanan dari kami</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3 animate-on-scroll">
                    <div class="display-4 fw-bold" data-counter="500">0</div>
                    <p class="mb-0 text-uppercase text-white-50">Tanah Terdaftar</p>
                </div>
                <div class="col-md-3 animate-on-scroll delay-1">
                    <div class="display-4 fw-bold" data-counter="120">0</div>
                    <p class="mb-0 text-uppercase text-white-50">Transaksi Sukses</p>
                </div>
                <div class="col-md-3 animate-on-scroll delay-2">
                    <div class="display-4 fw-bold" data-counter="25">0</div>
                    <p class="mb-0 text-uppercase text-white-50">Kota Tersedia</p>
                </div>
                <div class="col-md-3 animate-on-scroll delay-3">
                    <div class="display-4 fw-bold" data-counter="98">0</div>
                    <p class="mb-0 text-uppercase text-white-50">Kepuasan Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll">
                <h2 class="display-5 fw-bold mb-3">Apa Kata Pengguna</h2>
                <p class="lead text-muted">Testimoni dari pelanggan yang puas</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 animate-on-scroll">
                    <div class="card testimonial-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('images/user1.jpg') }}" alt="User" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <span class="text-muted">Pembeli Tanah</span>
                                </div>
                            </div>
                            <p class="mb-0">"Proses transaksi sangat mudah dan cepat. Saya menemukan tanah yang sesuai dengan budget dalam waktu singkat."</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="rating text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll delay-1">
                    <div class="card testimonial-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('images/user2.jpg') }}" alt="User" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-0">Siti Rahayu</h5>
                                    <span class="text-muted">Penjual Tanah</span>
                                </div>
                            </div>
                            <p class="mb-0">"Tanah keluarga saya terjual dengan harga yang sangat memuaskan. Platform yang sangat profesional dan aman."</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="rating text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll delay-2">
                    <div class="card testimonial-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('images/user3.jpg') }}" alt="User" class="rounded-circle testimonial-img me-3">
                                <div>
                                    <h5 class="mb-0">Andi Wijaya</h5>
                                    <span class="text-muted">Investor</span>
                                </div>
                            </div>
                            <p class="mb-0">"Saya sudah 3 kali bertransaksi di ELCAPO LAND. Semuanya berjalan lancar. Platform terbaik untuk investasi tanah."</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="rating text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="stats-section position-relative overflow-hidden">
        <div class="container position-relative z-index-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center animate-on-scroll">
                    <h2 class="text-white display-5 fw-bold mb-4">Siap Memulai Perjalanan Properti Anda?</h2>
                    <p class="text-white-75 mb-5">Bergabunglah dengan ribuan pengguna puas kami dan temukan tanah impian Anda hari ini</p>
                    <div class="d-flex justify-content-center gap-3">
                        @auth
                            @if(auth()->user()->isSeller())
                                <a href="{{ route('seller.lands.create') }}" class="btn btn-light btn-lg px-4 py-3">
                                    <i class="bi bi-plus-circle me-2"></i>Jual Tanah Anda
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 py-3">
                                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                            </a>
                        @endauth
                        <a href="{{ route('buyer.lands.index') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="bi bi-search me-2"></i>Cari Tanah
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary bg-opacity-10"></div>
            <div class="position-absolute bottom-0 end-0">
                <div class="bg-white bg-opacity-10 rounded-circle" style="width: 300px; height: 300px;"></div>
            </div>
            <div class="position-absolute top-50 start-0 translate-middle-y">
                <div class="bg-white bg-opacity-10 rounded-circle" style="width: 200px; height: 200px;"></div>
            </div>
        </div>
    </section>

    <style>
        .shadow-hover {
            transition: all 0.3s ease;
        }
        
        .shadow-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }
        
        .rating i {
            font-size: 1.2rem;
        }
        
        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }
    </style>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        /* ... (CSS Anda yang sudah ada) ... */

        /* Tambahkan gaya untuk Stats Section */
        .stats-section {
            background: linear-gradient(90deg, var(--theme-dark-brown), var(--theme-muted-text)); /* Menggunakan variabel tema Anda */
            color: var(--theme-white); /* Warna teks putih */
            padding: 60px 0; /* Padding atas dan bawah */
            position: relative;
            overflow: hidden;
        }

        .stats-section .display-4 {
            color: var(--theme-container); /* Warna untuk angka statistik */
            margin-bottom: 5px;
        }

        .stats-section p {
            color: rgba(255, 255, 255, 0.8);
            font-family: 'Lora', serif;
        }

        /* Animasi untuk animate-on-scroll */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0; /* Sembunyikan secara default */
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            transform: translateY(20px);
        }

        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-on-scroll.delay-1 { transition-delay: 0.1s; }
        .animate-on-scroll.delay-2 { transition-delay: 0.2s; }
        .animate-on-scroll.delay-3 { transition-delay: 0.3s; }
    </style>
@endsection