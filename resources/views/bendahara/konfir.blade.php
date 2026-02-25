@extends('be.master')
@section ('navbar')
    @include('be.navbar')
@endsection
@section ('sidebar')
    @include('be.sidebar')
@endsection
@section ('content')
  <div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelanggan</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Paket Wisata</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Bayar</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-secondary opacity-7">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasis as $reservasi)
            <tr>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $reservasi->nama_pelanggan }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $reservasi->email }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">{{ $reservasi->paketWisata->nama_paket }}</p>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                        {{ $reservasi->tgl_reservasi_wisata->format('d/m/Y') }} - 
                        {{ $reservasi->tgl_selesai_reservasi->format('d/m/Y') }}
                    </span>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                        Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                    </span>
                </td>
                <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm 
                        @if($reservasi->status_reservasi == 'Dipesan') bg-gradient-warning
                        @elseif($reservasi->status_reservasi == 'Dibayar') bg-gradient-info
                        @elseif($reservasi->status_reservasi == 'Selesai') bg-gradient-success
                        @else bg-gradient-danger
                        @endif">
                        {{ $reservasi->status_reservasi }}
                    </span>
                </td>
                <td class="align-middle">
                    <form action="{{ route('bendahara.updateStatus', $reservasi->id) }}" method="POST" class="d-inline">
                        @csrf
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="Dipesan" {{ $reservasi->status_reservasi == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                            <option value="Dibayar" {{ $reservasi->status_reservasi == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="Selesai" {{ $reservasi->status_reservasi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $reservasi->status_reservasi == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </form>
                    <a href="{{ asset('storage/' . $reservasi->bukti_tf) }}" target="_blank" 
                       class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat Bukti TF">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('footer')
    @include('be.footer')
@endsection