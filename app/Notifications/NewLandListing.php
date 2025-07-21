<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewLandListing extends Notification implements ShouldQueue
{
    use Queueable;

    public $land;

    public function __construct($land)
    {
        $this->land = $land;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'land_id' => $this->land->id,
            'title' => 'Listing Tanah Baru Menunggu Verifikasi',
            'message' => "Listing tanah baru dari {$this->land->user->name} menunggu verifikasi. Judul: {$this->land->title}, Lokasi: {$this->land->location}.",
            'url' => route('admin.lands.show', $this->land),
        ];
    }
}