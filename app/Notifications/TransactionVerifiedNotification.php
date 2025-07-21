<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TransactionVerifiedNotification extends Notification
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
            'title' => 'Transaksi Anda Telah Diverifikasi',
            'message' => "Transaksi untuk tanah {$this->transaction->land->title} telah diverifikasi. Unduh sertifikat digital Anda.",
            'certificate_url' => route('buyer.transactions.download', $this->transaction),
        ];
    }
}
