@extends('layouts.app')

@section('content')
<div class="container pt-1"> <!-- Tambah mt-5 pt-5 untuk mencegah overlap -->
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>Detail Tanah</h4>
        </div>
        
        <div class="card-body">
            @if($land->status === 'sold')
                <div class="alert alert-danger text-center mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i> Tanah ini telah terjual dan tidak tersedia untuk transaksi.
                </div>
            @endif

            @php
                // $land->images sudah berupa array berkat model casting di Land.php
                $images = $land->images;
                $isValidImages = is_array($images) && count($images) > 0;
            @endphp
            @if($isValidImages)
                @php
                    $displayImages = array_slice($images, 0, 5);
                @endphp
                <div id="landImagesCarousel-{{ $land->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($displayImages as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}"
                                     alt="{{ $land->title }} - Image {{ $index + 1 }}"
                                     class="d-block w-100"
                                     style="height: 400px; object-fit: cover; border: 1px solid brown;">
                            </div>
                        @endforeach
                    </div>
                    @if(count($displayImages) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#landImagesCarousel-{{ $land->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#landImagesCarousel-{{ $land->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                    @if(count($images) > 5)
                        <div class="form-text mt-2">
                            <small>Hanya 5 foto pertama yang ditampilkan.</small>
                        </div>
                    @endif
                </div>
            @else
                <img src="{{ asset('images/default-land.jpg') }}"
                     alt="{{ $land->title }}"
                     class="img-fluid w-100"
                     style="height: 400px; object-fit: cover; border: 1px solid brown;">
            @endif

            <div class="row mt-4">
                <div class="col-md-8">
                    <h3 class="elcapo-text-brown">{{ $land->title }}</h3>
                    @if($land->status === 'sold')
                        <span class="badge bg-danger bg-opacity-25 text-danger">Terjual</span>
                    @endif
                    <p class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $land->location }}</p>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <h5>Harga</h5>
                            <p class="fs-4 fw-bold" style="color: #8D6B4F;">{{ formatPrice($land->price) }}</p>
                        </div>
                        <div>
                            <h5>Luas</h5>
                            <p class="fs-4">{{ $land->area }} m²</p>
                        </div>
                    </div>
                    
                    <h5 class="elcapo-text-brown">Deskripsi</h5>
                    <p class="mb-4">{{ $land->description }}</p>
                </div>

                <div class="col-md-4">
                    <h5 class="elcapo-text-brown">Informasi Penjual</h5>
                    <div class="card mb-4 elcapo-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bi bi-person-circle fs-1" style="color: #4E2E1D;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $land->user->name }}</h5>
                                        <p class="mb-0">
                                            <i class="bi bi-shield-check me-1"></i>
                                            {{ $land->user->ktp_path && $land->user->npwp_path ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                        </p>
                                    </div>
                                </div>
                                <button class="btn elcapo-btn" data-bs-toggle="modal" data-bs-target="#sellerProfileModal-{{ $land->user->id }}">
                                    <i class="bi bi-person-lines-fill me-1"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-lg btn-offer custom-btn" data-land-id="{{ $land->id }}" data-seller-phone="{{ $land->user->phone }}" data-land-title="{{ $land->title }}">
                            <i class="bi bi-whatsapp"></i> Buat Penawaran
                        </button>
                        @if($land->status !== 'sold')
                            <a href="{{ route('buyer.transactions.create', $land) }}" class="btn btn-lg elcapo-btn custom-btn">
                                <i class="bi bi-cash me-2"></i> Beli Sekarang
                            </a>
                        @else
                            <button class="btn btn-lg btn-secondary custom-btn" disabled>
                                <i class="bi bi-cash me-2"></i> Sudah Terjual
                            </button>
                        @endif
                        <form action="{{ route('buyer.lands.toggleFavorite', $land) }}" method="POST" style="display:inline; margin-top: 5px;" id="favorite-toggle-{{ $land->id }}" class="mb-3">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-outline-danger w-100 custom-btn" id="favorite-btn-{{ $land->id }}">
                                <i class="bi bi-heart{{ auth()->user()->favoriteLands()->where('land_id', $land->id)->exists() ? '-fill' : '' }} me-2"></i> {{ auth()->user()->favoriteLands()->where('land_id', $land->id)->exists() ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                            </button>
                        </form>
                        <a href="{{ route('buyer.lands.index') }}" class="btn btn-lg btn-secondary custom-btn">
                            <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sellerProfileModal-{{ $land->user->id }}" tabindex="-1" aria-labelledby="sellerProfileModalLabel-{{ $land->user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content elcapo-card">
            <div class="modal-header elcapo-card-header">
                <h5 class="modal-title" id="sellerProfileModalLabel-{{ $land->user->id }}">Detail Penjual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-person-circle fs-1" style="color: #4E2E1D;"></i>
                    <h5 class="mt-2 mb-1">{{ $land->user->name }}</h5>
                    <p class="text-muted mb-0">
                        <i class="bi bi-envelope me-1"></i> {{ $land->user->email }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="bi bi-phone me-1"></i> {{ $land->user->phone }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="bi bi-shield-check me-1"></i>
                        {{ $land->user->ktp_path && $land->user->npwp_path ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                    </p>
                </div>
                <div class="d-grid gap-2">
                    <a href="https://wa.me/{{ $land->user->phone }}" class="btn btn-success" target="_blank">
                        <i class="bi bi-whatsapp me-2"></i> Hubungi Penjual (WhatsApp)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle favorite toggle via AJAX
        const favoriteForm = document.getElementById('favorite-toggle-{{ $land->id }}');
        if (favoriteForm) {
            favoriteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = document.getElementById('favorite-btn-{{ $land->id }}');

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.favorited) {
                        button.innerHTML = '<i class="bi bi-heart-fill me-2"></i> Hapus dari Favorit';
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger'); // Opsional: ganti gaya tombol jika difavoritkan
                        showCustomNotification(data.message, 'success');
                    } else {
                        button.innerHTML = '<i class="bi bi-heart me-2"></i> Tambah ke Favorit';
                        button.classList.remove('btn-danger'); // Opsional: ganti gaya tombol jika tidak difavoritkan
                        button.classList.add('btn-outline-danger');
                        showCustomNotification(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showCustomNotification('Terjadi kesalahan, coba lagi nanti.', 'error');
                });
            });
        }

        // Handle WhatsApp offer button
        const offerButton = document.querySelector('.btn-offer');
        if (offerButton) {
            offerButton.addEventListener('click', function() {
                const sellerPhone = this.dataset.sellerPhone;
                const landTitle = this.dataset.landTitle;
                const whatsappMessage = `Halo, saya tertarik dengan tanah "${landTitle}" yang Anda jual. Bisakah kita bernegosiasi?`;
                const whatsappUrl = `https://wa.me/${sellerPhone}?text=${encodeURIComponent(whatsappMessage)}`;
                window.open(whatsappUrl, '_blank');
            });
        }
    });
</script>
@endsection