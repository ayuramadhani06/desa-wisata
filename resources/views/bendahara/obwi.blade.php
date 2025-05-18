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
@section ('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Manajemen Objek Wisata</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Form Tambah/Edit -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ isset($obyekWisata_edit) ? 'Edit Objek Wisata' : 'Tambah Objek Wisata Baru' }}
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ isset($obyekWisata_edit) ? route('bendahara.obwi.update', $obyekWisata_edit->id) : route('bendahara.obwi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($obyekWisata_edit))
                        @method('PUT')
                    @endif
                    
                    <div class="form-group">
                        <label for="nama_wisata">Nama Objek Wisata</label>
                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" 
                            value="{{ $obyekWisata_edit->nama_wisata ?? old('nama_wisata') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi_wisata">Deskripsi Wisata</label>
                        <textarea class="form-control" id="deskripsi_wisata" name="deskripsi_wisata" rows="5" required>{{ $obyekWisata_edit->deskripsi_wisata ?? old('deskripsi_wisata') }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3" required>{{ $obyekWisata_edit->fasilitas ?? old('fasilitas') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kategori_wisatas">Kategori Wisata</label>
                                <div class="input-group">
                                    <select class="form-control" id="id_kategori_wisatas" name="id_kategori_wisatas" required>
                                        @foreach($kategoriWisatas as $kategori)
                                            <option value="{{ $kategori->id }}" 
                                                {{ (isset($obyekWisata_edit) && $obyekWisata_edit->id_kategori_wisatas == $kategori->id) ? 'selected' : '' }}>
                                                {{ $kategori->kategori_wisata }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#kategoriModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Objek Wisata</label>
                        <div class="row">
                            @for($i = 1; $i <= 5; $i++)
                                @php 
                                    $fotoField = 'foto'.$i;
                                    $currentFoto = isset($obyekWisata_edit) ? $obyekWisata_edit->$fotoField : null;
                                @endphp
                                <div class="col-md-4 mb-3">
                                    <label>Foto {{ $i }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="{{ $fotoField }}" name="{{ $fotoField }}" {{ $i == 1 && !isset($obyekWisata_edit) ? 'required' : '' }}>
                                        <label class="custom-file-label" for="{{ $fotoField }}">Pilih file...</label>
                                    </div>
                                    @if($currentFoto)
                                        <div class="mt-2">
                                            <img src="{{ asset('images/obyek-wisata/' . $currentFoto) }}" width="100" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                        @if(isset($obyekWisata_edit))
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($obyekWisata_edit) ? 'Update Objek Wisata' : 'Simpan Objek Wisata' }}
                    </button>
                    @if(isset($obyekWisata_edit))
                        <a href="{{ route('bendahara.obwi') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Daftar Objek Wisata -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Objek Wisata</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wisata</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obyekWisatas as $index => $obyek)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $obyek->nama_wisata }}</td>
                                <td>{{ $obyek->kategori->kategori_wisata ?? '-' }}</td>
                                <td>{{ Str::limit($obyek->deskripsi_wisata, 50) }}</td>
                                <td>
                                    @if($obyek->foto1)
                                        <img src="{{ asset('images/obyek-wisata/' . $obyek->foto1) }}" width="80" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('bendahara.obwi.edit', $obyek->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('bendahara.obwi.delete') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="id" value="{{ $obyek->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus objek wisata ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('bendahara.kategori.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="kategori_wisata">Nama Kategori</label>
                            <input type="text" class="form-control" id="kategori_wisata" name="kategori_wisata" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('be.footer')
@endsection