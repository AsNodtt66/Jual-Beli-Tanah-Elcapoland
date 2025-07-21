@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-credit-card me-2"></i>Pembayaran untuk Tanah: {{ $land->title }}</h4>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Detail Tanah</h5>
                            <p class="card-text">
                                <strong>Lokasi:</strong> {{ $land->location }}<br>
                                <strong>Luas:</strong> {{ $land->area }} m²<br>
                                <strong>Harga:</strong> Rp {{ number_format($land->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Instruksi Pembayaran</h5>
                            <ol>
                                <li>Transfer ke rekening escrow: <strong>BCA 1234567890 (ELCAPO LAND ESCROW)</strong></li>
                                <li>Jumlah yang harus dibayar: <strong>Rp {{ number_format($land->price, 0, ',', '.') }}</strong></li>
                                <li>Unggah bukti transfer pada form di samping.</li>
                                <li>Admin akan memverifikasi pembayaran Anda.</li>
                                <li>Setelah verifikasi, sertifikat digital akan dikirimkan.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                <form method="POST" action="{{ route('buyer.transactions.store', $land) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="payment_proof" class="form-label fw-medium">Bukti Pembayaran</label>
                        <input class="form-control @error('payment_proof') is-invalid @enderror" type="file" id="payment_proof" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <small>Format: JPG, PNG, PDF (maks. 2MB)</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg elcapo-btn">
                            <i class="bi bi-send-check me-2"></i> Kirim Bukti Pembayaran
                        </button>
                        <a href="{{ route('buyer.lands.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                        </a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection