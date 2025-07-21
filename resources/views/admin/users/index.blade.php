@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/btn.css') }}">
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>Kelola Pengguna
            </h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="card-body">
            <h5 class="elcapo-text-brown mb-3"><i class="bi bi-list-ul me-2"></i>Daftar Pengguna</h5>
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->status === 'verified' ? 'success' : 'danger' }} bg-opacity-25 text-{{ $user->status === 'verified' ? 'success' : 'danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-0">Tidak ada pengguna yang ditemukan</h5>
                    </div>
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

    /* Styling untuk notifikasi */
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