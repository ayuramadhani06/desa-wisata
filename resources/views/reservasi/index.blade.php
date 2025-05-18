@extends ('fe.master')  
@section ('troon2')
    @include('fe.troon2')
@endsection
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

                        <div class="mb-3">
                            <label class="form-label">Diskon</label>
                            <select class="form-control" name="id_diskon" id="diskon">
                                <option value="">Pilih Diskon (Opsional)</option>
                                @foreach ($diskons as $diskon)
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
                            <a href="{{ url('/') }}" class="btn btn-secondary">Kembali ke Beranda</a>
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
    const jumlahPeserta = document.querySelector('input[name="jumlah_peserta"]');
    const diskonSelect = document.getElementById('diskon');
    const subtotalInput = document.getElementById('subtotal');
    const totalBayarInput = document.getElementById('total_bayar');

    function hitungTotal() {
        const jumlah = parseInt(jumlahPeserta.value) || 0;
        const subtotal = hargaPaket * jumlah;
        
        const diskon = diskonSelect.options[diskonSelect.selectedIndex];
        const persenDiskon = parseFloat(diskon.getAttribute('data-persentase')) || 0;
        const nilaiDiskon = subtotal * (persenDiskon / 100);
        const total = subtotal - nilaiDiskon;

        subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
        totalBayarInput.value = 'Rp ' + total.toLocaleString('id-ID');
    }

    jumlahPeserta.addEventListener('input', hitungTotal);
    diskonSelect.addEventListener('change', hitungTotal);

    // Hitung awal
    hitungTotal();
});
</script>
@endsection