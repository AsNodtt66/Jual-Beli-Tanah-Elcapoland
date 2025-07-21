<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewTransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'title' => 'Transaksi Baru Dibuat',
            'message' => "Transaksi baru untuk tanah {$this->transaction->land->title} dari pembeli {$this->transaction->buyer->name} menunggu verifikasi.",
            'url' => route('admin.transactions.show', $this->transaction),
        ];
    }
}