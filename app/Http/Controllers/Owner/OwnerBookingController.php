<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Property;

class OwnerBookingController extends Controller
{
    public function index()
    {
        $propertyIds = Property::where('user_id', auth()->id())->pluck('id');

        $bookings = Booking::whereIn('property_id', $propertyIds)
            ->with(['user', 'room', 'property'])
            ->latest()
            ->get();

        return view('owner.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::with('property')->findOrFail($id);

        if ($booking->property->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        $statusText = $request->status == 'approved' ? 'disetujui' : 'ditolak';

        return back()->with('success', "Pengajuan sewa berhasil {$statusText}!");
    }

    // Method untuk menandai penyewa sudah keluar / selesai sewa lebih awal
    public function complete($id)
    {
        $booking = Booking::with('property')->findOrFail($id);

        // Pastikan booking milik properti owner yang sedang login
        if ($booking->property->user_id !== auth()->id()) {
            abort(403);
        }

        // Ubah status booking menjadi completed (selesai)
        $booking->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Sewa berhasil diselesaikan! Kamar kini siap disewakan kembali.');
    }
}