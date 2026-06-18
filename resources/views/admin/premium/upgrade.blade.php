@extends('layouts.app')
 
@section('title', 'Upgrade Premium')
 
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
 
            <div class="text-center mb-5">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#FEF3C7; color:#92400E; font-weight:600;">
                    <i class="bi bi-gem me-1"></i> DigiBaca Premium
                </span>
                <h2 class="font-display">Buka Akses Penuh ke Seluruh Koleksi</h2>
                <p class="text-muted">Nikmati ribuan judul buku premium tanpa batas, sekali bayar berlaku selamanya.</p>
            </div>
 
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
 
            @if($pendingPayment)
                {{-- Status: menunggu konfirmasi --}}
                <div class="card-digibaca p-4 text-center">
                    <i class="bi bi-hourglass-split fs-1 text-amber mb-3"></i>
                    <h5 class="font-display">Pembayaran Sedang Diproses</h5>
                    <p class="text-muted mb-3">
                        Kode pembayaran: <strong>{{ $pendingPayment->kode_pembayaran }}</strong><br>
                        Bukti transfer Anda sedang ditinjau oleh admin. Proses ini biasanya memakan waktu 1x24 jam.
                    </p>
                    <span class="badge-status-pending mx-auto">Menunggu Konfirmasi</span>
                </div>
            @else
                <div class="row g-4">
                    {{-- Pricing card --}}
                    <div class="col-md-5">
                        <div class="card-digibaca p-4 h-100">
                            <h6 class="text-muted small text-uppercase fw-bold">Paket Premium</h6>
                            <div class="font-display mb-3" style="font-size:2.2rem; color:var(--color-ink);">
                                Rp99.000
                                <span class="fs-6 text-muted fw-normal">/ selamanya</span>
                            </div>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Akses semua buku premium</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Tanpa iklan</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Bookmark & catatan tanpa batas</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Berlaku seumur hidup</li>
                            </ul>
                        </div>
                    </div>
 
                    {{-- Payment form --}}
                    <div class="col-md-7">
                        <div class="card-digibaca p-4">
                            <h6 class="font-display mb-3">Konfirmasi Pembayaran</h6>
 
                            <p class="small text-muted mb-2">Transfer ke salah satu rekening berikut:</p>
                            <div class="mb-3">
                                @foreach(config('digibaca.bank_tujuan', []) as $bank)
                                <div class="d-flex justify-content-between border rounded-3 p-2 mb-2 small">
                                    <span class="fw-semibold">{{ $bank['bank'] }}</span>
                                    <span>{{ $bank['no_rek'] }} a.n {{ $bank['a_n'] }}</span>
                                </div>
                                @endforeach
                            </div>
 
                            @if($errors->any())
                                <div class="alert alert-danger small">{{ $errors->first() }}</div>
                            @endif
 
                            <form method="POST" action="{{ route('premium.pay') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Metode Transfer</label>
                                    <select name="metode" class="form-select form-control-digibaca" required>
                                        @foreach(config('digibaca.bank_tujuan', []) as $bank)
                                            <option value="{{ $bank['bank'] }}">{{ $bank['bank'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Upload Bukti Transfer</label>
                                    <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-amber w-100">
                                    <i class="bi bi-send-check me-1"></i> Kirim Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection