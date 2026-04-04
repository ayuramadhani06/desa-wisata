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
        
        <p><strong>Penginapan:</strong> {{ $reservasi->penginapan->nama_penginapan ?? 'Tidak ada penginapan' }}</p>
        
        <p><strong>Tanggal Reservasi:</strong> {{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse($reservasi->tgl_selesai_reservasi)->format('d F Y') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $reservasi->jenisPembayaran->jenis_pembayaran }}</p>
        <p><strong>Status Reservasi:</strong> {{ ucfirst($reservasi->status_reservasi) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Rincian Layanan</th> <th>Harga/Unit</th>
                <th>Qty/Durasi</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Paket: {{ $reservasi->paketWisata->nama_paket }}</td>
                <td>Rp {{ number_format($reservasi->harga, 0, ',', '.') }}</td>
                <td>{{ $reservasi->jumlah_peserta }} Orang</td>
                <td>Rp {{ number_format($reservasi->harga * $reservasi->jumlah_peserta, 0, ',', '.') }}</td>
            </tr>

            @if($reservasi->id_penginapan)
            <tr>
                <td>Penginapan: {{ $reservasi->penginapan->nama_penginapan }}</td>
                <td>
                    @php
                        $tglMulai = \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata);
                        $tglSelesai = \Carbon\Carbon::parse($reservasi->tgl_selesai_reservasi);
                        $durasi = $tglMulai->diffInDays($tglSelesai) ?: 1;
                        $hargaPerMalam = $reservasi->penginapan->harga_per_malam;
                    @endphp
                    Rp {{ number_format($hargaPerMalam, 0, ',', '.') }}
                </td>
                <td>{{ $durasi }} Malam</td>
                <td>Rp {{ number_format($reservasi->harga_penginapan, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total Harga</strong></td>
                <td>Rp {{ number_format($reservasi->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Diskon</strong></td>
                <td>
                    @if($reservasi->nilai_diskon > 0)
                        - Rp {{ number_format($reservasi->nilai_diskon, 0, ',', '.') }} ({{ $reservasi->persentase_diskon }}%)
                    @else
                        0
                    @endif
                </td>
            </tr>
            <tr class="total">
                <td colspan="3" style="text-align: right;"><strong>Total Bayar</strong></td>
                <td>Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</td>
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
