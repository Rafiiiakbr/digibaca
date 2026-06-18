{{--
|=============================================================
| FILE: resources/views/admin/dashboard.blade.php
|=============================================================
--}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E0E7FF; color:var(--color-ink);"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-journal-richtext"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_books'] }}</div>
                <div class="stat-label">Total Buku</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-pencil-square"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_authors'] }}</div>
                <div class="stat-label">Total Penulis</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2; color:#991B1B;"><i class="bi bi-gem"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_premium'] }}</div>
                <div class="stat-label">Pengguna Premium</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="stat-value">{{ $stats['pending_books'] }}</div>
                <div class="stat-label">Buku Menunggu Verifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-patch-check"></i></div>
            <div>
                <div class="stat-value">{{ $stats['verified_books'] }}</div>
                <div class="stat-label">Buku Terverifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E0E7FF; color:var(--color-ink);"><i class="bi bi-credit-card"></i></div>
            <div>
                <div class="stat-value">{{ $stats['pending_payments'] }}</div>
                <div class="stat-label">Pembayaran Pending</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-cash-stack"></i></div>
            <div>
                <div class="stat-value">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Buku Menunggu Verifikasi --}}
    <div class="col-md-7">
        <div class="card-digibaca h-100">
            <div class="card-header-custom">
                <span><i class="bi bi-hourglass-split me-2"></i>Buku Menunggu Verifikasi</span>
                <a href="{{ route('admin.books.index', ['status' => 'pending']) }}" class="small">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-digibaca mb-0">
                    <thead><tr><th>Buku</th><th>Penulis</th><th></th></tr></thead>
                    <tbody>
                        @forelse($pendingBooks as $book)
                        <tr>
                            <td class="fw-semibold">{{ Str::limit($book->judul, 30) }}</td>
                            <td class="text-muted">{{ $book->author->nama ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-digibaca">Tinjau</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3"><div class="empty-state py-3"><i class="bi bi-check-circle"></i><p class="mb-0 small">Tidak ada buku menunggu verifikasi.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pembayaran Pending --}}
    <div class="col-md-5">
        <div class="card-digibaca h-100">
            <div class="card-header-custom">
                <span><i class="bi bi-credit-card me-2"></i>Pembayaran Pending</span>
                <a href="{{ route('admin.premium.index') }}" class="small">Lihat Semua</a>
            </div>
            <div class="p-3">
                @forelse($recentPayments as $p)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="small fw-semibold">{{ $p->user->nama }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">Rp{{ number_format($p->nominal, 0, ',', '.') }} via {{ $p->metode }}</div>
                    </div>
                    <a href="{{ route('admin.premium.index') }}" class="btn btn-sm btn-outline-digibaca">Cek</a>
                </div>
                @empty
                <div class="empty-state py-3"><i class="bi bi-check-circle"></i><p class="mb-0 small">Tidak ada pembayaran pending.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    {{-- Statistik Kategori --}}
    <div class="col-md-7">
        <div class="card-digibaca">
            <div class="card-header-custom"><span><i class="bi bi-bar-chart-line me-2"></i>Distribusi Buku per Kategori</span></div>
            <div class="p-3">
                @foreach($categories as $cat)
                @php $percent = $stats['total_books'] > 0 ? round($cat->verified_books_count / $stats['total_books'] * 100) : 0; @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>{{ $cat->nama_kategori }}</span>
                        <span class="text-muted">{{ $cat->verified_books_count }} buku</span>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar" style="background: var(--color-ink); width: {{ $percent }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- User Terbaru --}}
    <div class="col-md-5">
        <div class="card-digibaca">
            <div class="card-header-custom">
                <span><i class="bi bi-person-plus me-2"></i>Pengguna Terbaru</span>
                <a href="{{ route('admin.users.index') }}" class="small">Lihat Semua</a>
            </div>
            <div class="p-3">
                @foreach($recentUsers as $u)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ $u->avatar_url }}" style="width:30px;height:30px;border-radius:50%;" alt="">
                        <span class="small fw-semibold">{{ $u->nama }}</span>
                    </div>
                    <span class="badge bg-light text-dark border">{{ ucfirst($u->role) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection