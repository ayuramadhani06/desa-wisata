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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jenis Pembayaran</h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addJenisPembayaranModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jenis Pembayaran
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jenis Pembayaran</th>
                            <th>Nomor Rekening</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisPembayarans as $jp)
                        <tr>
                            <td>{{ $jp->jenis_pembayaran }}</td>
                            <td>{{ $jp->nomor_tf }}</td>
                            <td>
                                @if($jp->foto)
                                    <img src="/images/jenispembayaran/{{ $jp->foto }}" style="max-width: 100px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editJenisPembayaranModal{{ $jp->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('bendahara.jenispembayaran.delete', $jp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis pembayaran ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Jenis Pembayaran Modal -->
<div class="modal fade" id="addJenisPembayaranModal" tabindex="-1" role="dialog" aria-labelledby="addJenisPembayaranModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJenisPembayaranModalLabel">Tambah Jenis Pembayaran Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bendahara.jenispembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                        <input type="text" class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_tf">Nomor Rekening</label>
                        <input type="text" class="form-control" id="nomor_tf" name="nomor_tf">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto (Opsional)</label>
                        <input type="file" class="form-control-file" id="foto" name="foto">
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

<!-- Edit Jenis Pembayaran Modals -->
@foreach($jenisPembayarans as $jp)
<div class="modal fade" id="editJenisPembayaranModal{{ $jp->id }}" tabindex="-1" role="dialog" aria-labelledby="editJenisPembayaranModalLabel{{ $jp->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJenisPembayaranModalLabel{{ $jp->id }}">Edit Jenis Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bendahara.jenispembayaran.update', $jp->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_jenis_pembayaran{{ $jp->id }}">Jenis Pembayaran</label>
                        <input type="text" class="form-control" id="edit_jenis_pembayaran{{ $jp->id }}" name="jenis_pembayaran" value="{{ $jp->jenis_pembayaran }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nomor_tf{{ $jp->id }}">Nomor Rekening</label>
                        <input type="text" class="form-control" id="edit_nomor_tf{{ $jp->id }}" name="nomor_rekening" value="{{ $jp->nomor_rekening }}">
                    </div>
                    <div class="form-group">
                        <label for="edit_foto{{ $jp->id }}">Foto (Opsional)</label>
                        <input type="file" class="form-control-file" id="edit_foto{{ $jp->id }}" name="foto">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        @if($jp->foto)
                            <div class="mt-2">
                                <p>Foto Saat Ini:</p>
                                <img src="/images/jenispembayaran/{{ $jp->foto }}" style="max-width: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
@section('footer')
    @include('be.footer')
@endsection