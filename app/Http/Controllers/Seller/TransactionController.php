<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TransactionVerifiedNotification;
use App\Notifications\TransactionRejectedNotification;

class TransactionController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Unauthorized action.');
        }

        $pendingTransactions = Transaction::with(['land', 'buyer'])
            ->whereHas('land', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->paginate(10);

        $verifiedTransactions = Transaction::with(['land', 'buyer'])
            ->whereHas('land', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'verified')
            ->paginate(10);

        $rejectedTransactions = Transaction::with(['land', 'buyer'])
            ->whereHas('land', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'rejected')
            ->paginate(10);

        return view('seller.transactions.index', compact(
            'pendingTransactions',
            'verifiedTransactions',
            'rejectedTransactions'
        ));
    }

    public function show(Transaction $transaction)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $transaction->land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.transactions.show', compact('transaction'));
    }

    public function verify(Request $request, Transaction $transaction)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $transaction->land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'escrow_receipt' => 'required|file|mimes:pdf|max:2048|extensions:pdf',
            'seller_notes' => 'nullable|string|max:1000', // Ubah dari admin_notes
        ]);

        // Simpan sertifikat digital
        $escrowPath = $request->file('escrow_receipt')->store('escrow_receipts', 'public');

        // Update transaksi dan ubah status tanah menjadi sold
        $transaction->update([
            'status' => 'verified',
            'escrow_receipt' => $escrowPath,
            'seller_notes' => $request->input('seller_notes'), // Ubah dari admin_notes
        ]);

        $transaction->land->update(['status' => 'sold']);

        // Kirim notifikasi ke pembeli
        $transaction->buyer->notify(new TransactionVerifiedNotification($transaction));

        // Kirim notifikasi ke semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\TransactionStatusUpdatedNotification($transaction, 'Terverifikasi'));
        }

        return redirect()->route('seller.transactions.index')
            ->with('success', 'Transaksi berhasil diverifikasi dan sertifikat telah dikirim.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $transaction->land->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'seller_notes' => 'required|string|max:1000', // Ubah dari admin_notes
        ]);

        // Kembalikan status tanah menjadi available
        $transaction->land->update(['status' => 'available']);

        $transaction->update([
            'status' => 'rejected',
            'seller_notes' => $request->input('seller_notes'), // Ubah dari admin_notes
        ]);

        // Kirim notifikasi ke pembeli
        $transaction->buyer->notify(new TransactionRejectedNotification($transaction));

        // Kirim notifikasi ke semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\TransactionStatusUpdatedNotification($transaction, 'Ditolak'));
        }

        return redirect()->route('seller.transactions.index')->with('success', 'Transaksi berhasil ditolak.');
    }
}