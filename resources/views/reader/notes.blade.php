@extends('layouts.reader')
 
@section('title', 'Catatan Saya')
@section('page-title', 'Catatan Saya')
 
@section('content')
<div class="row g-3">
    @forelse($notes as $note)
    <div class="col-md-6">
        <div class="card-digibaca p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="fw-semibold small" style="color:var(--color-ink);">{{ $note->book->judul ?? 'Buku dihapus' }}</div>
                    @if($note->halaman)<div class="text-muted" style="font-size:0.75rem;">Halaman {{ $note->halaman }}</div>@endif
                </div>
                <form action="{{ route('reader.notes.destroy', $note->id) }}" method="POST" data-confirm="Hapus catatan ini?">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                </form>
            </div>
            <p class="small mb-1" style="color: var(--color-text);">{{ $note->isi_catatan }}</p>
            <div class="text-muted mt-2" style="font-size:0.7rem;">{{ $note->updated_at->translatedFormat('d M Y, H:i') }}</div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-journal-text"></i>
            <h5>Belum ada catatan</h5>
            <p>Catatan akan muncul di sini saat Anda menulis catatan ketika membaca.</p>
        </div>
    </div>
    @endforelse
</div>
<div class="mt-4 d-flex justify-content-center">{{ $notes->links() }}</div>
@endsection