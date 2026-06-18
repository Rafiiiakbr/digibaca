{{--
|=============================================================
| FILE: resources/views/admin/users/index.blade.php
|=============================================================
--}}
@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')

<div class="card-digibaca p-3 mb-4">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2">
        <div class="col-md-5">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-digibaca" placeholder="Cari nama atau email...">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select" data-auto-submit>
                <option value="">Semua Role</option>
                <option value="reader" {{ request('role') == 'reader' ? 'selected' : '' }}>Pembaca</option>
                <option value="author" {{ request('role') == 'author' ? 'selected' : '' }}>Penulis</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-digibaca w-100">Cari</button>
        </div>
    </form>
</div>

<div class="card-digibaca">
    <div class="table-responsive">
        <table class="table table-digibaca mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Usia</th>
                    <th>Premium</th>
                    <th>Bergabung</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;" alt="">
                            <span class="fw-semibold">{{ $user->nama }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>{{ $user->getAge() }} thn</td>
                    <td>
                        @if($user->role !== 'admin')
                        <form action="{{ route('admin.users.toggle-premium', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->status_premium ? 'btn-amber' : 'btn-outline-digibaca' }}">
                                {{ $user->status_premium ? 'Premium ✓' : 'Aktifkan' }}
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                    <td class="text-end">
                        @if($user->role !== 'admin')
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-confirm="Hapus user ini secara permanen?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7"><div class="empty-state"><i class="bi bi-people"></i><p class="mb-0">Tidak ada user ditemukan.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $users->links() }}</div>
@endsection