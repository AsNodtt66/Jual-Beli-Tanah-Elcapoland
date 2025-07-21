@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card elcapo-card">
        <div class="elcapo-card-header">
            <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Transaksi</h4>
        </div>
        
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanah</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->land->title }}</td>
                                <td style="color: #8D6B4F;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($transaction->status === 'pending')
                                        <span class="badge bg-warning bg-opacity-25 text-warning">Menunggu</span>
                                    @elseif($transaction->status === 'verified')
                                        <span class="badge bg-success bg-opacity-25 text-success">Sukses</span>
                                    @elseif($transaction->status === 'rejected')
                                        <span class="badge bg-danger bg-opacity-25 text-danger">Ditolak</span>
                                    @elseif($transaction->status === 'completed')
                                        <span class="badge bg-primary bg-opacity-25 text-primary">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('buyer.transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h5 class="mb-1">Belum ada transaksi</h5>
                        <p class="mb-0">Mulai temukan tanah impian Anda dan lakukan transaksi</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection