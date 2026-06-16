@extends('layouts.app')
@section('title', 'Panel Kontrol Admin')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Ringkasan Sistem</h2>
        <p class="text-muted mb-0">Panel kendali metrik pertumbuhan data dan modul verifikasi.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-primary border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL PEMBACA</span>
                <h3 class="fw-bold mb-0 text-primary">{{ $total_user }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-success border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL PENULIS</span>
                <h3 class="fw-bold mb-0 text-success">{{ $total_author }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-info border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">TOTAL BUKU</span>
                <h3 class="fw-bold mb-0 text-info">{{ $total_buku }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 border-start border-warning border-4 bg-white">
                <span class="text-muted small d-block mb-1 fw-medium">PREMIUM MEMBERS</span>
                <h3 class="fw-bold mb-0 text-warning">{{ $total_premium_user }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Antrean Verifikasi Buku</h5>
                    <span class="badge bg-danger rounded-pill">{{ $buku_pending }} Perlu Review</span>
                </div>
                <div class="text-muted small">
                    <p>Fungsionalitas persetujuan (approval) penuh dan penolakan buku akan diintegrasikan pada modul CRUD manajemen admin selanjutnya.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-3">Transaksi Premium Terbaru</h5>
                <ul class="list-group list-group-flush small">
                    @forelse($recent_payments as $payment)
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold d-block">{{ $payment->user->nama }}</span>
                                <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge {{ $payment->status == 'success' ? 'bg-success-subsub' : 'bg-secondary' }} text-success fw-bold">
                                Rp {{ number_format($payment->nominal, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item px-0 py-3 text-center text-muted">Belum ada riwayat transaksi masuk.</li>
                    @endforelse
                </ul>
                <div class="mt-3 pt-2 border-top bg-light p-2 rounded text-center">
                    <small class="text-muted">Total Dana Likuid: </small>
                    <strong class="text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection