@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Form Reservasi Paket Wisata</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_paket" value="{{ $paket_wisata->id }}">
                        <input type="hidden" name="id_pelanggan" value="{{ $pelanggan->id }}">
                        <input type="hidden" name="nama_pelanggan" value="{{ $pelanggan->nama_lengkap }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" class="form-control" value="{{ $paket_wisata->nama_paket }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Harga per Paket</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($paket_wisata->harga_per_pack, 0, ',', '.') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tgl_reservasi_wisata" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tgl_selesai_reservasi" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Peserta</label>
                            <input type="number" class="form-control" name="jumlah_peserta" min="1" required>
                        </div>

                        <div class="card mb-3 border-primary">
                            <div class="card-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="pilihPenginapanCheck">
                                    <label class="form-check-label fw-bold" for="pilihPenginapanCheck">Ingin menggunakan tempat ?</label>
                                </div>

                                <div id="sectionPilihPenginapan" style="display: none;">
                                    <label class="form-label">Pilih Tempat Penginapan</label>
                                    <select class="form-control" name="id_penginapan" id="id_penginapan">
                                        <option value="" data-harga="0">-- Pilih Penginapan --</option>
                                        @foreach ($penginapans as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_per_malam }}">
                                                {{ $p->nama_penginapan }} (Rp {{ number_format($p->harga_per_malam, 0, ',', '.') }}/malam)
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-info">*Harga akan dikalikan dengan jumlah malam menginap.</small>
                                </div>
                            </div>
                        </div>

                        @php
                            $diskonsAktif = $diskons->filter(function($diskon) {
                                $today = \Carbon\Carbon::now();
                                return $diskon->tanggal_mulai <= $today && $diskon->tanggal_berakhir >= $today;
                            });
                        @endphp

                        
                        <div class="mb-3">
                            <label class="form-label">Diskon</label>
                            <select class="form-control" name="id_diskon" id="diskon">
                                <option value="" data-persentase="0">Pilih Diskon (Opsional)</option>
                                @foreach ($diskonsAktif as $diskon)
                                    <option value="{{ $diskon->id }}" data-persentase="{{ $diskon->persentase_diskon }}">
                                        {{ $diskon->nama_diskon }} ({{ $diskon->persentase_diskon }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="mb-3">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select class="form-control" name="id_jenis_pembayaran" required>
                                @foreach ($jenis_pembayarans as $jenis)
                                    <option value="{{ $jenis->id }}">
                                        {{ $jenis->jenis_pembayaran }} - {{ $jenis->nomor_tf }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" name="bukti_tf" accept="image/*" required>
                            <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control" id="subtotal" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Bayar</label>
                                <input type="text" class="form-control" id="total_bayar" readonly>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Reservasi</button>
                             <a href="{{ url('/') }}" class="btn btn-secondary mt-2">Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hargaPaket = {{ $paket_wisata->harga_per_pack }};
    const jumlahPesertaInput = document.querySelector('input[name="jumlah_peserta"]');
    const diskonSelect = document.getElementById('diskon');
    const penginapanSelect = document.getElementById('id_penginapan');
    const checkPenginapan = document.getElementById('pilihPenginapanCheck');
    const sectionPenginapan = document.getElementById('sectionPilihPenginapan');
    
    const tglMulai = document.querySelector('input[name="tgl_reservasi_wisata"]');
    const tglSelesai = document.querySelector('input[name="tgl_selesai_reservasi"]');

    // Toggle Tampilan Penginapan
    checkPenginapan.addEventListener('change', function() {
        if(this.checked) {
            sectionPenginapan.style.display = 'block';
        } else {
            sectionPenginapan.style.display = 'none';
            penginapanSelect.value = "";
        }
        hitungTotal();
    });

    function hitungTotal() {
        const jumlah = parseInt(jumlahPesertaInput.value) || 0;
        const subtotalPaket = hargaPaket * jumlah;

        // Hitung Selisih Hari
        let durasi = 0;
        if (tglMulai.value && tglSelesai.value) {
            const start = new Date(tglMulai.value);
            const end = new Date(tglSelesai.value);
            const diffTime = Math.abs(end - start);
            durasi = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;
        }

        // Harga Penginapan
        const optPenginapan = penginapanSelect.options[penginapanSelect.selectedIndex];
        const hargaSewa = parseFloat(optPenginapan.getAttribute('data-harga')) || 0;
        const totalHargaPenginapan = hargaSewa * durasi;

        const subtotalSeleruh = subtotalPaket + totalHargaPenginapan;

        // Diskon
        const diskon = diskonSelect.options[diskonSelect.selectedIndex];
        const persenDiskon = parseFloat(diskon.getAttribute('data-persentase')) || 0;
        const nilaiDiskon = subtotalSeleruh * (persenDiskon / 100);
        const total = subtotalSeleruh - nilaiDiskon;

        document.getElementById('subtotal').value = 'Rp ' + subtotalSeleruh.toLocaleString('id-ID');
        document.getElementById('total_bayar').value = 'Rp ' + total.toLocaleString('id-ID');
    }

    [jumlahPesertaInput, diskonSelect, penginapanSelect, tglMulai, tglSelesai].forEach(el => {
        el.addEventListener('change', hitungTotal);
        el.addEventListener('input', hitungTotal);
    });
});
</script>
@endsection