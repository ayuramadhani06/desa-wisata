<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penginapan;
use App\Models\ObyekWisata;
use App\Models\KategoriWisata;
use App\Models\PaketWisata;
use App\Models\Diskon;
use App\Models\JenisPembayaran;
use App\Models\Reservasi;

use Illuminate\Support\Facades\Storage;

class BendaharaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bendahara.index', [
            'title' => 'Bendahara' 
        ]);
    }

    function cont1()
    {
        $data = Penginapan::latest()->get();
        return view('bendahara.homestay', [
            'title' => 'Homestay',
            'penginapans' => $data
        ]);
    }

    public function cont2()
    {
        $reservasis = Reservasi::with(['pelanggan', 'paketWisata'])
            ->latest()
            ->get();

        return view('bendahara.konfir', [
            'title' => 'Konfirmasi',
            'reservasis' => $reservasis
        ]);
    }

    public function updateStatusReservasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Dipesan,Dibayar,Selesai,Dibatalkan'
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status_reservasi = $request->status;
        $reservasi->save();

        return back()->with('success', 'Status reservasi berhasil diperbarui');
    }

    public function cont3($id = null)
    {
        $obyekWisatas = ObyekWisata::with('kategori')->latest()->get();
        $kategoriWisatas = KategoriWisata::all();
        $obyekWisata_edit = null;
        $kategori_edit = null;

        if ($id) {
            $obyekWisata_edit = ObyekWisata::findOrFail($id);
        }

        return view('bendahara.obwi', [
            'title' => 'Objek Wisata',
            'obyekWisatas' => $obyekWisatas,
            'kategoriWisatas' => $kategoriWisatas,
            'obyekWisata_edit' => $obyekWisata_edit,
            'kategori_edit' => $kategori_edit
        ]);
    }

    public function storeObyekWisata(Request $request)
    {
        $request->validate([
            'nama_wisata' => 'required|unique:obyek_wisatas|max:255',
            'deskripsi_wisata' => 'required',
            'id_kategori_wisatas' => 'required|exists:kategori_wisatas,id',
            'fasilitas' => 'required',
            'foto1' => 'required|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'foto4' => 'nullable|image|max:2048',
            'foto5' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token']);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                $filename = time() . '_' . $request->file($foto)->getClientOriginalName();
                $request->file($foto)->move(public_path('images/obyek-wisata'), $filename);
                $data[$foto] = $filename;
            }
        }

        ObyekWisata::create($data);

        return redirect('/obwi')->with('success', 'Objek Wisata berhasil ditambahkan.');
    }

    public function updateObyekWisata(Request $request, $id)
    {
        $obyekWisata = ObyekWisata::findOrFail($id);

        $validated = $request->validate([
            'nama_wisata' => 'required|max:255|unique:obyek_wisatas,nama_wisata,'.$id,
            'deskripsi_wisata' => 'required',
            'id_kategori_wisatas' => 'required|exists:kategori_wisatas,id',
            'fasilitas' => 'required',
        ]);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                if ($obyekWisata->$foto && file_exists(public_path('images/obyek-wisata/' . $obyekWisata->$foto))) {
                    unlink(public_path('images/obyek-wisata/' . $obyekWisata->$foto));
                }
                $filename = time() . '_' . $request->file($foto)->getClientOriginalName();
                $request->file($foto)->move(public_path('images/obyek-wisata'), $filename);
                $validated[$foto] = $filename;
            }
        }

        $obyekWisata->update($validated);

        return redirect('/obwi')->with('success', 'Objek Wisata berhasil diperbarui.');
    }

    public function destroyObyekWisata(Request $request)
    {
        $request->validate(['id' => 'required|exists:obyek_wisatas,id']);
        $obyekWisata = ObyekWisata::findOrFail($request->id);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($obyekWisata->$foto && file_exists(public_path('images/obyek-wisata/' . $obyekWisata->$foto))) {
                unlink(public_path('images/obyek-wisata/' . $obyekWisata->$foto));
            }
        }

        $obyekWisata->delete();
        return redirect('/obwi')->with('success', 'Objek Wisata berhasil dihapus.');
    }

    public function storeKategoriWisata(Request $request)
    {
        $request->validate([
            'kategori_wisata' => 'required|unique:kategori_wisatas|max:255',
        ]);

        KategoriWisata::create([
            'kategori_wisata' => $request->kategori_wisata,
        ]);

        return redirect('/obwi')->with('success', 'Kategori Wisata berhasil ditambahkan.');
    }

    public function updateKategoriWisata(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kategori_wisatas,id',
            'kategori_wisata' => 'required|max:255|unique:kategori_wisatas,kategori_wisata,' . $request->id,
        ]);

        $kategori = KategoriWisata::findOrFail($request->id);
        $kategori->update(['kategori_wisata' => $request->kategori_wisata]);

        return redirect('/obwi')->with('success', 'Kategori Wisata berhasil diupdate.');
    }

    public function destroyKategoriWisata(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kategori_wisatas,id',
        ]);

        $kategori = KategoriWisata::findOrFail($request->id);
        
        if ($kategori->obyekWisatas()->count() > 0) {
            return redirect('/obwi')->with('error', 'Kategori ini sedang digunakan dan tidak dapat dihapus.');
        }

        $kategori->delete();
        return redirect('/obwi')->with('success', 'Kategori Wisata berhasil dihapus.');
    }


    public function cont4() { //PAKET WISATA paket wisata
        $paketWisatas = PaketWisata::latest()->get();
        return view('bendahara.pakwis', [
            'title' => 'Paket Wisata',
            'paketWisatas' => $paketWisatas
        ]);
    }

    public function storePaketWisata(Request $request) {
        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'fasilitas' => 'required|max:255',
            'harga_per_pack' => 'required|integer',
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'foto4' => 'nullable|image|max:2048',
            'foto5' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token']);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                $filename = time() . '_' . $request->file($foto)->getClientOriginalName();
                $request->file($foto)->move(public_path('images/paket-wisata'), $filename);
                $data[$foto] = $filename;
            }
        }

        PaketWisata::create($data);

        return back()->with('success', 'Paket Wisata berhasil ditambahkan.');
    }

    public function updatePaketWisata(Request $request, $id) {
        $paketWisata = PaketWisata::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'fasilitas' => 'required|max:255',
            'harga_per_pack' => 'required|integer',
        ]);

        $data = $request->except(['_token']);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                if ($paketWisata->$foto && file_exists(public_path('images/paket-wisata/' . $paketWisata->$foto))) {
                    unlink(public_path('images/paket-wisata/' . $paketWisata->$foto));
                }
                $filename = time() . '_' . $request->file($foto)->getClientOriginalName();
                $request->file($foto)->move(public_path('images/paket-wisata'), $filename);
                $data[$foto] = $filename;
            }
        }

        $paketWisata->update($data);

        return redirect('/pakwis')->with('success', 'Paket Wisata berhasil diperbarui.');
    }

    public function destroyPaketWisata($id) {
        // $request->validate(['id' => 'required|exists:paket_wisatas,id']);
        $paketWisata = PaketWisata::findOrFail($id);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($paketWisata->$foto && file_exists(public_path('images/paket-wisata/' . $paketWisata->$foto))) {
                unlink(public_path('images/paket-wisata/' . $paketWisata->$foto));
            }
        }

        $paketWisata->delete();
        return redirect('/pakwis')->with('success', 'Paket Wisata berhasil dihapus.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //INI PENGINAPAN
    {
        $data = $request->validate([
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'fasilitas' => 'required|string|max:255',
            'foto1' => 'image|mimes:jpg,jpeg,png|max:2048',
            'foto2' => 'image|mimes:jpg,jpeg,png|max:2048',
            'foto3' => 'image|mimes:jpg,jpeg,png|max:2048',
            'foto4' => 'image|mimes:jpg,jpeg,png|max:2048',
            'foto5' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto jika ada
        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                $data[$foto] = $request->file($foto)->store('penginapan', 'public');
            }
        }

        Penginapan::create($data);

        return back()->with('success', 'Homestay berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) //PENGINAPANNN
    {
        $data = Penginapan::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) //PENGINAPAN
    {
        $penginapan = Penginapan::findOrFail($id);

        $data = $request->validate([ 
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'fasilitas' => 'required|string|max:255',
        ]);

        foreach (['foto1', 'foto2', 'foto3', 'foto4', 'foto5'] as $foto) {
            if ($request->hasFile($foto)) {
                $data[$foto] = $request->file($foto)->store('penginapan', 'public');
            }
        }

        $penginapan->update($data);

        return back()->with('success', 'Homestay berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) //PENGINAPAN
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->delete();
        return back()->with('success', 'Homestay berhasil dihapus!');
    }


    public function diskon() //DISKON diskon
    {
        $diskons = Diskon::latest()->get();
        return view('bendahara.diskon', [
            'title' => 'Diskon',
            'diskons' => $diskons
        ]);
    }

    /**
     * Store a new diskon
     */
    public function storeDiskon(Request $request)
    {
        $request->validate([
            'kode_diskon' => 'required|unique:diskons|max:50',
            'nama_diskon' => 'required|max:100',
            'persentase_diskon' => 'required|numeric|between:0,100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', 'foto']);
        $data['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/diskon'), $filename);
            $data['foto'] = $filename;
        }

        Diskon::create($data);

        return redirect('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    
    /**
     * Update an existing diskon
     */
    public function updateDiskon(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $request->validate([
            'kode_diskon' => 'required|max:50|unique:diskons,kode_diskon,'.$id,
            'nama_diskon' => 'required|max:100',
            'persentase_diskon' => 'required|numeric|between:0,100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);
        $data['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($diskon->foto && file_exists(public_path('images/diskon/' . $diskon->foto))) {
                unlink(public_path('images/diskon/' . $diskon->foto));
            }
            
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/diskon'), $filename);
            $data['foto'] = $filename;
        }

        $diskon->update($data);

        return redirect('/diskon')->with('success', 'Diskon berhasil diperbarui.');
    }

    public function editDiskon($id)
    {
        $diskon = Diskon::findOrFail($id);
        return view('bendahara.edit_diskon', [
            'title' => 'Edit Diskon',
            'diskon' => $diskon
        ]);
    }
    /**
     * Delete a diskon
     */
    public function destroyDiskon($id)
    {
        $diskon = Diskon::findOrFail($id);

        // Delete photo if exists
        if ($diskon->foto && file_exists(public_path('images/diskon/' . $diskon->foto))) {
            unlink(public_path('images/diskon/' . $diskon->foto));
        }

        $diskon->delete();
        return redirect('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }



    public function jenispembayaran() //PEMBAYARAN pembayaran
    {
        $jenisPembayarans = JenisPembayaran::latest()->get();
        return view('bendahara.jenispembayaran', [
            'title' => 'Jenis Pembayaran',
            'jenisPembayarans' => $jenisPembayarans
        ]);
    }

    public function storeJenisPembayaran(Request $request)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|max:255',
            'nomor_tf' => 'nullable|max:30',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', 'foto']);

        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/jenispembayaran'), $filename);
            $data['foto'] = $filename;
        }

        JenisPembayaran::create($data);

        return redirect('/jenispembayaran')->with('success', 'Jenis pembayaran berhasil ditambahkan.');
    }

    public function updateJenisPembayaran(Request $request, $id)
    {
        $jenisPembayaran = JenisPembayaran::findOrFail($id);

        $request->validate([
            'jenis_pembayaran' => 'required|max:255',
            'nomor_tf' => 'nullable|max:30',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);

        if ($request->hasFile('foto')) {
            if ($jenisPembayaran->foto && file_exists(public_path('images/jenispembayaran/' . $jenisPembayaran->foto))) {
                unlink(public_path('images/jenispembayaran/' . $jenisPembayaran->foto));
            }
            
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/jenispembayaran'), $filename);
            $data['foto'] = $filename;
        }

        $jenisPembayaran->update($data);

        return redirect('/jenispembayaran')->with('success', 'Jenis pembayaran berhasil diperbarui.');
    }

    public function destroyJenisPembayaran($id)
    {
        $jenisPembayaran = JenisPembayaran::findOrFail($id);

        if ($jenisPembayaran->foto && file_exists(public_path('images/jenispembayaran/' . $jenisPembayaran->foto))) {
            unlink(public_path('images/jenispembayaran/' . $jenisPembayaran->foto));
        }

        $jenisPembayaran->delete();

        return redirect('/jenispembayaran')->with('success', 'Jenis pembayaran berhasil dihapus.');
    }

  
}
