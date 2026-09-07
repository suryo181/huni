<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Daftar kamar di suatu properti
    public function index($propertyId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);
        $rooms = $property->rooms()->latest()->get();

        return view('owner.rooms.index', compact('property', 'rooms'));
    }

    // Form Tambah Kamar
    public function create($propertyId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);
        return view('owner.rooms.create', compact('property'));
    }

    // Simpan Kamar Baru
    public function store(Request $request, $propertyId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);

        $validated = $request->validate([
            'room_number' => 'required|string|max:50',
            'floor'       => 'required|integer|min:1',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $property->rooms()->create($validated);

        return redirect('/owner/properties/' . $property->id . '/rooms')
            ->with('success', 'Kamar baru berhasil ditambahkan!');
    }

    // Form Edit Kamar
    public function edit($roomId)
    {
        // Memastikan kamar milik properti yang dimilik oleh user yang sedang login
        $room = Room::whereHas('property', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($roomId);

        return view('owner.rooms.edit', compact('room'));
    }

    // Update Data Kamar
    public function update(Request $request, $roomId)
    {
        $room = Room::whereHas('property', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($roomId);

        $validated = $request->validate([
            'room_number' => 'required|string|max:50',
            'floor'       => 'required|integer|min:1',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect('/owner/properties/' . $room->property_id . '/rooms')
            ->with('success', 'Data kamar berhasil diperbarui!');
    }

    // Hapus Kamar
    public function destroy($roomId)
    {
        $room = Room::whereHas('property', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($roomId);

        $propertyId = $room->property_id;
        $room->delete();

        return redirect('/owner/properties/' . $propertyId . '/rooms')
            ->with('success', 'Kamar berhasil dihapus!');
    }
}