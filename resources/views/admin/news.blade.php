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
                <a class="nav-link" href="admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="userm">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>User Management</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="news">
                    <i class="fas fa-fw fa-table"></i>
                    <span>News</span></a>
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
        <h1 class="h3 mb-4 text-gray-800">Manajemen Berita</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Form Tambah/Edit -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ isset($berita_edit) ? 'Edit Berita' : 'Tambah Berita Baru' }}
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ isset($berita_edit) ? route('admin.news.update', $berita_edit->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($berita_edit))
                        @method('PUT')
                    @endif
                    
                    <div class="form-group">
                        <label for="judul">Judul Berita</label>
                        <input type="text" class="form-control" id="judul" name="judul" 
                            value="{{ $berita_edit->judul ?? old('judul') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="berita">Isi Berita</label>
                        <textarea class="form-control" id="berita" name="berita" rows="5" required>{{ $berita_edit->berita ?? old('berita') }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_post">Tanggal Post</label>
                                <input type="datetime-local" class="form-control" id="tgl_post" name="tgl_post"
                                    value="{{ isset($berita_edit) ? date('Y-m-d\TH:i', strtotime($berita_edit->tgl_post)) : old('tgl_post') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kategori_beritas">Kategori Berita</label>
                                <div class="input-group">
                                    <select class="form-control" id="id_kategori_beritas" name="id_kategori_beritas" required>
                                        @foreach($kategori_beritas as $kategori)
                                            <option value="{{ $kategori->id }}" 
                                                {{ (isset($berita_edit) && $berita_edit->id_kategori_beritas == $kategori->id) ? 'selected' : '' }}>
                                                {{ $kategori->kategori_berita }}
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
                        <label for="foto">Foto Berita</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto" name="foto" {{ !isset($berita_edit) ? 'required' : '' }}>
                            <label class="custom-file-label" for="foto">Pilih file...</label>
                        </div>
                        @if(isset($berita_edit))
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                            <div class="mt-2">
                                <img src="{{ asset('images/berita/' . $berita_edit->foto) }}" width="150" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($berita_edit) ? 'Update Berita' : 'Simpan Berita' }}
                    </button>
                    @if(isset($berita_edit))
                        <a href="{{ route('admin.news') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Daftar Berita -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Berita</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beritas as $berita)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/berita/' . $berita->foto) }}" width="80" class="img-thumbnail">
                                </td>
                                <td>
                                    <strong>{{ $berita->judul }}</strong>
                                    <p class="text-muted small mb-0">{{ Str::limit($berita->berita, 100) }}</p>
                                </td>
                                <td>{{ $berita->kategori->kategori_berita }}</td>
                                <td>{{ \Carbon\Carbon::parse($berita->tgl_post)->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.news.edit', $berita->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.news.delete') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="id" value="{{ $berita->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="kategori_berita">Nama Kategori</label>
                            <input type="text" class="form-control" id="kategori_berita" name="kategori_berita" required>
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