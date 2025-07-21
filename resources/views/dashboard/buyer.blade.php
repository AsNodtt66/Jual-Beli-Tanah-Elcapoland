@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card elcapo-card">
                <div class="elcapo-card-header">
                    <h4 class="mb-0"><i class="bi bi-house-heart me-2"></i>Dashboard Pembeli</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="elcapo-text-brown">Selamat datang, {{ $user->name }}!</h3>
                        <p class="text-muted">Anda login sebagai <strong class="text-primary">Pembeli</strong></p>
                    </div>
                    <div class="alert alert-info">
                        Anda memiliki {{ auth()->user()->transactions()->where('status', 'pending')->count() }} transaksi tertunda. 
                        <a href="{{ route('buyer.transactions.index') }}">Periksa sekarang</a>.
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-search fs-3" style="color: #4E2E1D;"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Cari Tanah</h5>
                                    <p class="text-muted mb-3">Temukan tanah impian Anda</p>
                                    <a href="{{ route('buyer.lands.index') }}" class="btn elcapo-btn">
                                        <i class="bi bi-search me-2"></i> Mulai Pencarian
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-heart fs-3" style="color: #4E2E1D;"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Favorit</h5>
                                    <p class="text-muted mb-3">Lihat tanah yang Anda simpan ({{ auth()->user()->favoriteLands()->count() }} tanah)</p>
                                    <a href="{{ route('buyer.lands.favorites') }}" class="btn elcapo-btn">
                                        <i class="bi bi-heart me-2"></i> Lihat Favorit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ... di dalam row setelah Favorit ... --}}
                    <div class="col-md-6 mb-4">
                        <div class="card elcapo-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi bi-receipt fs-3" style="color: #4E2E1D;"></i>
                                    </div>
                                </div>
                                <h5 class="mb-2">Transaksi</h5>
                                <p class="text-muted mb-3">Lihat riwayat transaksi Anda</p>
                                <a href="{{ route('buyer.transactions.index') }}" class="btn elcapo-btn">
                                    <i class="bi bi-receipt me-2"></i> Lihat Transaksi
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <h5 class="elcapo-text-brown mb-3"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h5>
                        <div class="list-group">
                            <div class="list-group-item border-0 shadow-sm mb-2 rounded">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><i class="bi bi-arrow-up-right-circle text-warning me-2"></i>Penawaran Tanah di Malang</h6>
                                    <small class="text-muted">2 jam yang lalu</small>
                                </div>
                                <p class="mb-1">Status: <span class="badge bg-warning bg-opacity-25 text-warning">Menunggu respon penjual</span></p>
                                <small class="fw-bold" style="color: #8D6B4F;">Rp 1.250.000.000</small>
                            </div>
                            <div class="list-group-item border-0 shadow-sm rounded">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Tanah di Surabaya telah diverifikasi</h6>
                                    <small class="text-muted">1 hari yang lalu</small>
                                </div>
                                <p class="mb-1">Tanah yang Anda favoritkan sekarang tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection