@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-pencil-fill me-2"></i>Edit Pengguna</h4>
        </div>
        
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-4"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label elcapo-text-brown">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label elcapo-text-brown">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label elcapo-text-brown">Peran</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="buyer" {{ old('role', $user->role) === 'buyer' ? 'selected' : '' }}>Pembeli</option>
                        <option value="seller" {{ old('role', $user->role) === 'seller' ? 'selected' : '' }}>Penjual</option>
                    </select>
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label elcapo-text-brown">Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) ?? '' }}">
                    @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label elcapo-text-brown">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="verified" {{ old('status', $user->status) === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="unverified" {{ old('status', $user->status) === 'unverified' ? 'selected' : '' }}>Unverified</option>
                        <option value="rejected" {{ old('status', $user->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection