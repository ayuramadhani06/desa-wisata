@extends('be.master')
@section ('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item active">
                <a class="nav-link" href="bendahara">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="homestay">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Home Stay</span></a>
            </li> 

            <li class="nav-item">
                <a class="nav-link" href="obwi">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Objek Wisata</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="konfir">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Konfirmasi Reservasi</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="pakwis">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Paket Wisata</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    </div>
@endsection
@section ('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Bendahara</h1>
    @endsection
@section('footer')
    @include('be.footer')
@endsection