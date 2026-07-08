@extends('layouts.reader')

@section('title', 'Upgrade Premium')
@section('page-title', 'Upgrade Premium')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            {{-- Alert Notifikasi Sukses / Gagal --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Jika ada pembayaran yang masih PENDING --}}
            @if($pendingPayment)
                <div class="card border-warning rounded-4 shadow-sm text-center p-4 mb-4">
                    <div class="text-warning mb-3">
                        <i class="bi bi-hourglass-split display-4"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Pembayaran Sedang Diverifikasi</h4>
                    <p class="text-muted small px-3">
                        Anda telah mengirimkan bukti transfer via <strong>{{ $pendingPayment->metode }}</strong>. 
                        Mohon tunggu, admin sedang memeriksa pembayaran Anda secara manual.
                    </p>
                    <div class="bg-light p-2 rounded-3 text-monospace small text-secondary">
                        Kode Pembayaran: {{ $pendingPayment->kode_pembayaran }}
                    </div>
                </div>
            
            {{-- Jika TIDAK ADA pembayaran pending, tampilkan Form Upgrade --}}
            @else
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #1e1b4b, #312e81);">
                        <i class="bi bi-gem text-warning display-5 mb-2"></i>
                        <h3 class="fw-bold mb-1">Akses Premium DigiBaca</h3>
                        <p class="mb-0 text-white-50 small">Nikmati bacaan tanpa batas hanya dengan berlangganan.</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-4">
                            <div>
                                <span class="text-muted d-block small">Total Biaya</span>
                                <strong class="text-dark fs-5">Rp 100.000</strong>
                            </div>
                            <span class="badge bg-primary px-3 py-2 rounded-pill">Aktif 1 Tahun</span>
                        </div>

                        <form action="{{ route('premium.pay') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small">1. Pilih Metode Transfer</label>
                                <select name="metode" class="form-select rounded-3 @error('metode') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Bank Transfer --</option>
                                    <option value="BCA">Bank BCA (No. Rek: 8123-456-789 a/n DigiBaca)</option>
                                    <option value="Mandiri">Bank Mandiri (No. Rek: 123-00-456789-0 a/n DigiBaca)</option>
                                    <option value="BRI">Bank BRI (No. Rek: 0123-4567-8901 a/n DigiBaca)</option>
                                </select>
                                @error('metode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark small">2. Unggah Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" class="form-control rounded-3 @error('bukti_transfer') is-invalid @enderror" accept="image/*" required>
                                <div class="form-text text-muted" style="font-size: 0.75rem;">
                                    Format file: JPG, JPEG, PNG. Ukuran maksimal 2MB.
                                </div>
                                @error('bukti_transfer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection