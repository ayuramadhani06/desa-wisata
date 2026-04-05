<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f2f2f2; text-align: center; }
        h2 { text-align: center; margin-bottom: 5px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h2>LAPORAN RESERVASI<br>Desa Wisata Serangan</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Pelanggan</th>
            <th>Paket</th>
            <th>Peserta</th>
            <th>Tanggal Wisata</th>
            <th>Penginapan</th>
            <th>Diskon</th>
            <th>Subtotal</th>
            <th>Total Bayar</th>
            <th>Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $r)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>

            <td>
                {{ $r->pelanggan->nama_lengkap }}<br>
                <small>{{ $r->email }}</small>
            </td>

            <td>{{ $r->paketWisata->nama_paket }}</td>

            <td class="text-center">{{ $r->jumlah_peserta }} org</td>

            <td class="text-center">
                {{ \Carbon\Carbon::parse($r->tgl_reservasi_wisata)->format('d/m/Y') }} <br>
                s/d <br>
                {{ \Carbon\Carbon::parse($r->tgl_selesai_reservasi)->format('d/m/Y') }}
            </td>

            <td>
                @if($r->penginapan)
                    {{ $r->penginapan->nama_penginapan }}<br>
                    <small>Rp{{ number_format($r->harga_penginapan,0,',','.') }}</small>
                @else
                    -
                @endif
            </td>

            <td>
                @if($r->diskon)
                    {{ $r->persentase_diskon }}% <br>
                    <small>-Rp{{ number_format($r->nilai_diskon,0,',','.') }}</small>
                @else
                    -
                @endif
            </td>

            <td>
                Rp{{ number_format($r->subtotal,0,',','.') }}
            </td>

            <td>
                <strong>Rp{{ number_format($r->total_bayar,0,',','.') }}</strong>
            </td>

            <td>
                {{ $r->jenisPembayaran->jenis_pembayaran ?? '-' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>