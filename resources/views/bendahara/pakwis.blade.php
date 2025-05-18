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
              <div class="sidebar-brand-text mx-3">Halo Bendahara<sup></sup></div>
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
              Bendahara
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

          <li class="nav-item">
            <a class="nav-link" href="diskon">
                <i class="fas fa-fw fa-table"></i>
                <span>Diskon</span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="jenispembayaran">
                <i class="fas fa-fw fa-table"></i>
                <span>Jenis Pembayaran</span></a>
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
@section('content')
<!-- Button to Add Paket Wisata -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paket Wisata</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-1"></i> Tambah Paket
        </button>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
    </div>
    @endif

    <!-- Tabel Paket Wisata -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-alt me-2"></i>Daftar Paket Wisata
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th style="width: 20%">Nama Paket</th>
                            <th style="width: 25%">Deskripsi</th>
                            <th class="text-end" style="width: 10%">Harga</th>
                            <th style="width: 20%">Fasilitas</th>
                            <th class="text-center" style="width: 10%">Foto</th>
                            <th class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paketWisatas as $index => $paket)
                        <tr>
                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <strong>{{ $paket->nama_paket }}</strong>
                            </td>
                            <td class="align-middle">
                                <div class="text-truncate" style="max-width: 300px">
                                    {{ $paket->deskripsi }}
                                </div>
                            </td>
                            <td class="text-end align-middle">
                                {{ number_format($paket->harga_per_pack, 0, ',', '.') }}
                            </td>
                            <td class="align-middle">
                                <div class="text-truncate" style="max-width: 250px">
                                    {{ $paket->fasilitas }}
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                @if($paket->foto1)
                                    <img src="{{ asset('images/paket-wisata/' . $paket->foto1) }}" 
                                         width="50" height="50" 
                                         class="img-thumbnail rounded" 
                                         alt="{{ $paket->nama_paket }}">
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $paket->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $paket->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $paket->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ url('/pakwis/' . $paket->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Paket Wisata</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama_paket" class="form-label">Nama Paket</label>
                                                <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="{{ $paket->nama_paket }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $paket->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga_per_pack" class="form-label">Harga per Pack</label>
                                                <input type="number" class="form-control" id="harga_per_pack" name="harga_per_pack" value="{{ $paket->harga_per_pack }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                                <input type="text" class="form-control" id="fasilitas" name="fasilitas" value="{{ $paket->fasilitas }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto1" class="form-label">Foto 1</label>
                                                <input type="file" class="form-control" id="foto1" name="foto1">
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto2" class="form-label">Foto 2</label>
                                                <input type="file" class="form-control" id="foto2" name="foto2">
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto3" class="form-label">Foto 3</label>
                                                <input type="file" class="form-control" id="foto3" name="foto3">
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto4" class="form-label">Foto 4</label>
                                                <input type="file" class="form-control" id="foto4" name="foto4">
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto5" class="form-label">Foto 5</label>
                                                <input type="file" class="form-control" id="foto5" name="foto5">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $paket->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('bendahara.pakwis.delete', $paket->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Hapus Paket Wisata</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus paket <strong>{{ $paket->nama_paket }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('/pakwis/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Paket Wisata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga_per_pack" class="form-label">Harga per Pack</label>
                            <input type="number" class="form-control" id="harga_per_pack" name="harga_per_pack" required>
                        </div>
                        <div class="mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <input type="text" class="form-control" id="fasilitas" name="fasilitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto1" class="form-label">Foto 1</label>
                            <input type="file" class="form-control" id="foto1" name="foto1">
                        </div>
                        <div class="mb-3">
                            <label for="foto2" class="form-label">Foto 2</label>
                            <input type="file" class="form-control" id="foto2" name="foto2">
                        </div>
                        <div class="mb-3">
                            <label for="foto3" class="form-label">Foto 3</label>
                            <input type="file" class="form-control" id="foto3" name="foto3">
                        </div>
                        <div class="mb-3">
                            <label for="foto4" class="form-label">Foto 4</label>
                            <input type="file" class="form-control" id="foto4" name="foto4">
                        </div>
                        <div class="mb-3">
                            <label for="foto5" class="form-label">Foto 5</label>
                            <input type="file" class="form-control" id="foto5" name="foto5">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah Paket</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footer')
    @include('be.footer')
@endsection