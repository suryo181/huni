<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    // Dashboard Owner
    public function dashboard()
{
    $ownerId = auth()->id();
    
    // Ambil semua properti milik owner beserta relasi kamar dan foto
    $properties = Property::where('user_id', $ownerId)
        ->with(['rooms', 'photos'])
        ->latest()
        ->get();

    $totalProperties = $properties->count();

    // Hitung Total Tipe Kamar yang dimiliki Owner (berdasarkan jumlah record data kamar)
    $totalRooms = Room::whereHas('property', function ($q) use ($ownerId) {
        $q->where('user_id', $ownerId);
    })->count();

    // Hitung Jumlah Pengajuan Sewa Masuk (Pending)
    $pendingBookingsCount = Booking::whereHas('property', function ($q) use ($ownerId) {
        $q->where('user_id', $ownerId);
    })->where('status', 'pending')->count();

    // Hitung Jumlah Kamar yang Sudah Disetujui / Terisi
    $approvedBookingsCount = Booking::whereHas('property', function ($q) use ($ownerId) {
        $q->where('user_id', $ownerId);
    })->where('status', 'approved')->count();

    // Kamar Kosong = Total Kamar dikurangi Kamar Terisi
    $vacantRoomsCount = max(0, $totalRooms - $approvedBookingsCount);

    return view('owner.dashboard', compact(
        'totalProperties',
        'properties',
        'totalRooms',
        'pendingBookingsCount',
        'approvedBookingsCount',
        'vacantRoomsCount'
    ));
}

    // Form Tambah Properti
    public function create()
    {
        return view('owner.properties.create');
    }

    // Simpan Properti Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender_type' => 'required|in:putra,putri,campur',
            'address' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'contact_number' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($request->name) . '-' . time();
        $validated['status'] = 'draft'; // Status awal draft sebelum disubmit ke admin

        $property = Property::create($validated);

        // Langsung alihkan ke halaman tambah kamar dulu
        return redirect('/owner/properties/' . $property->id . '/rooms')
            ->with('success', 'Informasi kos berhasil dibuat! Sekarang silakan tambahkan minimal 1 tipe kamar.');
    }

    // Method untuk submit ke admin saat data sudah lengkap
    public function submitForReview($id)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($id);

        if ($property->rooms->count() == 0) {
            return back()->with('error', 'Gagal mengajukan! Anda harus menambahkan minimal 1 unit kamar.');
        }

        if ($property->photos->count() == 0) {
            return back()->with('error', 'Gagal mengajukan! Anda harus mengunggah minimal 1 foto kos.');
        }

        $property->update(['status' => 'pending_review']);

        return redirect('/owner/dashboard')
            ->with('success', 'Kos berhasil diajukan ke admin untuk diverifikasi!');
    }

    // Tampilkan Form Edit Kos
public function edit($id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);
    return view('owner.properties.edit', compact('property'));
}

// Proses Update Data Kos
public function update(Request $request, $id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'gender_type' => 'required|in:putra,putri,campur',
        'contact_number' => 'required|string|max:20',
        'city' => 'required|string|max:100',
        'district' => 'required|string|max:100',
        'address' => 'required|string',
        'description' => 'required|string',
        'rules' => 'nullable|string',
    ]);

    $property->update([
        'name' => $request->name,
        'gender_type' => $request->gender_type,
        'contact_number' => $request->contact_number,
        'city' => $request->city,
        'district' => $request->district,
        'address' => $request->address,
        'description' => $request->description,
        'rules' => $request->rules,
    ]);

    return redirect('/owner/dashboard')->with('success', "Data kos {$property->name} berhasil diperbarui!");
}

// Hapus Kos oleh Pemilik
public function destroy($id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);
    $name = $property->name;
    $property->delete();

    return back()->with('success', "Kos {$name} berhasil dihapus!");
}

}