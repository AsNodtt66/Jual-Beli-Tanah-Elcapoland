<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $pendingTransactions = Transaction::with(['land', 'buyer'])
            ->where('status', 'pending')
            ->paginate(10);

        $verifiedTransactions = Transaction::with(['land', 'buyer'])
            ->where('status', 'verified')
            ->paginate(10);

        $rejectedTransactions = Transaction::with(['land', 'buyer'])
            ->where('status', 'rejected')
            ->paginate(10);

        return view('admin.transactions.index', compact(
            'pendingTransactions',
            'verifiedTransactions',
            'rejectedTransactions'
        ));
    }

    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }
}