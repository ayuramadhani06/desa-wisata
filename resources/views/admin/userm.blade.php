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
                <div class="sidebar-brand-text mx-3">Halo Admin<sup></sup></div>
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
                Admin
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
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#tambahModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Karyawan
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Karyawan</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <div class="dropdown-header">Aksi:</div>
                        <a class="dropdown-item" href="#"><i class="fas fa-file-export mr-2"></i>Export Data</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-filter mr-2"></i>Filter Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawans as $index => $karyawan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $karyawan->nama_karyawan }}</td>
                                <td>
                                    <a href="mailto:{{ $karyawan->user->email ?? '#' }}" class="text-primary">
                                        <i class="fas fa-envelope mr-1"></i> {{ $karyawan->user->email ?? '-' }}
                                    </a>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;" title="{{ $karyawan->alamat }}">
                                    {{ $karyawan->alamat }}
                                </td>
                                <td>
                                    <a href="tel:{{ $karyawan->no_hp }}" class="text-success">
                                        <i class="fas fa-phone-alt mr-1"></i> {{ $karyawan->no_hp }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($karyawan->jabatan == 'administrasi') badge-info
                                        @elseif($karyawan->jabatan == 'bendahara') badge-warning
                                        @else badge-primary
                                        @endif">
                                        {{ ucfirst($karyawan->jabatan) }}
                                    </span>
                                </td>
                                <td>
                                    @if($karyawan->user && $karyawan->user->aktif)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Banned</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $karyawan->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($karyawan->user && $karyawan->user->aktif)
                                            <form action="{{ route('admin.userm.banned', $karyawan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button onclick="return confirm('Yakin ingin banned akun ini?')" class="btn btn-sm btn-danger" title="Banned">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled title="Sudah dibanned">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $karyawan->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $karyawan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editModalLabel{{ $karyawan->id }}">
                                                <i class="fas fa-user-edit mr-2"></i>Edit Data Karyawan
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.userm.update', $karyawan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Nama Karyawan</label>
                                                            <input type="text" name="nama_karyawan" class="form-control" 
                                                                value="{{ $karyawan->nama_karyawan }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Email</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                                </div>
                                                                <input type="email" name="email" class="form-control" 
                                                                    value="{{ $karyawan->user->email ?? '' }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Password (Kosongkan jika tidak diubah)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                                </div>
                                                                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong untuk tidak mengubah">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Alamat</label>
                                                            <textarea name="alamat" class="form-control" rows="2" required>{{ $karyawan->alamat }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">No HP</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                                                </div>
                                                                <input type="text" name="no_hp" class="form-control" 
                                                                    value="{{ $karyawan->no_hp }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Jabatan</label>
                                                            <select name="jabatan" class="form-control" required>
                                                                <option value="administrasi" {{ $karyawan->jabatan == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                                                <option value="bendahara" {{ $karyawan->jabatan == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                                                <option value="pemilik" {{ $karyawan->jabatan == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Status</label>
                                                            <select name="aktif" class="form-control">
                                                                <option value="1" {{ $karyawan->user && $karyawan->user->aktif ? 'selected' : '' }}>Aktif</option>
                                                                <option value="0" {{ !$karyawan->user || !$karyawan->user->aktif ? 'selected' : '' }}>Banned</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i> Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                                </button>
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

        <!-- Tambah Modal -->
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="tambahModalLabel">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Karyawan Baru
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nama Karyawan</label>
                                        <input type="text" name="nama_karyawan" class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">No HP</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            </div>
                                            <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Jabatan</label>
                                        <select name="jabatan" class="form-control selectpicker" required>
                                            <option value="">-- Pilih Jabatan --</option>
                                            <option value="administrasi">Administrasi</option>
                                            <option value="bendahara">Bendahara</option>
                                            <option value="pemilik">Pemilik</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('be.footer')
@endsection