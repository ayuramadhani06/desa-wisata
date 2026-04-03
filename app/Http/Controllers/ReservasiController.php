<?php

// app/Http/Controllers/ReservasiController.php
namespace App\Http\Controllers;

use PDF;
use App\Models\Reservasi;
use App\Models\Diskon;
use App\Models\Pelanggan;
use App\Models\JenisPembayaran;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::with(['pelanggan', 'paketWisata', 'diskon', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);

        return view('fe.reservasi', [
            'title' => 'Daftar Reservasi',
            'reservasis' => $reservasis
        ]);
    }

    public function create($id_paket)
    {
        if (!Auth::check()) {
            return redirect()->route('loginn')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        $pelanggan = Pelanggan::where('id_user', $user->id)->first();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.create')->with('error', 'Lengkapi profil pelanggan terlebih dahulu');
        }

        $paketWisata = PaketWisata::findOrFail($id_paket);
        $diskons = Diskon::all();
        $jenisPembayarans = JenisPembayaran::all();
        $penginapans = Penginapan::all();

        return view('reservasi.index', [
            'title' => 'Buat Reservasi',
            'paket_wisata' => $paketWisata,
            'pelanggan' => $pelanggan,
            'diskons' => $diskons,
            'jenis_pembayarans' => $jenisPembayarans,
            'penginapans' => $penginapans
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_paket' => 'required|exists:paket_wisatas,id',
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'id_diskon' => 'nullable|exists:diskons,id',
            'id_penginapan' => 'nullable|exists:penginapans,id',
            'id_jenis_pembayaran' => 'required|exists:jenis_pembayarans,id',
            'tgl_reservasi_wisata' => 'required|date|after_or_equal:today',
            'tgl_selesai_reservasi' => 'required|date|after:tgl_reservasi_wisata',
            'jumlah_peserta' => 'required|integer|min:1',
            'bukti_tf' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $paketWisata = PaketWisata::find($request->id_paket);
        $diskon = $request->id_diskon ? Diskon::find($request->id_diskon) : null;
        $penginapan = $request->id_penginapan ? Penginapan::find($request->id_penginapan) : null;

        // 1. Hitung durasi menginap (selisih hari)
        $tglMulai = Carbon::parse($request->tgl_reservasi_wisata);
        $tglSelesai = Carbon::parse($request->tgl_selesai_reservasi);
        $durasi = $tglMulai->diffInDays($tglSelesai) ?: 1;

        // 2. Hitung harga paket
        $subtotalPaket = $paketWisata->harga_per_pack * $request->jumlah_peserta;
        
        // 3. Hitung harga penginapan (jika ada)
        $totalHargaPenginapan = $penginapan ? ($penginapan->harga_per_malam * $durasi) : 0;

        // 4. Subtotal Gabungan
        $subtotal = $subtotalPaket + $totalHargaPenginapan;
        
        // 5. Hitung Diskon
        $nilaiDiskon = $diskon ? ($subtotal * $diskon->persentase_diskon / 100) : 0;
        $totalBayar = $subtotal - $nilaiDiskon;

        // Simpan bukti transfer
        $buktiTfPath = $request->file('bukti_tf')->store('public/bukti_tf');

        // Buat reservasi
        $reservasi = Reservasi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_paket' => $request->id_paket,
            'id_diskon' => $request->id_diskon,
            'id_penginapan' => $request->id_penginapan,
            'id_jenis_pembayaran' => $request->id_jenis_pembayaran,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'tgl_reservasi_wisata' => $request->tgl_reservasi_wisata,
            'tgl_selesai_reservasi' => $request->tgl_selesai_reservasi,
            'harga' => $paketWisata->harga_per_pack,
            'harga_penginapan' => $totalHargaPenginapan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'persentase_diskon' => $diskon ? $diskon->persentase_diskon : 0,
            'nilai_diskon' => $nilaiDiskon,
            'subtotal' => $subtotal,
            'total_bayar' => $totalBayar,
            'bukti_tf' => $buktiTfPath,
            'status_reservasi' => 'Dipesan'
        ]);

        return redirect()->route('reservasi.riwayat')
            ->with('success', 'Reservasi berhasil dibuat. Silakan tunggu konfirmasi.');
    }

    public function riwayat()
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('id_user', $user->id)->first();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.create');
        }

        $reservasis = Reservasi::where('id_pelanggan', $pelanggan->id)
            ->with(['paketWisata', 'diskon', 'jenisPembayaran'])
            ->latest()
            ->get();

        return view('reservasi.riwayat', [
            'title' => 'Riwayat Reservasi',
            'reservasis' => $reservasis
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status_reservasi = $request->status;
        $reservasi->save();

        return back()->with('success', 'Status reservasi berhasil diperbarui');
    }

    public function downloadNota($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan', 'diskon', 'jenisPembayaran'])->findOrFail($id);

        // Validasi bahwa hanya pemilik yang boleh download
        if ($reservasi->pelanggan->id_user !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = PDF::loadView('reservasi.nota_pdf', ['reservasi' => $reservasi]);

        return $pdf->download('Nota-Reservasi-' . $reservasi->id . '.pdf');
    }
}