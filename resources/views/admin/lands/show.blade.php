@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>Detail Tanah</h4>
        </div>
        <div class="card-body">
            <h5>{{ $land->title }}</h5>
            <p><strong>Lokasi:</strong> {{ $land->location }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($land->price, 0, ',', '.') }}</p>
            <p><strong>Luas Tanah:</strong> {{ $land->area }} m²</p>
            <p><strong>Deskripsi:</strong> {{ $land->description }}</p>
            <p><strong>Nomor Sertifikat:</strong> {{ $land->certificate_number }}</p>
            <p><strong>Pemilik:</strong> {{ $land->user->name }}</p>
            <!-- Foto-foto tanah -->
            <div class="mt-3">
                <strong>Foto Tanah:</strong><br>
                @php
                    $images = $land->images;
                @endphp
                @foreach($images as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Foto Tanah" style="width: 200px; height: auto; margin: 5px;">
                @endforeach
                @if($land->is_sold)
                    <span class="badge bg-danger bg-opacity-25 text-danger">Terjual</span>
                @endif
            </div>
            <!-- Tombol aksi -->
            <div class="mt-4">
                <form action="{{ route('admin.lands.verify', $land) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle me-1"></i> Verifikasi
                    </button>
                </form>
                <form action="{{ route('admin.lands.reject', $land) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger me-2">
                        <i class="bi bi-x-circle me-1"></i> Tolak
                    </button>
                </form>
                <a href="{{ route('admin.lands.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection