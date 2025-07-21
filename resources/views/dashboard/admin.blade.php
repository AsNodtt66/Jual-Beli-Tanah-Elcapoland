@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card elcapo-card">
                <div class="elcapo-card-header">
                    <h4 class="mb-0"><i class="bi bi-shield-check me-2"></i>Dashboard Admin</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="elcapo-text-brown">Selamat datang, {{ $user->name }}!</h3>
                        <p class="text-muted">Anda login sebagai <strong class="text-success">Admin</strong></p>
                    </div>
                    <!-- Tambahkan di layouts/app.blade.php atau admin dashboard -->
                    <div class="container">
                        <h5 class="elcapo-text-brown mb-3"><i class="bi bi-bell me-2"></i>Notifikasi</h5>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <div class="list-group">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                            <p class="mb-0">{{ $notification->data['message'] }}</p>
                                            @if(isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}" class="btn btn-sm elcapo-btn mt-2">
                                                    <i class="bi bi-eye me-1"></i> Lihat Detail
                                                </a>
                                            @endif
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary mark-as-read" data-id="{{ $notification->id }}">
                                            Tandai sebagai Dibaca
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada notifikasi baru.
                            </div>
                        @endif
                    </div>

                    @push('scripts')
                    <script>
                        document.querySelectorAll('.mark-as-read').forEach(button => {
                            button.addEventListener('click', function() {
                                const notificationId = this.getAttribute('data-id');
                                fetch('/notifications/mark-as-read/' + notificationId, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                }).then(response => {
                                    if (response.ok) {
                                        this.closest('.list-group-item').remove();
                                    }
                                });
                            });
                        });
                    </script>
                    @endpush
                    
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-people fs-3" style="color: #4E2E1D;"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Total Pengguna</h5>
                                    <h3 class="mb-3">{{ $userCount }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-house-check fs-3" style="color: #4E2E1D;"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Tanah Terverifikasi</h5>
                                    <h3 class="mb-3">{{ $verifiedLandCount }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card elcapo-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="rounded-circle bg-light p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-hourglass-split fs-3" style="color: #4E2E1D;"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Perlu Verifikasi</h5>
                                    <h3 class="mb-3">{{ $unverifiedLandCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <a href="{{ route('admin.lands.index') }}" class="btn btn-lg elcapo-btn">
                            <i class="bi bi-clipboard-check me-2"></i> Verifikasi Listing Tanah
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-lg btn-outline-success">
                            <i class="bi bi-people me-2"></i> Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-lg elcapo-btn">
                            <i class="bi bi-credit-card me-2"></i> Lihat Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection