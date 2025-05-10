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
        <h1 class="h3 mb-0 text-gray-800">Daftar Homestay</h1>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Homestay
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        @foreach ($penginapans as $p)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $p->nama_penginapan }}
                            </div>
                            <div class="mb-2">
                                @if($p->foto1)
                                    <img src="{{ asset('storage/'.$p->foto1) }}" class="img-fluid rounded mb-2" alt="{{ $p->nama_penginapan }}" style="max-height: 150px; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-light text-center p-3 mb-2" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                        <span class="text-muted">No image available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-1 text-sm text-gray-800" style="max-height: 60px; overflow: hidden;">
                                {{ $p->deskripsi }}
                            </div>
                            <div class="mb-2">
                                <small class="font-weight-bold">Fasilitas:</small>
                                <div class="text-xs text-gray-600">
                                    {{ $p->fasilitas }}
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $p->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('homestay.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit untuk item {{ $p->id }} -->
        <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('homestay.update', $p->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Homestay</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Penginapan</label>
                            <input type="text" name="nama_penginapan" class="form-control" value="{{ old('nama_penginapan', $p->nama_penginapan) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $p->deskripsi) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Fasilitas</label>
                            <textarea name="fasilitas" class="form-control" rows="2" required>{{ old('fasilitas', $p->fasilitas) }}</textarea>
                            <small class="form-text text-muted">Pisahkan setiap fasilitas dengan koma</small>
                        </div>
                        <div class="form-group">
                            <label>Foto 1 (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="foto1" class="form-control-file mb-2">
                            @if($p->foto1)
                                <img src="{{ asset('storage/'.$p->foto1) }}" width="120" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Foto 2 (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="foto2" class="form-control-file mb-2">
                            @if($p->foto2)
                                <img src="{{ asset('storage/'.$p->foto2) }}" width="120" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Foto 3 (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="foto3" class="form-control-file mb-2">
                            @if($p->foto3)
                                <img src="{{ asset('storage/'.$p->foto3) }}" width="120" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Foto 4 (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="foto4" class="form-control-file mb-2">
                            @if($p->foto4)
                                <img src="{{ asset('storage/'.$p->foto4) }}" width="120" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Foto 5 (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="foto5" class="form-control-file mb-2">
                            @if($p->foto5)
                                <img src="{{ asset('storage/'.$p->foto5) }}" width="120" class="img-thumbnail">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('homestay.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Homestay Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Penginapan</label>
                    <input type="text" name="nama_penginapan" class="form-control" placeholder="Nama Penginapan" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi homestay" required></textarea>
                </div>
                <div class="form-group">
                    <label>Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="2" placeholder="Fasilitas yang tersedia" required></textarea>
                    <small class="form-text text-muted">Pisahkan setiap fasilitas dengan koma</small>
                </div>
                @for ($i = 1; $i <= 5; $i++)
                <div class="form-group">
                    <label>Foto {{ $i }}</label>
                    <input type="file" name="foto{{ $i }}" class="form-control-file">
                </div>
                @endfor
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
@endsection
@section('footer')
    @include('be.footer')
@endsection