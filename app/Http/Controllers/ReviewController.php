<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Izinkan status 'approved' atau 'completed'
        if ($booking->user_id !== auth()->id() || !in_array($booking->status, ['approved', 'completed'])) {
            return back()->with('error', 'Anda tidak dapat memberikan ulasan untuk sewa ini.');
        }

        // Cek apakah booking ini sudah pernah diberi ulasan
        if (Review::where('booking_id', $booking->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk sewa ini.');
        }

        Review::create([
            'booking_id'  => $booking->id,
            'user_id'     => auth()->id(),
            'property_id' => $booking->property_id ?? $booking->room->property_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}