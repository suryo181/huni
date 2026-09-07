<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // Halaman daftar tagihan langganan untuk Owner
    public function index()
    {
        $ownerId = auth()->id();
        
        // Ambil semua properti milik owner beserta riwayat langganannya
        $properties = Property::where('user_id', $ownerId)
            ->with(['subscriptions' => function($q) {
                $q->latest();
            }])
            ->get();

        return view('owner.subscriptions.index', compact('properties'));
    }

    // Simulasi Pembayaran Langganan Rp 50.000 (1 Bulan)
    public function pay(Request $request, $propertyId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);

        // Hitung masa aktif (jika masih ada sisa langganan, tambahkan dari tanggal expired terakhir)
        $lastSubscription = Subscription::where('property_id', $property->id)
            ->where('status', 'paid')
            ->where('ends_at', '>', now())
            ->latest()
            ->first();

        $startDate = $lastSubscription ? Carbon::parse($lastSubscription->ends_at) : now();
        $endDate = $startDate->copy()->addMonth();

        Subscription::create([
            'property_id' => $property->id,
            'user_id'     => auth()->id(),
            'amount'      => 50000.00,
            'status'      => 'paid', // Dapat diintegrasikan ke Midtrans/Gateway kelak
            'starts_at'   => $startDate,
            'ends_at'     => $endDate,
        ]);

        return back()->with('success', "Pembayaran langganan untuk {$property->name} sebesar Rp 50.000 berhasil! Masa aktif sampai " . $endDate->format('d M Y'));
    }
}