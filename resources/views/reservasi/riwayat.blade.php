@extends ('fe.profile')
@section('content')

<div class="container-fluid py-5 bg-light min-vh-100">
    <div class="container">

        <!-- Header Section -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                <i class="fas fa-history me-2"></i>Riwayat Reservasi
            </h2>
            <p class="text-muted mb-0">
                Daftar seluruh reservasi yang pernah kamu lakukan
            </p>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Paket Wisata</th>
                                <th>Tanggal</th>
                                <th>Peserta</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservasis as $reservasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="fw-semibold">
                                        {{ $reservasi->paketWisata->nama_paket }}
                                    </td>

                                    <td>
                                        {{ $reservasi->tgl_reservasi_wisata->format('d/m/Y') }} -
                                        {{ $reservasi->tgl_selesai_reservasi->format('d/m/Y') }}
                                    </td>

                                    <td>{{ $reservasi->jumlah_peserta }} org</td>

                                    <td class="fw-bold text-primary">
                                        Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <span class="badge 
                                            @if($reservasi->status_reservasi == 'Dipesan') bg-warning text-dark
                                            @elseif($reservasi->status_reservasi == 'Dibayar') bg-info
                                            @elseif($reservasi->status_reservasi == 'Selesai') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ $reservasi->status_reservasi }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            
                                            <a href="#" 
                                               class="btn btn-sm btn-outline-primary rounded-circle"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#detailReservasi{{ $reservasi->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('reservasi.downloadNota', $reservasi->id) }}" 
                                               class="btn btn-sm btn-outline-danger rounded-circle"
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal tetap bisa kamu taruh di sini seperti sebelumnya --}}
                                <div class="modal fade" id="detailReservasi{{ $reservasi->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title text-dark">Detail Reservasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Nama Paket:</strong>
                                                        <p>{{ $reservasi->paketWisata->nama_paket }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Tanggal:</strong>
                                                        <p>
                                                            {{ $reservasi->tgl_reservasi_wisata->format('d F Y') }} - 
                                                            {{ $reservasi->tgl_selesai_reservasi->format('d F Y') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Jumlah Peserta:</strong>
                                                        <p>{{ $reservasi->jumlah_peserta }} orang</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Harga per Paket:</strong>
                                                        <p>Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>

                                                @if($reservasi->diskon)
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Diskon:</strong>
                                                        <p>{{ $reservasi->diskon->nama_diskon }} ({{ $reservasi->persentase_diskon }}%)</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Nilai Diskon:</strong>
                                                        <p>Rp {{ number_format($reservasi->nilai_diskon, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Subtotal:</strong>
                                                        <p>Rp {{ number_format($reservasi->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Total Bayar:</strong>
                                                        <p>Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Metode Pembayaran:</strong>
                                                        <p>{{ $reservasi->jenisPembayaran->jenis_pembayaran }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Status:</strong>
                                                        <p>
                                                            <span class="badge 
                                                                @if($reservasi->status_reservasi == 'Dipesan') bg-warning text-dark
                                                                @elseif($reservasi->status_reservasi == 'Dibayar') bg-info
                                                                @elseif($reservasi->status_reservasi == 'Selesai') bg-success
                                                                @else bg-danger
                                                                @endif">
                                                                {{ $reservasi->status_reservasi }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <strong>Bukti Transfer:</strong><br>
                                                    <img src="{{ asset('storage/' . $reservasi->bukti_tf) }}" alt="Bukti Transfer" class="img-fluid mt-2" style="max-height: 300px;">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada reservasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection