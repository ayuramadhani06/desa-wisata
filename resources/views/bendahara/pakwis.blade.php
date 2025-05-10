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
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Paket Wisata</h1>
         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Tambahkan Paket Wisata</a>
        </div>
    </div>
  <div class="row">
    <div class="col-md-7 mt-4">
      <div class="card">
        <div class="card-header pb-0 px-3">
          <h6 class="mb-0">Billing Information</h6>
        </div>
        <div class="card-body pt-4 p-3">
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Oliver Liam</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
              </div>
            </li>
            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Lucas Harper</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Stone Tech Zone</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">lucas@stone-tech.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
              </div>
            </li>
            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Ethan James</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Fiber Notion</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">ethan@fiber.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')
    @include('be.footer')
@endsection