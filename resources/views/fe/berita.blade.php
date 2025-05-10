@extends('fe.master')

@section('title', 'Berita Desa Wisata')
@section('troon')
	@include('fe.troon')
@endsection
@section('berita')
<div class="container py-4">
    <h2 class="mb-4 text-center">Berita Desa Wisata</h2>

    <div class="row">
        @forelse ($beritas as $berita)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/berita/' . $berita->foto) }}" class="card-img-top" alt="foto berita">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $berita->judul }}</h5>
                    <p class="card-text">{{ Str::limit($berita->berita, 100) }}</p>
                    <div class="mt-auto">
                        <small class="text-muted d-block mb-2">
                            {{ $berita->kategori->kategori_berita }} | 
                            {{ \Carbon\Carbon::parse($berita->tgl_post)->translatedFormat('d F Y H:i') }}
                        </small>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#beritaModal{{ $berita->id }}">
                            Selengkapnya
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for each news item -->
        <div class="modal fade" id="beritaModal{{ $berita->id }}" tabindex="-1" aria-labelledby="beritaModalLabel{{ $berita->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="beritaModalLabel{{ $berita->id }}">{{ $berita->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('images/berita/' . $berita->foto) }}" class="img-fluid mb-3" alt="foto berita">
                        <p>{{ $berita->berita }}</p>
                        <p class="text-muted">
                            <small>
                                {{ $berita->kategori->kategori_berita }} | 
                                {{ \Carbon\Carbon::parse($berita->tgl_post)->translatedFormat('d F Y H:i') }}
                            </small>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p>Belum ada berita tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection