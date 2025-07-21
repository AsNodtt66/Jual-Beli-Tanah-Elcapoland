@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-search me-2"></i>Daftar Tanah Terverifikasi</h4>
        </div>
        
        <div class="card-body">
            <form action="{{ route('buyer.lands.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari berdasarkan lokasi atau judul..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="price_range" class="form-select">
                            <option value="">Rentang Harga</option>
                            <option value="0-500000000" {{ request('price_range') == '0-500000000' ? 'selected' : '' }}>Rp 0 - 500 Juta</option>
                            <option value="500000000-1000000000" {{ request('price_range') == '500000000-1000000000' ? 'selected' : '' }}>Rp 500 Juta - 1 Miliar</option>
                            <option value="1000000000-5000000000" {{ request('price_range') == '1000000000-5000000000' ? 'selected' : '' }}>Rp 1 Miliar - 5 Miliar</option>
                            <option value="5000000000-" {{ request('price_range') == '5000000000-' ? 'selected' : '' }}>> Rp 5 Miliar</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="area" class="form-select">
                            <option value="">Luas Tanah</option>
                            <option value="0-500" {{ request('area') == '0-500' ? 'selected' : '' }}>&lt; 500 m²</option>
                            <option value="500-1000" {{ request('area') == '500-1000' ? 'selected' : '' }}>500 - 1000 m²</option>
                            <option value="1000-5000" {{ request('area') == '1000-5000' ? 'selected' : '' }}>1000 - 5000 m²</option>
                            <option value="5000-" {{ request('area') == '5000-' ? 'selected' : '' }}>&gt; 5000 m²</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn elcapo-btn w-100">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('buyer.lands.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-repeat me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            @if($lands->count() > 0)
                <div class="row">
                    @foreach($lands as $land)
                        <div class="col-md-4 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="position-relative">
                                    @php
                                        $firstImage = $land->firstImage;
                                        // Hapus Log::info ini di produksi
                                        // \Log::info('Index blade image check', [
                                        //     'land_id' => $land->id,
                                        //     'firstImage' => $firstImage,
                                        //     'file_exists' => $firstImage ? Storage::disk('public')->exists($firstImage) : false,
                                        //     'url' => $firstImage ? asset('storage/' . $firstImage) : asset('images/default-land.jpg')
                                        // ]);
                                    @endphp
                                    <img src="{{ $firstImage ? asset('storage/' . $firstImage) : asset('images/default-land.jpg') }}"
                                         class="card-img-top"
                                         alt="{{ $land->title }}"
                                         style="height: 250px; object-fit: cover; border: 2px solid brown;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold" style="color: #4E2E1D;">{{ $land->title }}</h5>
                                    @if($land->status === 'sold')
                                        <span class="badge bg-danger bg-opacity-25 text-danger">Terjual</span>
                                    @endif
                                    <p class="card-text">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $land->location }}<br>
                                        <i class="bi bi-arrows-fullscreen me-1"></i> {{ $land->area }} m²
                                    </p>
                                    <p class="card-text fw-bold" style="color: #8D6B4F;">
                                        {{ formatPrice($land->price) }} {{-- Panggil fungsi helper formatPrice --}}
                                    </p>
                                    @if($land->status !== 'sold')
                                        @auth
                                            @if(auth()->user()->isBuyer())
                                                <a href="{{ route('buyer.lands.show', $land) }}" class="btn w-100 elcapo-btn mb-2">
                                                    <i class="bi bi-eye me-1"></i> Detail
                                                </a>
                                                <form action="{{ route('buyer.lands.toggleFavorite', $land) }}" method="POST" style="display:inline;" id="favorite-toggle-{{ $land->id }}">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-outline-danger w-100" id="favorite-btn-{{ $land->id }}">
                                                        <i class="bi bi-heart{{ auth()->user()->favoriteLands()->where('land_id', $land->id)->exists() ? '-fill' : '' }} me-2"></i> 
                                                        {{ auth()->user()->favoriteLands()->where('land_id', $land->id)->exists() ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Jika user login tapi bukan buyer --}}
                                                <button type="button" class="btn w-100 elcapo-btn mb-2" onclick="showLoginForm('Untuk melihat detail tanah, Anda perlu login sebagai Pembeli.')">
                                                    <i class="bi bi-eye me-1"></i> Detail
                                                </button>
                                                <button type="button" class="btn btn-outline-danger w-100" onclick="showLoginForm('Untuk menambahkan ke favorit, Anda perlu login sebagai Pembeli.')">
                                                    <i class="bi bi-heart me-2"></i> Tambah ke Favorit
                                                </button>
                                            @endif
                                        @else
                                            {{-- Jika guest (belum login) --}}
                                            <button type="button" class="btn w-100 elcapo-btn mb-2" onclick="showLoginForm('Untuk melihat detail tanah, Anda perlu login sebagai Pembeli.')">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </button>
                                            <button type="button" class="btn btn-outline-danger w-100" onclick="showLoginForm('Untuk menambahkan ke favorit, Anda perlu login sebagai Pembeli.')">
                                                <i class="bi bi-heart me-2"></i> Tambah ke Favorit
                                            </button>
                                        @endauth
                                    @else
                                        <button class="btn w-100 btn-secondary" disabled>
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $lands->links() }}
                </div>
             @else
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle fs-1 mb-3" style="color: #4E2E1D;"></i>
                    <h4 class="elcapo-text-brown">Tidak ada tanah yang tersedia</h4>
                    <p>Coba gunakan kata kunci pencarian yang berbeda</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Hapus definisi fungsi formatPrice() dari sini --}}
{{-- @php
    function formatPrice($price) {
        if ($price >= 1000000000) {
            $value = $price / 1000000000;
            return 'Rp ' . (floor($value) == $value ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.')) . ' Miliar';
        } elseif ($price >= 1000000) {
            $value = $price / 1000000;
            return 'Rp ' . (floor($value) == $value ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.')) . ' Juta';
        } else {
            return 'Rp ' . number_format($price, 0, ',', '.');
        }
    }
@endphp --}}

<script>
    document.querySelector('form[action="{{ route('buyer.lands.index') }}"]').addEventListener('submit', function() {
        const button = this.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i> Mencari...';
        setTimeout(() => {
            button.disabled = false;
            button.innerHTML = '<i class="bi bi-search me-1"></i> Cari';
        }, 5000);
    });

    document.querySelectorAll('form[action*="toggleFavorite"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('button');
            const card = this.closest('.elcapo-card');
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            })
            .then(response => response.json())
            .then(data => {
                if (data.favorited) {
                    button.innerHTML = '<i class="bi bi-heart-fill me-2"></i> Hapus dari Favorit';
                    showCustomNotification('Tanah berhasil ditambahkan ke favorit!', 'success'); // Ganti showNotification
                } else {
                    if (card) card.remove();
                    if (document.querySelectorAll('.elcapo-card').length === 0) {
                        location.reload();
                    }
                    showCustomNotification('Tanah berhasil dihapus dari favorit!', 'success'); // Ganti showNotification
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomNotification('Terjadi kesalahan, coba lagi nanti.', 'error'); // Ganti showNotification
            });
        });
    });

    // Hapus definisi fungsi showNotification() dari sini
    // function showNotification(message, type) {
    //     const notification = document.createElement('div');
    //     notification.className = `notification ${type}`;
    //     notification.textContent = message;
    //     document.body.appendChild(notification);

    //     notification.style.position = 'fixed';
    //     notification.style.top = '20px';
    //     notification.style.left = '50%';
    //     notification.style.transform = 'translateX(-50%)';
    //     notification.style.padding = '10px 20px';
    //     notification.style.borderRadius = '5px';
    //     notification.style.zIndex = '1000';
    //     notification.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.2)';
    //     notification.style.transition = 'opacity 0.5s';

    //     if (type === 'success') {
    //         notification.style.backgroundColor = '#d4edda';
    //         notification.style.color = '#155724';
    //         notification.style.border = '1px solid #c3e6cb';
    //     } else if (type === 'error') {
    //         notification.style.backgroundColor = '#f8d7da';
    //         notification.style.color = '#721c24';
    //         notification.style.border = '1px solid #f5c6cb';
    //     }

    //     setTimeout(() => {
    //         notification.style.opacity = '0';
    //         setTimeout(() => notification.remove(), 500);
    //     }, 3000);
    // }
</script>

<style>
    .notification {
        opacity: 1;
    }
    .spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
</style>

@endsection
