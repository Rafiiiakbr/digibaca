@extends('layouts.app')
@section('title', 'Upgrade ke Premium')

@section('styles')
<style>
    .premium-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: white;
        border-radius: 16px;
        padding: 48px 32px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .premium-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 60%);
        pointer-events: none;
    }
    .paket-card {
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 28px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .paket-card:hover, .paket-card.selected {
        border-color: #0d6efd;
        box-shadow: 0 8px 24px rgba(13,110,253,0.15);
        transform: translateY(-4px);
    }
    .paket-card.populer {
        border-color: #ffc107;
    }
    .badge-populer {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background: #ffc107;
        color: #000;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 16px;
        border-radius: 20px;
    }
    .harga {
        font-size: 2rem;
        font-weight: 800;
        color: #0d6efd;
    }
    .feature-list li {
        padding: 6px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
    }
    .feature-list li:last-child { border: none; }
</style>
@endsection

@section('content')
<div class="container py-4">
    {{-- Hero Banner --}}
    <div class="premium-hero mb-5">
        <i class="bi bi-crown-fill" style="font-size: 3rem; color: #ffc107;"></i>
        <h1 class="fw-bold mt-3 mb-2">Upgrade ke ReadOn Premium</h1>
        <p class="text-white-50 mb-0 fs-5">Akses tak terbatas ke ribuan buku digital eksklusif pilihan para ahli.</p>

        @if($user->status_premium)
            <div class="alert alert-warning mt-4 mb-0 d-inline-block">
                <i class="bi bi-check-circle-fill me-2"></i>
                Anda sudah menjadi member <strong>Premium</strong>. Nikmati semua fitur eksklusif!
            </div>
        @endif
    </div>

    @if(!$user->status_premium)
    {{-- Pilihan Paket --}}
    <form id="payment-form" action="{{ route('reader.premium.checkout') }}" method="POST">
        @csrf
        <h4 class="fw-bold text-center mb-4">Pilih Paket Berlangganan</h4>
        <div class="row g-4 justify-content-center mb-5">

            {{-- Paket 1 Bulan --}}
            <div class="col-md-4">
                <label class="paket-card d-block" for="paket_1">
                    <input type="radio" name="paket" id="paket_1" value="1_bulan" class="d-none">
                    <div class="text-center">
                        <span class="badge bg-secondary mb-2">Starter</span>
                        <div class="harga">Rp 29.000</div>
                        <div class="text-muted mb-3">per bulan</div>
                    </div>
                    <ul class="feature-list list-unstyled mb-3">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Akses semua buku premium</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bookmark & Catatan tak terbatas</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Baca buku eksklusif dewasa</li>
                        <li><i class="bi bi-x-circle text-muted me-2"></i>Diskon perpanjangan</li>
                    </ul>
                    <button type="submit" class="btn btn-outline-primary w-100 fw-semibold" onclick="document.getElementById('paket_1').checked=true">
                        Pilih Paket Ini
                    </button>
                </label>
            </div>

            {{-- Paket 3 Bulan (Populer) --}}
            <div class="col-md-4">
                <label class="paket-card populer d-block" for="paket_3">
                    <span class="badge-populer"><i class="bi bi-star-fill me-1"></i>Paling Populer</span>
                    <input type="radio" name="paket" id="paket_3" value="3_bulan" class="d-none" checked>
                    <div class="text-center">
                        <span class="badge bg-warning text-dark mb-2">Most Value</span>
                        <div class="harga">Rp 79.000</div>
                        <div class="text-muted mb-1">per 3 bulan</div>
                        <small class="text-success fw-semibold">Hemat Rp 8.000!</small>
                        <div class="mb-2"></div>
                    </div>
                    <ul class="feature-list list-unstyled mb-3">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Akses semua buku premium</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bookmark & Catatan tak terbatas</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Baca buku eksklusif dewasa</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Diskon perpanjangan 5%</li>
                    </ul>
                    <button type="submit" class="btn btn-warning text-dark w-100 fw-bold" onclick="document.getElementById('paket_3').checked=true">
                        <i class="bi bi-crown-fill me-1"></i> Pilih Paket Ini
                    </button>
                </label>
            </div>

            {{-- Paket 12 Bulan --}}
            <div class="col-md-4">
                <label class="paket-card d-block" for="paket_12">
                    <input type="radio" name="paket" id="paket_12" value="12_bulan" class="d-none">
                    <div class="text-center">
                        <span class="badge bg-success mb-2">Best Deal</span>
                        <div class="harga">Rp 249.000</div>
                        <div class="text-muted mb-1">per tahun</div>
                        <small class="text-success fw-semibold">Hemat Rp 99.000!</small>
                        <div class="mb-2"></div>
                    </div>
                    <ul class="feature-list list-unstyled mb-3">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Akses semua buku premium</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bookmark & Catatan tak terbatas</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Baca buku eksklusif dewasa</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Diskon perpanjangan 10%</li>
                    </ul>
                    <button type="submit" class="btn btn-outline-success w-100 fw-semibold" onclick="document.getElementById('paket_12').checked=true">
                        Pilih Paket Ini
                    </button>
                </label>
            </div>

        </div>
    </form>
    @endif

    {{-- Riwayat Pembayaran --}}
    @if($payments->isNotEmpty())
    <div class="card p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Riwayat Pembayaran</h5>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                        <td>Upgrade Premium</td>
                        <td>Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                        <td>
                            @if($payment->status == 'success')
                                <span class="badge bg-success">Berhasil</span>
                            @elseif($payment->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-danger">Gagal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('payment-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const selectedRadio = form.querySelector('input[name="paket"]:checked');
        
        if (!selectedRadio) {
            alert('Silakan pilih salah satu paket terlebih dahulu.');
            return;
        }

        const paket = selectedRadio.value;
        const token = form.querySelector('input[name="_token"]').value;

        // Cari tombol submit yang ditekan
        const submitButtons = form.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => {
            btn.disabled = true;
        });

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ paket: paket })
        })
        .then(response => response.json())
        .then(data => {
            submitButtons.forEach(btn => {
                btn.disabled = false;
            });

            if (data.success && data.snap_token) {
                // Trigger popup Midtrans Snap
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran berhasil!");
                        window.location.href = "{{ route('reader.dashboard') }}";
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran Anda.");
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        window.location.reload();
                    },
                    onClose: function() {
                        alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
                    }
                });
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pembayaran.');
            }
        })
        .catch(error => {
            submitButtons.forEach(btn => {
                btn.disabled = false;
            });
            console.error('Error:', error);
            alert('Gagal menghubungi server pembayaran.');
        });
    });
</script>
@endsection
