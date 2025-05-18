<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Resmi Reservasi Wisata</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            font-size: 14px;
            color: #000;
            line-height: 1.8;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            font-style: italic;
            font-size: 13px;
            margin-top: 5px;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
        }

        .total {
            font-weight: bold;
            color: #000;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-style: italic;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature p {
            margin-bottom: 60px;
        }

        .signature strong {
            display: block;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Nota Resmi Reservasi Wisata</h1>
        <p>Dokumen ini dicetak sebagai bukti sah atas reservasi layanan wisata</p>
    </div>

    <div class="info">
        <p><strong>Nama Pelanggan:</strong> {{ $reservasi->nama_pelanggan }}</p>
        <p><strong>Email:</strong> {{ $reservasi->email }}</p>
        <p><strong>Paket Wisata:</strong> {{ $reservasi->paketWisata->nama_paket }}</p>
        <p><strong>Tanggal Reservasi:</strong> {{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse($reservasi->tgl_selesai_reservasi)->format('d F Y') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $reservasi->jenisPembayaran->jenis_pembayaran }}</p>
        <p><strong>Status Reservasi:</strong> {{ ucfirst($reservasi->status_reservasi) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Harga per Peserta</th>
                <th>Jumlah Peserta</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                <td>{{ $reservasi->jumlah_peserta }}</td>
                <td>Rp {{ number_format($reservasi->subtotal, 0, ',', '.') }}</td>
                <td>
                    @if($reservasi->diskon)
                        {{ $reservasi->persentase_diskon }}% (Rp {{ number_format($reservasi->nilai_diskon, 0, ',', '.') }})
                    @else
                        -
                    @endif
                </td>
                <td class="total">Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada tanggal {{ \Carbon\Carbon::now()->format('d F Y, H:i') }}</p>
    </div>

    <div class="signature">
        <p>Hormat kami,</p>
        <strong>Panitia Pelaksana Wisata</strong>
    </div>

</body>
</html>
