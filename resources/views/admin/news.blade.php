@extends('be.master')
@section ('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    @include('be.sidebar')
@endsection
@section ('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
            <button class="btn btn-sm btn-primary shadow-sm" type="button" data-toggle="collapse" data-target="#collapseFormBerita">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Berita Baru
            </button>
        </div>

        <div class="collapse mb-4" id="collapseFormBerita">
            <div class="card shadow">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-plus-circle"></i> Form Input Berita Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Judul Berita</label>
                            <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul berita..." required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Isi Berita</label>
                            <textarea class="form-control" name="berita" rows="5" placeholder="Tuliskan isi berita..." required>{{ old('berita') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Tanggal Publish</label>
                                    <input type="datetime-local" class="form-control" name="tgl_post" value="{{ old('tgl_post') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Kategori</label>
                                    <div class="input-group">
                                        <select class="form-control" name="id_kategori_beritas" required>
                                            <option value="" disabled selected>-- Pilih Kategori --</option>
                                            @foreach($kategori_beritas as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->kategori_berita }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#kategoriModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto Berita</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="foto" required>
                                <label class="custom-file-label">Pilih gambar...</label>
                            </div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="fas fa-save"></i> Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"></i> Daftar Berita</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.news') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Pilih Tanggal</label>
                            <input type="date" name="filter_date" class="form-control"
                                value="{{ request('filter_date') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('admin.news') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th width="10%">Foto</th>
                                <th>Informasi</th>
                                <th width="15%">Kategori</th>
                                <th width="15%">Waktu</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beritas as $berita)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $berita->foto) }}" width="80" height="60" style="object-fit: cover;" class="rounded border">
                                </td>
                                <td>
                                    <div class="font-weight-bold text-primary">{{ $berita->judul }}</div>
                                    <small class="text-muted">{{ Str::limit($berita->berita, 60) }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info p-2">{{ $berita->kategori->kategori_berita }}</span>
                                </td>
                                <td class="small">
                                    {{ \Carbon\Carbon::parse($berita->tgl_post)->translatedFormat('d M Y') }}<br>
                                    <span class="text-muted"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($berita->tgl_post)->format('H:i') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#editModal{{ $berita->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form id="delete-form-{{ $berita->id }}" action="{{ route('admin.news.delete') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $berita->id }}">
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm" onclick="confirmDelete('delete-form-{{ $berita->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $berita->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content border-left-warning shadow">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title font-weight-bold text-warning"><i class="fas fa-edit"></i> Edit Berita</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.news.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Judul Berita</label>
                                                    <input type="text" class="form-control" name="judul" value="{{ $berita->judul }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Isi Berita</label>
                                                    <textarea class="form-control" name="berita" rows="5" required>{{ $berita->berita }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Tanggal Publish</label>
                                                            <input type="datetime-local" class="form-control" name="tgl_post" value="{{ date('Y-m-d\TH:i', strtotime($berita->tgl_post)) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Kategori</label>
                                                            <select class="form-control" name="id_kategori_beritas" required>
                                                                @foreach($kategori_beritas as $kategori)
                                                                    <option value="{{ $kategori->id }}" {{ $berita->id_kategori_beritas == $kategori->id ? 'selected' : '' }}>
                                                                        {{ $kategori->kategori_berita }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold d-block">Foto Saat Ini</label>
                                                    <img src="{{ asset('storage/' . $berita->foto) }}" width="150" class="img-thumbnail mb-2 border-warning">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="foto">
                                                        <label class="custom-file-label">Ganti foto (biarkan kosong jika tidak diubah)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal text-white">Tutup</button>
                                                <button type="submit" class="btn btn-warning shadow-sm text-dark font-weight-bold">Update Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-left-primary">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary">Tambah Kategori Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="kategori_berita" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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