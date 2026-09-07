<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Notifications\NewBookingNotification;

class BookingController extends Controller
{
    public function create($roomId)
    {
        $room = Room::with(['property.photos'])->findOrFail($roomId);
        return view('tenant.bookings.create', compact('room'));
    }

    public function store(Request $request, $roomId)
    {
        // Load relasi property dan user (owner) sekaligus
        $room = Room::with('property.user')->findOrFail($roomId);

        $request->validate([
            'start_date'   => 'required|date|after_or_equal:today',
            'duration'     => 'required|integer|min:1',
            'phone_number' => 'required|string|max:20',
            'gender'       => 'required|in:Laki-laki,Perempuan',
            'occupation'   => 'required|string|max:50',
            'notes'        => 'nullable|string|max:255',
        ]);

        $totalPrice = $room->price * $request->duration;

        $booking = Booking::create([
            'user_id'         => auth()->id(),
            'property_id'     => $room->property_id,
            'room_id'         => $room->id,
            'start_date'      => $request->start_date,
            'duration_months' => $request->duration,
            'total_price'     => $totalPrice,
            'phone_number'    => $request->phone_number,
            'gender'          => $request->gender,
            'occupation'      => $request->occupation,
            'status'          => 'pending',
            'notes'           => $request->notes,
        ]);

        // Kirim notifikasi ke pemilik kos
        $owner = $room->property->user;
        if ($owner) {
            $owner->notify(new NewBookingNotification($booking));
        }

        return redirect('/my-bookings')->with('success', 'Pengajuan sewa berhasil dikirim! Menunggu konfirmasi pemilik.');
    }

    public function myBookings()
    {
        Booking::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->where('start_date', '<', now()->toDateString())
            ->update(['status' => 'cancelled']);

        $bookings = Booking::where('user_id', auth()->id())
            ->with(['property.user', 'room.property'])
            ->latest()
            ->get();

        return view('tenant.bookings', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Pengajuan sewa berhasil dibatalkan.');
    }
}