@extends('be.master')

@section ('navbar')
    @include('be.navbar')
@endsection

@section ('sidebar')
    @include('be.sidebar')
@endsection

@section ('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Tabel Konfirmasi Reservasi</h6>
                    <span class="badge bg-light text-dark">{{ $reservasis->count() }} Total Pesanan</span>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form method="GET" action="{{ route('bendahara.konfir') }}" class="mb-4 px-4 mt-3">
                        <div class="row">

                            {{-- FILTER TANGGAL --}}
                            <div class="col-md-3">
                                <label>Tanggal Wisata</label>
                                <input type="date" name="filter_date" class="form-control"
                                    value="{{ request('filter_date') }}">
                            </div>

                            {{-- SEARCH NAMA --}}
                            <div class="col-md-3">
                                <label>Nama Pelanggan</label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari nama..."
                                    value="{{ request('search') }}">
                            </div>

                            {{-- FILTER STATUS --}}
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Semua Status --</option>
                                    <option value="Dipesan" {{ request('status') == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                                    <option value="Dibayar" {{ request('status') == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            {{-- BUTTON --}}
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('bendahara.konfir') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-hover align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelanggan & Kontak</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rincian Layanan</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durasi Wisata</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Pembayaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelola & Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasis as $reservasi)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $reservasi->nama_pelanggan }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    <a href="mailto:{{ $reservasi->email }}?subject=Konfirmasi Pembayaran Reservasi&body=Halo {{ $reservasi->nama_pelanggan }},%0D%0AKami mendapati bahwa pembayaran Anda belum sesuai (DP). Mohon melakukan pelunasan sesuai ketentuan.%0D%0ATerima kasih."
                                                    class="text-secondary text-decoration-none">
                                                        {{ $reservasi->email }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-xs font-weight-bold text-dark">{{ $reservasi->paketWisata->nama_paket }}</span>
                                            @if($reservasi->penginapan)
                                                <span class="text-xxs text-muted"><i class="fas fa-bed me-1"></i>{{ $reservasi->penginapan->nama_penginapan }}</span>
                                            @else
                                                <span class="text-xxs text-muted italic">Tanpa Penginapan</span>
                                            @endif
                                            <span class="text-xxs text-info font-weight-bold">{{ $reservasi->jumlah_peserta }} Peserta</span>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d M Y') }}
                                            </span>
                                            <i class="fas fa-arrow-down text-xxs my-1 text-light"></i>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($reservasi->tgl_selesai_reservasi)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center">
                                        <span class="text-dark text-sm font-weight-bold">
                                            Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm border
                                            @if($reservasi->status_reservasi == 'Dipesan') border-warning text-warning
                                            @elseif($reservasi->status_reservasi == 'Dibayar') border-info text-info
                                            @elseif($reservasi->status_reservasi == 'Selesai') border-success text-success
                                            @else border-danger text-danger
                                            @endif">
                                            {{ $reservasi->status_reservasi }}
                                        </span>
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                            <form action="{{ route('bendahara.updateStatus', $reservasi->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm shadow-none" 
                                                        style="font-size: 0.75rem; min-width: 110px;" 
                                                        onchange="this.form.submit()">
                                                    <option value="Dipesan" {{ $reservasi->status_reservasi == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                                                    <option value="Dibayar" {{ $reservasi->status_reservasi == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                                                    <option value="Selesai" {{ $reservasi->status_reservasi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </form>
                                            
                                            <a href="{{ asset('storage/' . $reservasi->bukti_tf) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info mb-0 px-3"
                                               data-bs-toggle="tooltip" 
                                               title="Lihat Bukti Transfer">
                                                <i class="fas fa-eye me-1"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('be.footer')
@endsection