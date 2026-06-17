{{--
|=============================================================
| FILE: resources/views/admin/premium/index.blade.php
|=============================================================
--}}
@extends('layouts.admin')

@section('title', 'Kelola Premium')
@section('page-title', 'Kelola Premium & Pembayaran')

@section('content')

<div class="card-digibaca">
    <div class="card-header-custom">
        <span><i class="bi bi-credit-card me-2"></i>Daftar Pembayaran Premium</span>
    </div>
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Kode</th>
                    <th>Bukti Transfer</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $p)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $p->user->avatar_url }}" style="width:30px;height:30px;border-radius:50%;" alt="">
                            <div>
                                <div class="fw-semibold small">{{ $p->user->nama }}</div>
                                <div class="text-muted" style="font-size:0.7rem;">{{ $p->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>Rp{{ number_format($p->nominal, 0, ',', '.') }}</td>
                    <td>{{ $p->metode }}</td>
                    <td class="text-muted small">{{ $p->kode_pembayaran }}</td>
                    <td>
                        @if($p->bukti_transfer)
                        <a href="{{ asset('storage/payments/' . $p->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-digibaca">
                            <i class="bi bi-image"></i> Lihat
                        </a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status-{{ $p->status == 'confirmed' ? 'verified' : $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $p->created_at->translatedFormat('d M Y, H:i') }}</td>
                    <td class="text-end">
                        @if($p->status == 'pending')
                        <form action="{{ route('admin.premium.confirm', $p->id) }}" method="POST" class="d-inline" data-confirm="Konfirmasi pembayaran ini & aktifkan premium untuk {{ $p->user->nama }}?">
                            @csrf
                            <button class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i> Konfirmasi</button>
                        </form>
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectPaymentModal{{ $p->id }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="rejectPaymentModal{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.premium.reject', $p->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h6 class="modal-title">Tolak Pembayaran</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea name="catatan" class="form-control form-control-digibaca" rows="3" placeholder="Alasan penolakan (cth: bukti transfer tidak valid)" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Tolak Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr><td colspan="8"><div class="empty-state"><i class="bi bi-credit-card"></i><p class="mb-0">Belum ada transaksi pembayaran.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $payments->links() }}</div>
@endsection