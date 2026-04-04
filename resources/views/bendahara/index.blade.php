@extends('be.master')
@section ('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    @include('be.sidebar')
@endsection
@section ('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Bendahara</h1>
    </div>

    <div class="alert alert-primary shadow-sm border-left-primary">
        <h5 class="mb-1">Selamat Datang, Bendahara!</h5>
        <p class="mb-0">Semoga harimu menyenangkan 🎉 — Pantau terus transaksi hari ini.</p>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Perlu Konfirmasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['perlu_konfirmasi'] }} Reservasi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Produk Wisata</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_homestay'] + $stats['total_paket'] }} Unit</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Promo/Diskon Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['diskon_aktif'] }} Promo</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Cepat</h6>
                </div>
                <div class="card-body">
                    <p>Klik menu di sidebar untuk melakukan manajemen data objek wisata, penginapan, dan konfirmasi pembayaran pelanggan.</p>
                    <a href="{{ route('bendahara.konfir') }}" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Cek Konfirmasi Reservasi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('be.footer')
@endsection