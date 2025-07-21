@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/btn.css') }}">
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-clipboard-check me-2"></i>Verifikasi Listing Tanah
            </h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="card-body">
            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-hourglass-split me-2"></i>Perlu Verifikasi</h5>
            @if($unverifiedLands->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Pemilik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unverifiedLands as $land)
                            <tr>
                                <td>{{ $land->title }}</td>
                                <td>{{ $land->location }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($land->price, 0, ',', '.') }}</td>
                                <td>{{ $land->user->name }}</td>
                                <td>
                                    <a href="{{ route('admin.lands.show', $land) }}" class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <form action="{{ route('admin.lands.verify', $land) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success me-1">
                                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.lands.reject', $land) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $unverifiedLands->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Tidak ada tanah yang perlu diverifikasi</h5>
                    </div>
                </div>
            @endif

            <hr class="my-4">
            
            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-check-circle me-2"></i>Tanah Terverifikasi</h5>
            @if($verifiedLands->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Pemilik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifiedLands as $land)
                            <tr>
                                <td>{{ $land->title }}</td>
                                <td>{{ $land->location }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($land->price, 0, ',', '.') }}</td>
                                <td>{{ $land->user->name }}</td>
                                <td><span class="badge bg-success bg-opacity-25 text-success">Terverifikasi</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $verifiedLands->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Belum ada tanah terverifikasi</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .custom-notification {
        font-size: 1.1rem;
        text-align: center;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px 25px;
        border-radius: 10px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-family: 'Lora', serif;
        transition: all 0.5s ease;
        opacity: 0;
        transform: translate(-50%, -20px);
    }

    .custom-notification.success {
        background-color: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
    }

    .custom-notification.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
    }
</style>

<script>
    // Cek apakah ada notifikasi sukses atau error dari session
    @if (session('success'))
        showCustomNotification("{{ session('success') }}", 'success');
    @elseif (session('error'))
        showCustomNotification("{{ session('error') }}", 'error');
    @endif
</script>
@endsection