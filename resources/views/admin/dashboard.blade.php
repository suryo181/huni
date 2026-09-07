@extends('layouts.app')

@section('content')
<div class="container py-4" style="min-height: calc(100vh - 180px);">
    <!-- Top Bar Header -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Panel Moderasi Admin</h3>
        <p class="text-muted small mb-0">Verifikasi pengajuan kos baru dari Pemilik serta pantau seluruh pengguna terdaftar di platform HUNI.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Row 1: Stat Summary Cards Properti -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Properti</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalProperties }}</h2>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle text-secondary">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Menunggu Verifikasi</span>
                        <h2 class="fw-bold text-warning mt-1 mb-0">{{ $pendingProperties }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Terverifikasi Aktif</span>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $activeProperties }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="bi bi-patch-check-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Ringkasan Pengguna Web -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Pengguna</span>
                        <h2 class="fw-bold text-primary mt-1 mb-0">{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Pemilik Kos (Owner)</span>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $totalOwners ?? 0 }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="bi bi-person-badge-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Pencari Kos (Tenant)</span>
                        <h2 class="fw-bold text-info mt-1 mb-0">{{ $totalTenants ?? 0 }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                        <i class="bi bi-person-search fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table Card 1: Daftar Pengajuan Kos -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-house-door me-2 text-success"></i>Daftar Pengajuan Kos</h5>
        </div>
        <div class="card-body p-0">
            @if($properties->isEmpty())
                <div class="text-center py-5 px-3">
                    <p class="text-muted mb-0">Belum ada pendaftaran properti kos di platform.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Properti Kos</th>
                                <th>Pemilik (Owner)</th>
                                <th>Lokasi</th>
                                <th>Status Saat Ini</th>
                                <th class="text-end pe-4">Aksi Verifikasi & Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $property)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark fs-6">{{ $property->name }}</div>
                                        <small class="text-muted">
                                            {{ ucfirst($property->gender_type) }} • 
                                            <span class="{{ $property->photos->count() == 0 ? 'text-danger fw-semibold' : '' }}">
                                                <i class="bi bi-image"></i> {{ $property->photos->count() }} Foto
                                            </span> • 
                                            <span class="{{ $property->rooms->count() == 0 ? 'text-danger fw-semibold' : '' }}">
                                                <i class="bi bi-door-closed"></i> {{ $property->rooms->count() }} Kamar
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $property->user->name }}</div>
                                        <small class="text-muted">{{ $property->contact_number }}</small>
                                    </td>
                                    <td>
                                        <div class="text-dark small fw-semibold">{{ $property->district }}</div>
                                        <small class="text-muted">{{ $property->city }}</small>
                                    </td>
                                    <td>
                                        @if($property->status == 'active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                                Active
                                            </span>
                                        @elseif($property->status == 'pending_review')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                                Pending Review
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                                                Nonaktif / Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1">
                                            <!-- Preview -->
                                            <a href="/kos/{{ $property->slug }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                Preview
                                            </a>

                                            <!-- Setujui -->
                                            <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-sm btn-success fw-semibold" {{ $property->status == 'active' ? 'disabled' : '' }}>
                                                    Setujui
                                                </button>
                                            </form>

                                            <!-- Tolak -->
                                            <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Tolak properti kos ini?')" {{ $property->status == 'rejected' ? 'disabled' : '' }}>
                                                    Tolak
                                                </button>
                                            </form>

                                            <!-- Tombol Hapus Permanen -->
                                            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus permanen kos {{ $property->name }} dari platform?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger fw-semibold" title="Hapus Permanen Properti">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination Properti -->
    <div class="d-flex justify-content-center mb-5">
        {{ $properties->links() }}
    </div>

    <!-- Main Content Table Card 2: Daftar Pengguna Terdaftar -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people me-2 text-primary"></i>Daftar Pengguna Terdaftar</h5>
        </div>
        <div class="card-body p-0">
            @if(!isset($users) || $users->isEmpty())
                <div class="text-center py-5 px-3">
                    <p class="text-muted mb-0">Belum ada pengguna terdaftar di platform.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Nama Pengguna</th>
                                <th>Email</th>
                                <th>Nomor Telepon / WA</th>
                                <th>Peran (Role)</th>
                                <th class="text-end pe-4">Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark small"><i class="bi bi-whatsapp text-success me-1"></i>{{ $user->phone ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if($user->role === 'owner')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">Pemilik Kos</span>
                                        @elseif($user->role === 'tenant')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 rounded-pill">Pencari Kos</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill">Admin</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection