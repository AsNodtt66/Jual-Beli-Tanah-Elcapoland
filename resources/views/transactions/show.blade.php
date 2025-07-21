@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-receipt me-2"></i>Detail Transaksi #{{ $transaction->id }}</h4>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Informasi Tanah</h5>
                    <p>
                        <strong>Judul:</strong> {{ $transaction->land->title }}<br>
                        <strong>Lokasi:</strong> {{ $transaction->land->location }}<br>
                        <strong>Luas:</strong> {{ $transaction->land->area }} m²<br>
                        <strong>Harga:</strong> Rp {{ number_format($transaction->land->price, 0, ',', '.') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Status Transaksi</h5>
                    <p>
                        @if($transaction->status === 'pending')
                            <span class="badge bg-warning bg-opacity-25 text-warning">Menunggu Verifikasi</span>
                        @elseif($transaction->status === 'verified')
                            <span class="badge bg-success bg-opacity-25 text-success">Terverifikasi</span>
                        @elseif($transaction->status === 'rejected')
                            <span class="badge bg-danger bg-opacity-25 text-danger">Ditolak</span>
                        @elseif($transaction->status === 'completed')
                            <span class="badge bg-primary bg-opacity-25 text-primary">Selesai</span>
                        @endif
                    </p>
                    
                    @if($transaction->status === 'verified' && $transaction->escrow_receipt)
                        <div class="mt-3">
                            <a href="{{ Storage::url($transaction->escrow_receipt) }}" target="_blank" class="btn elcapo-btn">
                                <i class="bi bi-download me-2"></i> Unduh Sertifikat Digital
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Bukti Pembayaran</h5>
                    @if($transaction->payment_proof)
                        <a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank">
                            <img src="{{ Storage::url($transaction->payment_proof) }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 300px;" class="img-thumbnail">
                        </a>
                    @else
                        <p>Tidak ada bukti pembayaran</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Catatan Admin</h5>
                    <p>{{ $transaction->admin_notes ?? 'Belum ada catatan' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection