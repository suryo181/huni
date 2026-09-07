<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class NewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'title'      => 'Pengajuan Sewa Baru!',
            'message'    => $this->booking->user->name . ' mengajukan sewa untuk ' . ($this->booking->room->property->name ?? 'Kos Anda'),
            'url'        => '/owner/bookings',
        ];
    }
}