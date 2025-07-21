<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TransactionRejectedNotification extends Notification
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
            'title' => 'Transaksi Anda Ditolak',
            'message' => "Transaksi untuk tanah {$this->transaction->land->title} ditolak. Alasan: " . ($this->transaction->seller_notes ?? 'Tidak ada alasan yang diberikan'),
        ];
    }
}