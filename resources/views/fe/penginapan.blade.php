@section('troon')
	@include('fe.troon')
@endsection
@section('penginapan')
<div class="container py-4">
    <h2 class="mb-4 text-center">Daftar Penginapan</h2>
    <div class="row">
        @forelse($penginapans as $item)
        <div class="col-lg-3 mb-4">
            <div class="card h-100">
                @if($item->foto1)
                    <img src="{{ asset('storage/'.$item->foto1) }}"
                         class="card-img-top"
                         alt="{{ $item->nama_penginapan }}">
                @else
                    <img src="{{ asset('placeholder.jpg') }}"
                         class="card-img-top"
                         alt="Placeholder">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_penginapan }}</h5>
                    <p class="text-muted">Fasilitas: {{ $item->fasilitas }}</p>
                    <!-- tombol buka modal detail -->
                    <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $item->id }}">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Detail untuk tiap $item --}}
        <div class="modal fade" id="detailModal{{ $item->id }}"
             tabindex="-1"
             aria-labelledby="detailModalLabel{{ $item->id }}"
             aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"
                    id="detailModalLabel{{ $item->id }}">
                  {{ $item->nama_penginapan }}
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
              </div>
              <div class="modal-body">
                {{-- Carousel foto (jika ada lebih dari 1) --}}
                <div id="carousel{{ $item->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    @for($i=1; $i<=5; $i++)
                      @php $foto = 'foto' . $i; @endphp
                      @if($item->$foto)
                        <div class="carousel-item @if($i==1) active @endif">
                          <img src="{{ asset('storage/'.$item->$foto) }}"
                               class="d-block w-100"
                               alt="Foto {{ $i }}">
                        </div>
                      @endif
                    @endfor
                  </div>
                  <button class="carousel-control-prev" type="button"
                          data-bs-target="#carousel{{ $item->id }}"
                          data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </button>
                  <button class="carousel-control-next" type="button"
                          data-bs-target="#carousel{{ $item->id }}"
                          data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </button>
                </div>

                <p><strong>Deskripsi:</strong></p>
                <p>{{ $item->deskripsi }}</p>

                <p><strong>Fasilitas:</strong></p>
                <p>{{ $item->fasilitas }}</p>
              </div>
              <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p>Belum ada penginapan tersedia</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
	
	
	
	
	
	{{-- <div class="section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-6 mx-auto text-center">
					<div class="heading-content" data-aos="fade-up">
						<h2 class="heading">Pilih HomeStay Kamu</h2>
						<p>Nikmati pengalaman menginap yang nyaman dan autentik di Homestay Desa Wisata Serangan. Setiap homestay menawarkan suasana khas Bali dengan keramahan lokal, fasilitas lengkap, dan lokasi strategis dekat pantai, pura, serta pusat aktivitas budaya. Temukan kenyamanan seperti di rumah sendiri sambil menjelajahi keindahan Serangan.</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3">
					<a href="#" class="person">
						<img src="{{asset('fe/images/homes1.jpg')}}" alt="Image" class="img-fluid mb-4">
						<span class="subheading d-inline-block">Rp300.000</span>
						<h3 class="mb-3">D&D Homestay</h3>
						<p class="text-muted">Fasilitas: air conditioner, kamar mandi pribadi, kolam renang, perlengkapan mandi, sarapan pagi, selfie area, televisi, wifi area.</p>
					</a>
				</div>
				<div class="col-lg-3">
					<a href="#" class="person">
						<img src="{{asset('fe/images/homes2.jpg')}}" alt="Image" class="img-fluid mb-4">
						<span class="subheading d-inline-block">Rp250.0000</span>
						<h3 class="mb-3">I"Ra Homestay</h3>
						<p class="text-muted">Fasilitas: air conditioner, kamar mandi pribadi, perlengkapan mandi, televisi, wifi area.</p>
					</a>
				</div>
				<div class="col-lg-3">
					<a href="#" class="person">
						<img src="{{asset('fe/images/homes3.jpg')}}" alt="Image" class="img-fluid mb-4">
						<span class="subheading d-inline-block">Rp200.000</span>
						<h3 class="mb-3">WIJAYA HOMESTAY</h3>
						<p class="text-muted">Fasilitas: air conditioner, kipas angin, perlengkapan mandi, sarapan pagi, selfie area, televisi, wifi area.</p>
					</a>
				</div>
				<div class="col-lg-3">
					<a href="#" class="person">
						<img src="{{asset('fe/images/homes4.jpg')}}" alt="Image" class="img-fluid mb-4">
						<span class="subheading d-inline-block">Rp450.000</span>
						<h3 class="mb-3">Turtle Island Homestay</h3>
						<p class="text-muted">Fasilitas: air conditioner, kamar mandi pribadi, kipas angin, kolam renang, perlengkapan mandi, sarapan pagi, selfie area, televisi, wifi area.</p>
					</a>
				</div>
			</div>
		</div>
	</div>

	 --}}