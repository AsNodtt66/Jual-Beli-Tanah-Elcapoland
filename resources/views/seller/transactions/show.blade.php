@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-credit-card me-2"></i>Verifikasi Transaksi #{{ $transaction->id }}</h4>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Informasi Tanah</h5>
                    <p>
                        <strong>Judul:</strong> {{ $transaction->land->title ?? 'N/A' }}<br>
                        <strong>Lokasi:</strong> {{ $transaction->land->location ?? 'N/A' }}<br>
                        <strong>Luas:</strong> {{ $transaction->land->area ?? 'N/A' }} m²<br>
                        <strong>Harga:</strong> Rp {{ number_format($transaction->land->price ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="elcapo-text-brown">Informasi Pembeli</h5>
                    <p>
                        <strong>Nama:</strong> {{ $transaction->buyer->name ?? 'N/A' }}<br>
                        <strong>Email:</strong> {{ $transaction->buyer->email ?? 'N/A' }}<br>
                        <strong>Telepon:</strong> {{ $transaction->buyer->phone ?? 'N/A' }}
                    </p>
                </div>
            </div>
            
            <div class="row mb-4">
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
                    @if($transaction->status === 'pending')
                        <form method="POST" action="{{ route('seller.transactions.verify', $transaction) }}" enctype="multipart/form-data">
                            @csrf
                            <h5 class="elcapo-text-brown mb-3">Verifikasi Pembayaran</h5>
                            
                            <div class="mb-3">
                                <label for="escrow_receipt" class="form-label fw-medium">Upload Sertifikat Digital (PDF)</label>
                                <input class="form-control" type="file" id="escrow_receipt" name="escrow_receipt" accept=".pdf" required>
                                <div class="form-text">
                                    <small>File sertifikat digital setelah pembayaran diverifikasi</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="seller_notes" class="form-label fw-medium">Catatan Penjual</label>
                                <textarea class="form-control @error('seller_notes') is-invalid @enderror" id="seller_notes" name="seller_notes" rows="3"></textarea>
                                @error('seller_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg elcapo-btn">
                                    <i class="bi bi-check-circle me-2"></i> Verifikasi & Kirim Sertifikat
                                </button>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <form method="POST" action="{{ route('seller.transactions.reject', $transaction) }}">
                            @csrf
                            @method('PATCH')
                            <h5 class="elcapo-text-brown mb-3">Tolak Transaksi</h5>
                            
                            <div class="mb-3">
                                <label for="seller_notes" class="form-label fw-medium">Alasan Penolakan</label>
                                <textarea class="form-control" id="seller_notes" name="seller_notes" rows="3" required></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg btn-outline-danger">
                                    <i class="bi bi-x-circle me-2"></i> Tolak Transaksi
                                </button>
                            </div>
                        </form>
                    @else
                        <h5 class="elcapo-text-brown">Status Transaksi</h5>
                        <p>
                            @if($transaction->status === 'verified')
                                <span class="badge bg-success bg-opacity-25 text-success">Terverifikasi</span>
                            @elseif($transaction->status === 'rejected')
                                <span class="badge bg-danger bg-opacity-25 text-danger">Ditolak</span>
                            @elseif($transaction->status === 'completed')
                                <span class="badge bg-primary bg-opacity-25 text-primary">Selesai</span>
                            @endif
                        </p>
                        <h5 class="elcapo-text-brown mt-3">Catatan Penjual</h5>
                        <p>{{ $transaction->seller_notes ?? 'Belum ada catatan' }}</p> <!-- Ubah dari admin_notes -->
                    @endif
                </div>
            </div>
            <!-- Tombol aksi -->
            <div class="mt-4">
                <a href="{{ route('seller.transactions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection