<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function create(Land $land)
    {
        if (!Auth::check() || !Auth::user()->isBuyer()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$land->verified) {
            abort(404, 'Tanah tidak tersedia untuk transaksi.');
        }

        // Periksa apakah ada transaksi pending atau in_negotiation untuk tanah ini
        $existingTransaction = Transaction::where('land_id', $land->id)
            ->whereIn('status', ['pending', 'in_negotiation'])
            ->exists();
        if ($land->status === 'sold' || $existingTransaction) {
            abort(400, 'Tanah ini sedang dalam proses transaksi lain atau sudah terjual.');
        }

        return view('buyer.transactions.create', compact('land'));
    }

    public function store(Request $request, Land $land)
    {
        if (!Auth::check() || !Auth::user()->isBuyer()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048|extensions:jpg,jpeg,png,pdf',
        ]);

        try {
            // Simpan bukti pembayaran
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

            // Buat transaksi dan ubah status tanah menjadi in_negotiation
            $transaction = Transaction::create([
                'land_id' => $land->id,
                'buyer_id' => Auth::id(),
                'amount' => $land->price,
                'status' => 'pending',
                'payment_proof' => $paymentProofPath,
            ]);

            $land->update(['status' => 'in_negotiation']);

            // Kirim notifikasi ke semua admin
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewTransactionNotification($transaction));
            }

            return redirect()->route('buyer.transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil dibuat. Menunggu verifikasi penjual.');
        } catch (\Exception $e) {
            Log::error('Error creating transaction: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat transaksi. Cek log untuk detail.')->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        if (!Auth::check() || !Auth::user()->isBuyer() || $transaction->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('buyer.transactions.show', compact('transaction'));
    }

    public function index()
    {
        if (!Auth::check() || !Auth::user()->isBuyer()) {
            abort(403, 'Unauthorized action.');
        }

        $transactions = Auth::user()->transactions()->with('land')->paginate(10);
        return view('buyer.transactions.index', compact('transactions'));
    }

    public function downloadCertificate(Transaction $transaction)
    {
        if (!Auth::check() || !Auth::user()->isBuyer() || $transaction->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$transaction->escrow_receipt) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        try {
            return Storage::download($transaction->escrow_receipt);
        } catch (\Exception $e) {
            Log::error('Error downloading certificate: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengunduh sertifikat. Cek log untuk detail.');
        }
    }
}