@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
    <div class="card elcapo-card">
         <div class="elcapo-card-header">
                    <h4 class="mb-0"><i class="bi bi-shop me-2"></i>Dashboard Penjual</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="elcapo-text-brown">Selamat datang, {{ $user->name }}!</h3>
                        <p class="text-muted">Anda login sebagai <strong class="text-primary">Penjual</strong></p>
                    </div>
        <div class="alert alert-info">
            Anda memiliki {{ \App\Models\Transaction::whereHas('land', function ($query) { $query->where('user_id', auth()->id()); })->where('status', 'pending')->count() }} transaksi untuk diverifikasi. 
            <a href="{{ route('seller.transactions.index') }}">Periksa sekarang</a>.
        </div>
        <div class="card-body">
            <div class="d-grid gap-2 mb-4">
                <a href="{{ route('seller.lands.create') }}" class="btn elcapo-btn">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Listing Baru
                </a>
            </div>

            @if($lands->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lands as $land)
                            <tr>
                                <td>{{ $land->title }}</td>
                                <td>{{ $land->location }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($land->price, 0, ',', '.') }}</td>
                                <td>
                                    @if($land->verified)
                                        <span class="badge bg-success bg-opacity-25 text-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-25 text-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('seller.lands.edit', $land) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('seller.lands.destroy', $land) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger me-1">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                    <a href="{{ route('seller.transactions.index') }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-credit-card me-1"></i> Transaksi
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $lands->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-1">Belum ada listing tanah</h5>
                        <p class="mb-0">Silakan tambahkan listing baru untuk mulai menjual tanah Anda</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
@endsection