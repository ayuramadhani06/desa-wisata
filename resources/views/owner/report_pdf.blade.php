<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Reservasi Desa Wisata Serangan</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Nama Paket</th>
                <th>Total Bayar</th>
                <th>Tanggal Reservasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $reservation->pelanggan->nama_lengkap }}</td>
                <td>{{ $reservation->paketWisata->nama_paket }}</td>
                <td>Rp{{ number_format($reservation->total_bayar, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
