<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicKosController extends Controller
{
    // Halaman Utamanya / Beranda (welcome)
    public function home()
    {
        // Ambil maksimal 6 kos aktif & sudah bayar langganan
        $properties = Property::where('status', 'active')
            ->whereHas('subscriptions', function ($q) {
                $q->where('status', 'paid')
                  ->where('ends_at', '>=', now());
            })
            ->has('rooms')
            ->has('photos')
            ->with(['photos', 'rooms', 'reviews'])
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('properties'));
    }

    // Halaman Pencarian & Daftar Kos Publik (/kos)
    public function index(Request $request)
    {
        // Hanya ambil kos yang aktif, punya kamar, foto, dan langganan masih berlaku
        $query = Property::where('status', 'active')
            ->whereHas('subscriptions', function ($q) {
                $q->where('status', 'paid')
                  ->where('ends_at', '>=', now());
            })
            ->has('rooms')
            ->has('photos')
            ->with(['photos', 'rooms', 'reviews']);

        // Filter Lokasi / Nama
        $searchTerm = $request->search ?? $request->location;
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%")
                  ->orWhere('district', 'like', "%{$searchTerm}%")
                  ->orWhere('address', 'like', "%{$searchTerm}%");
            });
        }

        // Filter Tipe Kos
        if ($request->filled('gender_type')) {
            $query->where('gender_type', $request->gender_type);
        }

        // Filter Maksimal Harga
        if ($request->filled('max_price')) {
            $maxPrice = (int) $request->max_price;
            $query->whereHas('rooms', function ($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            });
        }

        $properties = $query->latest()->paginate(9);

        return view('kos.index', compact('properties'));
    }

    // Halaman Detail Kos (/kos/{slug})
    public function show($slug)
    {
        $query = Property::where('slug', $slug)
            ->with(['photos', 'rooms.bookings', 'user', 'reviews.user']);

        // Jika BUKAN Admin atau Pemilik Kos terkait, wajib berstatus active
        if (!auth()->check() || (auth()->user()->role !== 'admin' && auth()->user()->id !== Property::where('slug', $slug)->value('user_id'))) {
            $query->where('status', 'active')
                  ->has('rooms')
                  ->has('photos');
        }

        $property = $query->firstOrFail();

        return view('kos.show', compact('property'));
    }

    // Halaman Tentang Kami (/tentang-kami)
    public function about()
    {
        return view('about');
    }

    // Halaman Kebijakan Privasi
    public function privacy()
    {
        return view('policy');
    }

    // Halaman Syarat dan Ketentuan
    public function terms()
    {
        return view('policy');
    }
}

