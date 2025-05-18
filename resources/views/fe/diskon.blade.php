<div class="section">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Diskon Spesial</h2>
        <div class="row align-items-stretch">
            @isset($diskons)
            @forelse($diskons as $diskon)
            <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="media-entry">
                    @if($diskon->foto)  
                        <a>
                            <img src="/images/diskon/{{ $diskon->foto }}" alt="{{ $diskon->nama_diskon }}" class="img-fluid">
                        </a>
                    @else
                        <a>
                            <img src="{{ asset('images/default_discount.jpg') }}" alt="Default Discount Image" class="img-fluid">
                        </a>
                    @endif
                    <div class="bg-white m-body">
                        <span class="date">
                            {{ \Carbon\Carbon::parse($diskon->tanggal_mulai)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($diskon->tanggal_berakhir)->format('d M Y') }}
                        </span>
                        <h3>{{ $diskon->nama_diskon }}</h3>
                        <p class="text-success font-weight-bold">{{ $diskon->persentase_diskon }}% OFF</p>
                        <p>{{ $diskon->deskripsi }}</p>
                        <div class="badge badge-success">Kode: {{ $diskon->kode_diskon }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada diskon yang tersedia saat ini.</div>
            </div>
            @endforelse
            @endisset
        </div>
    </div>
</div>