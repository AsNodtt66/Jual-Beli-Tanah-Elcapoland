@extends('layouts.app')

@section('content')
<div class="container pt-1"> <!-- Tambah mt-5 pt-5 untuk mencegah overlap -->
    <div class="card elcapo-card mt-4">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-heart-fill me-2"></i>Tanah Favorit</h4>
        </div>
        
        <div class="card-body">
            @if($favoriteLands->count() > 0)
                <div class="row">
                    @foreach($favoriteLands as $land)
                    <div class="col-md-4 mb-4">
                        <div class="card elcapo-card h-100">
                            <div class="position-relative">
                                @php
                                    // Rely on the Land model's getFirstImageAttribute and casting
                                    $firstImage = $land->firstImage;
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
                                    {{ formatPrice($land->price) }}
                                </p>
                                <a href="{{ route('buyer.lands.show', $land) }}" class="btn w-100 elcapo-btn">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                                <form action="{{ route('buyer.lands.toggleFavorite', $land) }}" method="POST" style="display:inline; margin-top: 5px;" id="favorite-toggle-{{ $land->id }}">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $favoriteLands->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle fs-1 mb-3" style="color: #4E2E1D;"></i>
                    <h4 class="elcapo-text-brown">Belum ada tanah favorit</h4>
                    <p>Tambahkan tanah ke favorit dari halaman pencarian</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Styling untuk pagination */
    .pagination {
        --bs-pagination-bg: #F5E8D7; /* Krem dari tema El Capo */
        --bs-pagination-color: #4E2E1D; /* Coklat tua */
        --bs-pagination-border-color: #D8AE7E; /* Coklat muda */
        --bs-pagination-hover-bg: #8D6B4F; /* Coklat sedang */
        --bs-pagination-hover-color: #FFFFFF; /* Putih untuk hover */
        --bs-pagination-active-bg: #4E2E1D; /* Coklat tua untuk active */
        --bs-pagination-active-color: #FFFFFF; /* Putih untuk active */
        --bs-pagination-border-radius: 8px; /* Sudut membulat */
        --bs-pagination-font-size: 1rem; /* Ukuran font */
    }

    .pagination .page-link {
        transition: all 0.3s ease;
        font-family: 'Lora', serif;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--bs-pagination-active-bg);
        color: var(--bs-pagination-active-color);
        border-color: var(--bs-pagination-active-bg);
    }

    .pagination .page-item.disabled .page-link {
        background-color: #EDEDED; /* Abu-abu untuk disabled */
        color: #6C757D; /* Abu-abu teks */
        cursor: not-allowed;
    }

    .pagination .page-item .page-link:hover {
        background-color: var(--bs-pagination-hover-bg);
        color: var(--bs-pagination-hover-color);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[id^="favorite-toggle-"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formId = this.id;
                const landId = formId.replace('favorite-toggle-', '');
                const button = document.getElementById(`favorite-btn-${landId}`);
                const card = button.closest('.elcapo-card'); // Get the parent card

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
                        // This branch should ideally not be hit if it's "Hapus dari Favorit"
                        button.innerHTML = '<i class="bi bi-heart-fill me-2"></i> Hapus dari Favorit';
                        showCustomNotification(data.message, 'success');
                    } else {
                        // Remove the card from the DOM
                        if (card) {
                            card.closest('.col-md-4.mb-4').remove(); // Remove the column containing the card
                        }
                        // If no cards are left, reload to show "Belum ada tanah favorit" message
                        if (document.querySelectorAll('.elcapo-card').length === 0) {
                            location.reload();
                        }
                        showCustomNotification(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showCustomNotification('Terjadi kesalahan, coba lagi nanti.', 'error');
                });
            });
        });
    });
</script>
@endsection