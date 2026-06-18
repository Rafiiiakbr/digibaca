@extends('layouts.reader')
 
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
 
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card-digibaca p-4 text-center">
            <img src="{{ $user->avatar_url }}" class="rounded-circle mx-auto mb-3" width="100" height="100" alt="">
            <h5 class="font-display mb-0">{{ $user->nama }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            @if($user->isPremium())
                <span class="badge badge-premium px-3 py-2">Member Premium</span>
            @else
                <span class="badge bg-light text-dark border px-3 py-2">Member Gratis</span>
            @endif
 
            <hr>
            <div class="text-start small">
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Usia</span>
                    <span class="fw-semibold">{{ $user->getAge() }} tahun</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Bergabung</span>
                    <span class="fw-semibold">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
 
    <div class="col-md-8">
        <div class="card-digibaca p-4">
            <h5 class="font-display mb-3">Edit Profil</h5>
 
            @if(session('success'))
                <div class="alert alert-success small">{{ session('success') }}</div>
            @endif
 
            <form method="POST" action="{{ route('reader.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
 
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Foto Profil</label>
                    <input type="file" name="avatar" class="form-control cover-input" data-preview="#avatarPreview" accept="image/*">
                </div>
 
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control form-control-digibaca" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-digibaca" required>
                    </div>
                </div>
 
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}" class="form-control form-control-digibaca" required>
                </div>
 
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Bio</label>
                    <textarea name="bio" rows="3" class="form-control form-control-digibaca" placeholder="Ceritakan sedikit tentang Anda...">{{ old('bio', $user->bio) }}</textarea>
                </div>
 
                <hr>
                <h6 class="small fw-semibold text-muted mb-3">UBAH PASSWORD (opsional)</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control form-control-digibaca" placeholder="Password baru">
                    </div>
                    <div class="col-md-6">
                        <input type="password" name="password_confirmation" class="form-control form-control-digibaca" placeholder="Konfirmasi password baru">
                    </div>
                </div>
 
                <button type="submit" class="btn btn-digibaca px-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection