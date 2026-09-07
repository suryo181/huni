<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyPhotoController extends Controller
{
    public function index($propertyId)
    {
        // Pastikan hanya pemilik kos terkait yang bisa membuka galeri fotonya
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);
        
        // Ambil semua foto milik properti ini
        $photos = $property->photos;

        // Kirim $property dan $photos ke view
        return view('owner.properties.photos', compact('property', 'photos'));
    }

    public function store(Request $request, $propertyId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');

            // Set foto pertama otomatis jadi foto utama (is_primary = true)
            $isPrimary = $property->photos()->count() === 0;

            PropertyPhoto::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_primary' => $isPrimary,
            ]);
        }

        return redirect()->back()->with('success', 'Foto berhasil diunggah!');
    }

    public function destroy($propertyId, $photoId)
    {
        $property = Property::where('user_id', auth()->id())->findOrFail($propertyId);
        $photo = PropertyPhoto::where('property_id', $property->id)->findOrFail($photoId);

        // Hapus file dari penyimpanan
        if (Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        // Jika foto yang dihapus adalah foto utama, set foto berikutnya yang tersisa jadi utama
        if ($photo->is_primary) {
            $nextPhoto = $property->photos()->first();
            if ($nextPhoto) {
                $nextPhoto->update(['is_primary' => true]);
            }
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }
}