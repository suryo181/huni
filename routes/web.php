<?php

use Illuminate\Support\Facades\Route;
use App\Models\Property;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PublicKosController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\RoomController;
use App\Http\Controllers\Owner\PropertyPhotoController;
use App\Http\Controllers\Owner\OwnerBookingController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $properties = Property::where('status', 'active')
        ->has('rooms')
        ->has('photos')
        ->with(['photos', 'rooms'])
        ->latest()
        ->take(6)
        ->get();

    return view('welcome', compact('properties'));
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/tentang-kami', [App\Http\Controllers\PublicKosController::class, 'about']);
Route::get('/kebijakan-privasi', [App\Http\Controllers\PublicKosController::class, 'privacy']);
Route::get('/syarat-dan-ketentuan', [App\Http\Controllers\PublicKosController::class, 'terms']);

// Public Search & Detail Kos
Route::get('/kos', [PublicKosController::class, 'index'])->name('kos.index');
Route::get('/kos/{slug}', [PublicKosController::class, 'show'])->name('kos.show');

/*
|--------------------------------------------------------------------------
| Tenant / Pencari Kos Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/rooms/{roomId}/book', [BookingController::class, 'create']);
    Route::post('/rooms/{roomId}/book', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::patch('/my-bookings/{id}/cancel', [BookingController::class, 'cancel']);
    
    // Ulasan / Review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Notifikasi
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect($notification->data['url'] ?? '/owner/bookings');
    });
});

/*
|--------------------------------------------------------------------------
| Owner Routes (Khusus Pemilik Kos)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    // Dashboard & CRUD Properti Kos
    Route::get('/dashboard', [PropertyController::class, 'dashboard']);
    Route::get('/properties/create', [PropertyController::class, 'create']);
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    Route::post('/properties/{id}/submit', [PropertyController::class, 'submitForReview']);

    // Manajemen Kamar
    Route::get('/properties/{propertyId}/rooms', [RoomController::class, 'index']);
    Route::get('/properties/{propertyId}/rooms/create', [RoomController::class, 'create']);
    Route::post('/properties/{propertyId}/rooms', [RoomController::class, 'store']);
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit']);
    Route::put('/rooms/{room}', [RoomController::class, 'update']);
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy']);

    // Manajemen Foto Properti
    Route::get('/properties/{propertyId}/photos', [PropertyPhotoController::class, 'index']);
    Route::post('/properties/{propertyId}/photos', [PropertyPhotoController::class, 'store']);
    Route::delete('/properties/{propertyId}/photos/{photoId}', [PropertyPhotoController::class, 'destroy']);

    // Kelola Pengajuan Sewa Masuk (Owner Booking)
    Route::get('/bookings', [OwnerBookingController::class, 'index']);
    Route::patch('/bookings/{id}/status', [OwnerBookingController::class, 'updateStatus']);
    Route::patch('/bookings/{id}/complete', [OwnerBookingController::class, 'complete']);

    // Langganan
    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::post('/subscriptions/{propertyId}/pay', [SubscriptionController::class, 'pay']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Khusus Moderasi Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminPropertyController::class, 'index'])->name('admin.dashboard');
    Route::patch('/properties/{id}/status', [AdminPropertyController::class, 'updateStatus'])->name('admin.properties.status');
    Route::delete('/properties/{id}', [AdminPropertyController::class, 'destroy'])->name('admin.properties.destroy');
});