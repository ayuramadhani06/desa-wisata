<div class="section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto text-center">
                <div class="heading-content" data-aos="fade-up">
                    <h2>Paket Wisata Unggulan</h2>
                    <p>Temukan pengalaman wisata terbaik dengan paket-paket spesial kami.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @isset($paketwisatas)
            @foreach($paketwisatas as $paket)
            <div class="col-lg-4">
                <div class="service-2 left-0 mb-5">
                    @if($paket->foto1)
                        <img src="{{ asset('images/paket-wisata/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}" class="img-fluid mb-4 rounded">
                    @else
                        <img src="{{ asset('images/default_paket.jpg') }}" alt="Default Paket Image" class="img-fluid mb-4 rounded">
                    @endif
                    <div>
                        <h3>{{ $paket->nama_paket }}</h3>
                        <p>{{ Str::limit($paket->deskripsi, 100) }}</p>
                        <p class="text-primary font-weight-bold">Rp {{ number_format($paket->harga_per_pack, 0, ',', '.') }}</p>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $paket->id }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Detail Modal -->
            <div class="modal fade" id="detailModal{{ $paket->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">{{ $paket->nama_paket }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Carousel -->
                                    <div id="carousel{{ $paket->id }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            @if($paket->foto1)
                                                <button type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide-to="0" class="active"></button>
                                            @endif
                                            @if($paket->foto2)
                                                <button type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide-to="{{ $paket->foto1 ? '1' : '0' }}"></button>
                                            @endif
                                            @if($paket->foto3)
                                                <button type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide-to="{{ ($paket->foto1 ? 1 : 0) + ($paket->foto2 ? 1 : 0) }}"></button>
                                            @endif
                                            @if($paket->foto4)
                                                <button type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide-to="{{ ($paket->foto1 ? 1 : 0) + ($paket->foto2 ? 1 : 0) + ($paket->foto3 ? 1 : 0) }}"></button>
                                            @endif
                                            @if($paket->foto5)
                                                <button type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide-to="{{ ($paket->foto1 ? 1 : 0) + ($paket->foto2 ? 1 : 0) + ($paket->foto3 ? 1 : 0) + ($paket->foto4 ? 1 : 0) }}"></button>
                                            @endif
                                        </div>
                                        <!-- <div class="carousel-inner"> --> //gajadi karosel HEHEHEH
                                            @if($paket->foto1)
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto1) }}" class="d-block w-100" alt="Foto 1">
                                                </div>
                                            @endif
                                            <!-- @if($paket->foto2)
                                                <div class="carousel-item {{ !$paket->foto1 ? 'active' : '' }}">
                                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto2) }}" class="d-block w-100" alt="Foto 2">
                                                </div>
                                            @endif
                                            @if($paket->foto3)
                                                <div class="carousel-item {{ !$paket->foto1 && !$paket->foto2 ? 'active' : '' }}">
                                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto3) }}" class="d-block w-100" alt="Foto 3">
                                                </div>
                                            @endif
                                            @if($paket->foto4)
                                                <div class="carousel-item {{ !$paket->foto1 && !$paket->foto2 && !$paket->foto3 ? 'active' : '' }}">
                                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto4) }}" class="d-block w-100" alt="Foto 4">
                                                </div>
                                            @endif
                                            @if($paket->foto5)
                                                <div class="carousel-item {{ !$paket->foto1 && !$paket->foto2 && !$paket->foto3 && !$paket->foto4 ? 'active' : '' }}">
                                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto5) }}" class="d-block w-100" alt="Foto 5">
                                                </div>
                                            @endif -->
                                        <!-- </div> -->
                                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button> -->
                                        <!-- <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $paket->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4>Deskripsi</h4>
                                    <p>{{ $paket->deskripsi }}</p>
                                    
                                    <h4 class="mt-4">Fasilitas</h4>
                                    <p>{{ $paket->fasilitas }}</p>
                                    
                                    <h4 class="mt-4">Harga</h4>
                                    <p class="text-primary font-weight-bold">Rp {{ number_format($paket->harga_per_pack, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ route('reservasi.create', $paket->id) }}" class="btn btn-primary">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endisset
        </div>
    </div>
</div>  