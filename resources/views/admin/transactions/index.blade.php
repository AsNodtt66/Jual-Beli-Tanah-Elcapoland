@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/btn.css') }}">
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-credit-card me-2"></i>Lihat Transaksi
            </h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-hourglass-split me-2"></i>Transaksi Menunggu Verifikasi</h5>
            @if($pendingTransactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanah</th>
                                <th>Pembeli</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingTransactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->land->title }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $pendingTransactions->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Tidak ada transaksi yang menunggu verifikasi</h5>
                    </div>
                </div>
            @endif

            <hr class="my-4">
            
            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-check-circle me-2"></i>Transaksi Terverifikasi</h5>
            @if($verifiedTransactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanah</th>
                                <th>Pembeli</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifiedTransactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->land->title }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($transaction->escrow_receipt)
                                        <a href="{{ Storage::url($transaction->escrow_receipt) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </a>
                                    @else
                                        <span class="badge bg-warning">Belum ada</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $verifiedTransactions->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Belum ada transaksi terverifikasi</h5>
                    </div>
                </div>
            @endif

            <hr class="my-4">
            
            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-x-circle me-2"></i>Transaksi Ditolak</h5>
            @if($rejectedTransactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanah</th>
                                <th>Pembeli</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rejectedTransactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->land->title }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $rejectedTransactions->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Belum ada transaksi yang ditolak</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection