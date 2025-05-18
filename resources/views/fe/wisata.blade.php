<div class="section section-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row align-items-center justify-content-between mb-5">
            <div class="col-lg-5" data-aos="fade-up">
                <h2 class="heading mb-3">Objek Wisata Unggulan di Desa Serangan</h2>
                <p>Sebagai bagian dari Anugerah Desa Wisata Indonesia (ADWI) 2023, Desa Wisata Serangan meraih juara III nasional kategori Desa Wisata Rintisan, sebuah penghargaan yang mendorong kami untuk terus berkembang dan menjaga warisan budaya serta alam dengan penuh tanggung jawab.</p>
            </div>        
            <div class="col-lg-5 text-md-end" data-aos="fade-up" data-aos-delay="100">
                <div id="destination-controls">
                    <span class="prev me-3" data-controls="prev">
                        <span class="icon-chevron-left"></span>
                    </span>
                    <span class="next" data-controls="next">
                        <span class="icon-chevron-right"></span>
                    </span>
                </div>
            </div>
        </div>    
    </div>        

    <div class="destination-slider-wrap">
        <div class="destination-slider">
            @foreach($obyekWisatas as $wisata)
                <div class="destination">
                    <div class="thumb">
                        @if($wisata->foto1)
                            <img src="{{ asset('images/obyek-wisata/' . $wisata->foto1) }}" alt="{{ $wisata->nama_wisata }}" class="img-fluid">
                        @else
                            <img src="{{ asset('fe/images/default-wisata.jpg') }}" alt="Default Image" class="img-fluid">
                        @endif
                        <!-- <div class="price">Rp150.000</div> -->
                    </div>
                    <div class="mt-4">
                        <h3><a href="#" data-bs-toggle="modal" data-bs-target="#wisataModal{{ $wisata->id }}">{{ $wisata->nama_wisata }}</a></h3>
                        <span class="meta">{{ $wisata->kategori->kategori_wisata ?? 'Kategori tidak tersedia' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal untuk detail wisata -->
@foreach($obyekWisatas as $wisata)
<div class="modal fade" id="wisataModal{{ $wisata->id }}" tabindex="-1" aria-labelledby="wisataModalLabel{{ $wisata->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wisataModalLabel{{ $wisata->id }}">{{ $wisata->nama_wisata }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Foto utama -->
                    <div class="col-md-6">
                        @if($wisata->foto1)
                            <img id="mainImage{{ $wisata->id }}" src="{{ asset('images/obyek-wisata/' . $wisata->foto1) }}" class="img-fluid mb-3 rounded shadow" alt="{{ $wisata->nama_wisata }}">
                        @endif
                    </div>

                    <!-- Deskripsi dan detail -->
                    <div class="col-md-6">
                        <h4>Deskripsi</h4>
                        <div style="white-space: pre-line; text-align: justify; line-height: 1.6;">
                            {{ $wisata->deskripsi_wisata }}
                        </div>
                        
                        <h4 class="mt-4">Fasilitas</h4>
                        <p>{{ $wisata->fasilitas }}</p>
                        
                        <h4 class="mt-4">Kategori</h4>
                        <p>{{ $wisata->kategori->kategori_wisata ?? 'Kategori tidak tersedia' }}</p>
                    </div>
                </div>
                
                <!-- Foto lainnya (thumbnail) -->
                <div class="row mt-4">
                    @foreach(['foto2', 'foto3', 'foto4', 'foto5'] as $foto)
                        @if($wisata->$foto)
                            <div class="col-6 col-md-3 mb-3">
                                <img 
                                    src="{{ asset('images/obyek-wisata/' . $wisata->$foto) }}" 
                                    class="img-fluid rounded shadow-sm" 
                                    alt="{{ $wisata->nama_wisata }} thumbnail"
                                    style="cursor: pointer;"
                                    onclick="document.getElementById('mainImage{{ $wisata->id }}').src=this.src"
                                >
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach