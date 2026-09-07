<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPropertyController extends Controller
{
    // Dashboard Admin & Daftar Semua Properti + Pengguna
    public function index()
    {
        // 1. Data Properti
        $properties = Property::with(['user', 'photos', 'rooms'])
            ->latest()
            ->paginate(10);

        $totalProperties = Property::count();
        $pendingProperties = Property::where('status', 'pending_review')->count();
        $activeProperties = Property::where('status', 'active')->count();

        // 2. Data Pengguna Web (Baru Ditambahkan)
        $users = User::latest()->get();
        $totalUsers = $users->count();
        $totalOwners = $users->where('role', 'owner')->count();
        $totalTenants = $users->where('role', 'tenant')->count();

        return view('admin.dashboard', compact(
            'properties', 
            'totalProperties', 
            'pendingProperties', 
            'activeProperties',
            'users',
            'totalUsers',
            'totalOwners',
            'totalTenants'
        ));
    }

    // Update Status Verifikasi (Active / Rejected / Inactive)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,rejected,inactive',
        ]);

        $property = Property::findOrFail($id);
        $property->update([
            'status' => $request->status,
        ]);

        $statusLabel = [
            'active' => 'disetujui dan ditayangkan',
            'rejected' => 'ditolak',
            'inactive' => 'dinonaktifkan',
        ];

        return back()->with('success', "Properti {$property->name} berhasil {$statusLabel[$request->status]}!");
    }

    // Hapus Properti Kos oleh Admin
public function destroy($id)
{
    $property = Property::findOrFail($id);
    $property->delete();

    return back()->with('success', "Properti {$property->name} berhasil dihapus dari platform!");
}
}