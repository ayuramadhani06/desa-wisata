@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section('sidebar')
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Halo Owner<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            {{-- <!-- Heading -->
            <div class="sidebar-heading">
                Owner
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>User</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Berita</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    </div>
@endsection
@section('content')
    <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Owner</h1>
                <a href="{{ route('owner.reservasi.pdf') }}" target="_blank" class="btn btn-danger mb-3">
                    <i class="fas fa-file-pdf"></i> Unduh Laporan
                </a>

    <!-- Cards Row -->
    <div class="row">
        <!-- Monthly Income Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pemasukan Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($monthlyIncome, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yearly Income Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan Tahun Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($yearlyIncome, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservations Count Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Reservasi Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats['counts'][count($monthlyStats['counts'])-1] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pelanggan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $customers->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Income Chart -->
        <!-- <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pemasukan 12 Bulan Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Top Customers -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pelanggan Teraktif</h6>
                </div>
                <div class="card-body">
                    @foreach($customers as $customer)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="font-weight-bold">{{ $customer->nama_lengkap }}</span>
                            <span class="badge badge-primary">{{ $customer->reservasis_count }} reservasi</span>
                        </div>
                        <div class="small text-gray-500">{{ $customer->email }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Reservasi Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pelanggan</th>
                                    <th>Paket Wisata</th>
                                    <th>Tanggal</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservation->pelanggan->nama_lengkap }}</td>
                                    <td>{{ $reservation->paketWisata->nama_paket }}</td>
                                    <td>
                                        {{ $reservation->tgl_reservasi_wisata->format('d/m/Y') }} - 
                                        {{ $reservation->tgl_selesai_reservasi->format('d/m/Y') }}
                                    </td>
                                    <td>Rp{{ number_format($reservation->total_bayar, 0, ',', '.') }}</td>
                                    <td>
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