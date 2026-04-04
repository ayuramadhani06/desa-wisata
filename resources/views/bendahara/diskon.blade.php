@extends('be.master')
@section('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    @include('be.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Diskon</h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addDiskonModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Diskon
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Diskon</th>
                            <th>Nama Diskon</th>
                            <th>Persentase</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diskons as $diskon)
                        <tr>
                            <td>{{ $diskon->kode_diskon }}</td>
                            <td>{{ $diskon->nama_diskon }}</td>
                            <td>{{ $diskon->persentase_diskon }}%</td>
                            <td>
                                {{ \Carbon\Carbon::parse($diskon->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($diskon->tanggal_berakhir)->format('d M Y') }}
                            </td>
                            <td>
                                @php
                                    $hariIni = \Carbon\Carbon::today();
                                    $tglMulai = $diskon->tanggal_mulai;
                                    $tglSelesai = $diskon->tanggal_berakhir;
                                @endphp

                                @if ($hariIni->between($tglMulai, $tglSelesai))
                                    <span class="badge badge-success">Aktif</span>
                                @elseif ($hariIni->lt($tglMulai))
                                    <span class="badge badge-info">Akan Datang</span>
                                    <small class="d-block text-muted">Mulai dalam {{ $hariIni->diffInDays($tglMulai) }} hari</small>
                                @else
                                    <span class="badge badge-secondary">Kedaluwarsa</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editDiskonModal{{ $diskon->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form id="delete-form-{{ $diskon->id }}" action="{{ route('bendahara.diskon.delete', $diskon->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $diskon->id }}')">
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

<!-- Add Diskon Modal -->
<div class="modal fade" id="addDiskonModal" tabindex="-1" role="dialog" aria-labelledby="addDiskonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiskonModalLabel">Tambah Diskon Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bendahara.diskon.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_diskon">Kode Diskon</label>
                        <input type="text" class="form-control" id="kode_diskon" name="kode_diskon" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_diskon">Nama Diskon</label>
                        <input type="text" class="form-control" id="nama_diskon" name="nama_diskon" required>
                    </div>
                    <div class="form-group">
                        <label for="persentase_diskon">Persentase Diskon (%)</label>
                        <input type="number" step="0.01" class="form-control" id="persentase_diskon" name="persentase_diskon" min="0" max="100" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_berakhir">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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

<!-- Edit Diskon Modals (one for each diskon) -->
@foreach($diskons as $diskon)
<div class="modal fade" id="editDiskonModal{{ $diskon->id }}" tabindex="-1" role="dialog" aria-labelledby="editDiskonModalLabel{{ $diskon->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiskonModalLabel{{ $diskon->id }}">Edit Diskon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bendahara.diskon.update', $diskon->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_kode_diskon{{ $diskon->id }}">Kode Diskon</label>
                        <input type="text" class="form-control" id="edit_kode_diskon{{ $diskon->id }}" name="kode_diskon" value="{{ $diskon->kode_diskon }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_diskon{{ $diskon->id }}">Nama Diskon</label>
                        <input type="text" class="form-control" id="edit_nama_diskon{{ $diskon->id }}" name="nama_diskon" value="{{ $diskon->nama_diskon }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_persentase_diskon{{ $diskon->id }}">Persentase Diskon (%)</label>
                        <input type="number" step="0.01" class="form-control" id="edit_persentase_diskon{{ $diskon->id }}" name="persentase_diskon" value="{{ $diskon->persentase_diskon }}" min="0" max="100" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit_tanggal_mulai{{ $diskon->id }}">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="edit_tanggal_mulai{{ $diskon->id }}" name="tanggal_mulai" value="{{ $diskon->tanggal_mulai->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_tanggal_berakhir{{ $diskon->id }}">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="edit_tanggal_berakhir{{ $diskon->id }}" name="tanggal_berakhir" value="{{ $diskon->tanggal_berakhir->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_deskripsi{{ $diskon->id }}">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi{{ $diskon->id }}" name="deskripsi" rows="3">{{ $diskon->deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_foto{{ $diskon->id }}">Foto (Opsional)</label>
                        <input type="file" class="form-control-file" id="edit_foto{{ $diskon->id }}" name="foto">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        @if($diskon->foto)
                            <div class="mt-2">
                                <p>Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $diskon->foto) }}"  style="max-width: 100px; max-height: 100px;">
                            </div>
                        @endif
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_aktif{{ $diskon->id }}" name="aktif" {{ $diskon->aktif ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_aktif{{ $diskon->id }}">
                            Aktif
                        </label>
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