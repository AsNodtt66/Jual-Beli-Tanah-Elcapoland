<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TransactionStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;
    public $status;

    public function __construct($transaction, $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'title' => "Transaksi {$this->status}",
            'message' => "Transaksi untuk tanah {$this->transaction->land->title} telah {$this->status} oleh penjual {$this->transaction->land->user->name}.",
            'url' => route('admin.transactions.show', $this->transaction),
        ];
    }
}