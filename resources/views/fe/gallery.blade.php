<!-- Gallery Section -->
<div class="section section-gallery" data-aos="fade-up">
    <div class="container">
        <h2 class="heading mb-5 text-center">Gallery Desa Wisata Serangan</h2>

        <!-- <div class="text-center mb-4">
            <div id="prevnext-gallery">
                <span class="prev me-3" data-controls="prev">
                    <span class="icon-chevron-left"></span>
                </span>
                <span class="next" data-controls="next">
                    <span class="icon-chevron-right"></span>
                </span>
            </div>
        </div> -->

        <div class="row gallery-grid gx-4 gy-4">
            @foreach($obyekWisatas as $wisata)
                @php
                    $fotos = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $fotoField = 'foto'.$i;
                        if (!empty($wisata->$fotoField)) {
                            $fotos[] = $wisata->$fotoField;
                        }
                    }
                @endphp

                @foreach($fotos as $foto)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="gallery-item">
                            <div class="thumb">
                                <img src="{{ asset('images/obyek-wisata/' . $foto) }}" 
                                     alt="{{ $wisata->nama_wisata }}" 
                                     class="img-fluid"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#galleryModal"
                                     onclick="showGalleryImage('{{ asset('images/obyek-wisata/' . $foto) }}', '{{ $wisata->nama_wisata }}')">
                                <div class="gallery-overlay">
                                    <h5>{{ $wisata->nama_wisata }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryModalImage" src="" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .gallery-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .gallery-item .thumb {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        height: 220px;
        background-color: #000;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
        color: white;
        padding: 15px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay h5 {
        font-size: 16px;
        margin-bottom: 0;
    }
</style>

<!-- Script -->
<script>
    function showGalleryImage(src, title) {
        document.getElementById('galleryModalImage').src = src;
        document.getElementById('galleryModalLabel').textContent = title;
    }
</script>
