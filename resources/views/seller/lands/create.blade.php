@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card elcapo-card">
                <div class="elcapo-card-header">
                    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Listing Tanah Baru</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('seller.lands.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-medium">Judul Listing <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-medium">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <small>Masukkan harga dalam rupiah (contoh: 500000000 untuk 500 juta)</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">Deskripsi Lengkap</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-medium">Lokasi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="area" class="form-label fw-medium">Luas Tanah (m²) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-arrows-fullscreen"></i></span>
                                    <input type="number" class="form-control @error('area') is-invalid @enderror" id="area" name="area" step="0.01" value="{{ old('area') }}" required>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Koordinat Lokasi</label>
                            <p class="text-muted small">Buka Google Maps, klik kanan pada lokasi, pilih "What's here?", lalu salin koordinat (contoh: -7.12345678, 112.12345678).</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-geo"></i></span>
                                        <input type="number" step="0.00000001" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="-7.12345678">
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-geo"></i></span>
                                        <input type="number" step="0.00000001" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="112.12345678">
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="certificate_number" class="form-label fw-medium">Nomor Sertifikat <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-file-text"></i></span>
                                <input type="text" class="form-control @error('certificate_number') is-invalid @enderror" id="certificate_number" name="certificate_number" value="{{ old('certificate_number') }}" required>
                                @error('certificate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="certificate-error" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label fw-medium">Foto Tanah (Minimal 1 foto) <span class="text-danger">*</span></label>
                            <input class="form-control @error('images.*') is-invalid @enderror" type="file" id="images" name="images[]" accept="image/*" multiple required>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Unggah foto tanah dari berbagai sudut (maksimal 2MB per foto)</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg elcapo-btn">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Listing
                            </button>
                            <a href="{{ route('seller.lands.index') }}" class="btn btn-lg btn-secondary">
                                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('certificate_number').addEventListener('change', function() {
        const certificateNumber = this.value;
        if (!certificateNumber) return; // Skip check if empty
        fetch('/check-certificate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ certificate_number: certificateNumber }),
        })
        .then(response => response.json())
        .then(data => {
            const errorDiv = document.getElementById('certificate-error');
            if (data.exists) {
                this.classList.add('is-invalid');
                errorDiv.textContent = 'Nomor sertifikat sudah digunakan.';
            } else {
                this.classList.remove('is-invalid');
                errorDiv.textContent = '';
            }
        })
        .catch(error => console.error('Error:', error));
    });

    @if (session('success'))
        showCustomNotification("{{ session('success') }}", 'success');
    @elseif (session('error'))
        showCustomNotification("{{ session('error') }}", 'error');
    @endif
</script>
@endsection
