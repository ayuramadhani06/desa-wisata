@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('content')
    <div class="container-fluid">

        <!-- TITLE -->
        <h1 class="h3 mb-3 text-gray-800">Dashboard Owner</h1>

        <!-- WELCOME -->
        <div class="alert alert-primary shadow-sm mb-4">
            <h5 class="mb-1">Selamat Datang, Owner!</h5>
            <small>Semoga harimu menyenangkan 🎉</small>
        </div>

        <!-- FILTER + ACTION -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row align-items-end">

                        <div class="col-md-3">
                            <label>Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">-- Semua Status --</option>
                                <option value="Dipesan" {{ request('status') == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                                <option value="Dibayar" {{ request('status') == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('owner.index') }}" class="btn btn-secondary">
                                Reset
                            </a>

                            <a href="{{ route('owner.reservasi.pdf', [
                                'start_date' => request('start_date'),
                                'end_date' => request('end_date'),
                                'status' => request('status')
                            ]) }}" target="_blank" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Unduh Laporan
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- STATS -->
        <div class="row">

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pemasukan Bulan Ini
                            </div>
                            <div class="h5 font-weight-bold text-gray-800">
                                Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                            </div>
                        </div>
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan Tahun Ini
                            </div>
                            <div class="h5 font-weight-bold text-gray-800">
                                Rp{{ number_format($yearlyIncome, 0, ',', '.') }}
                            </div>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Reservasi
                            </div>
                            <div class="h5 font-weight-bold text-gray-800">
                                {{ $totalReservasi }}
                            </div>
                        </div>
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- PAKET & OBYEK -->
        <div class="row">

            <!-- PAKET -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Paket Wisata</h6>
                    </div>
                    <div class="card-body">

                        @forelse($paketWisatas as $paket)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="font-weight-bold">{{ $paket->nama_paket }}</div>
                                <small class="text-success">
                                    Rp{{ number_format($paket->harga_per_pack,0,',','.') }}
                                </small>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada data</small>
                        @endforelse

                    </div>
                </div>
            </div>

            <!-- OBYEK -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Objek Wisata</h6>
                    </div>
                    <div class="card-body">

                        @forelse($obyekWisatas as $obyek)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="font-weight-bold">{{ $obyek->nama_wisata }}</div>
                                <small class="text-muted">
                                    {{ Str::limit($obyek->deskripsi_wisata, 60) }}
                                </small>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada data</small>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Reservasi Terbaru</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">

                        <thead class="thead-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td>{{ $reservation->pelanggan->nama_lengkap }}</td>

                                <td>{{ $reservation->paketWisata->nama_paket }}</td>

                                <td class="text-center">
                                    {{ $reservation->tgl_reservasi_wisata->format('d/m/Y') }} <br>
                                    <small class="text-muted">s/d</small><br>
                                    {{ $reservation->tgl_selesai_reservasi->format('d/m/Y') }}
                                </td>

                                <td class="text-success font-weight-bold">
                                    Rp{{ number_format($reservation->total_bayar, 0, ',', '.') }}
                                </td>

                                <td class="text-center">
                                    <span class="badge 
                                        @if($reservation->status_reservasi == 'Dipesan') badge-warning
                                        @elseif($reservation->status_reservasi == 'Dibayar') badge-primary
                                        @elseif($reservation->status_reservasi == 'Selesai') badge-success
                                        @else badge-danger
                                        @endif">
                                        {{ $reservation->status_reservasi }}
                                    </span>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Income Chart
var ctx = document.getElementById('incomeChart').getContext('2d');
var incomeChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($monthlyStats['months']),
        datasets: [{
            label: 'Pemasukan',
            data: @json($monthlyStats['incomes']),
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
            tension: 0.3
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp' + context.raw.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endscript
@endsection
@section('footer')
    @include('be.footer')
@endsection