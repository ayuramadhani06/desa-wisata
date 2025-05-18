<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.index', [
            'title' => 'Admin'
        ]);
    }

    function con1()
    {
        $karyawans = Karyawan::with('user')->get();
        return view('admin.userm', [
            'title' => 'User Management',
            'karyawans' => $karyawans
        ]);
    }

    function con2($id = null)
    {
        $beritas = Berita::with('kategori')->latest()->get();
        $kategori_beritas = KategoriBerita::all();
        $berita_edit = null;
    
        if ($id) {
            $berita_edit = Berita::findOrFail($id);
        }
    
        return view('admin.news', [
            'title' => 'Berita & Kategori',
            'beritas' => $beritas,
            'kategori_beritas' => $kategori_beritas,
            'berita_edit' => $berita_edit
        ]);
    }

    public function newsStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'berita' => 'required',
            'tgl_post' => 'required|date',
            'id_kategori_beritas' => 'required|exists:kategori_beritas,id',
            'foto' => 'required|image',
        ]);

        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/berita'), $filename);
        }

        Berita::create([
            'judul' => $request->judul,
            'berita' => $request->berita,
            'tgl_post' => $request->tgl_post,
            'id_kategori_beritas' => $request->id_kategori_beritas,
            'foto' => $filename,
        ]);

        return redirect('/news')->with('success', 'Berita berhasil ditambahkan.');
    }
    
    public function newsUpdate(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|max:255|unique:beritas,judul,'.$id,
            'berita' => 'required',
            'tgl_post' => 'required|date',
            'id_kategori_beritas' => 'required|exists:kategori_beritas,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        // berita yang akan diupdate
        $berita = Berita::findOrFail($id);

        // Handle upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($berita->foto && file_exists(public_path('images/berita/' . $berita->foto))) {
                unlink(public_path('images/berita/' . $berita->foto));
            }
            
            // Upload foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/berita'), $filename);
            $validated['foto'] = $filename;
        }

        // Update data berita
        $berita->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.news')->with('success', 'Berita berhasil diperbarui');
    }

    public function newsDelete(Request $request)
    {
        $request->validate(['id' => 'required|exists:beritas,id']);
        $berita = Berita::findOrFail($request->id);

        if ($berita->foto && file_exists(public_path('images/berita/' . $berita->foto))) {
            unlink(public_path('images/berita/' . $berita->foto));
        }

        $berita->delete();
        return redirect('/news')->with('success', 'Berita berhasil dihapus.');
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'kategori_berita' => 'required|unique:kategori_beritas|max:255',
        ]);

        KategoriBerita::create([
            'kategori_berita' => $request->kategori_berita,
        ]);

        return redirect('/news')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kategori_beritas,id',
            'kategori_berita' => 'required|max:255|unique:kategori_beritas,kategori_berita,' . $request->id,
        ]);

        $kategori = KategoriBerita::findOrFail($request->id);
        $kategori->update(['kategori_berita' => $request->kategori_berita]);

        return redirect('/news')->with('success', 'Kategori berhasil diupdate.');
    }

    public function kategoriDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:kategori_beritas,id',
        ]);

        KategoriBerita::destroy($request->id);

        return redirect('/news')->with('success', 'Kategori berhasil dihapus.');
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
    public function store(Request $request) //INI USER MANAGEMENT
    {
        $request->validate([
            'nama_karyawan' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'no_hp' => 'required|max:15',
            'jabatan' => 'required|in:administrasi,bendahara,pemilik',
            // 'status' => 'required|in:aktif, banned',
            // 'aktif' => 'sometimes|boolean'
        ]);
    
        try {
            DB::beginTransaction();
            
            $levelMapping = [
                'administrasi' => 'admin',
                'bendahara' => 'bendahara',
                'pemilik' => 'pemilik'
            ];
        
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $levelMapping[$request->jabatan],
                'aktif' => 1,
            ]);
        
            Karyawan::create([
                'nama_karyawan' => $request->nama_karyawan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'status' => 'aktif',
                'id_user' => $user->id,
            ]);
            
            DB::commit();
        
            return redirect('/userm')->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/userm')->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyawan = Karyawan::findOrFail($id);
    
        $request->validate([
            'nama_karyawan' => 'required',
            'email' => 'required|email|unique:users,email,'.$karyawan->id_user,
            'alamat' => 'required',
            'no_hp' => 'required|max:15',
            'jabatan' => 'required|in:administrasi,bendahara,pemilik',
            // 'status' => 'required|in:aktif, banned',
            'aktif' => 'required|boolean'
        ]);

        try {
            DB::beginTransaction();
            
            $karyawan = Karyawan::with('user')->findOrFail($id);
            
            // Mapping jabatan ke level user
            $levelMapping = [
                'administrasi' => 'admin',
                'bendahara' => 'bendahara',
                'pemilik' => 'pemilik'
            ];
    
            // Update karyawan
            $karyawan->update([
                'nama_karyawan' => $request->nama_karyawan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'status' => $request->aktif ? 'aktif' : 'banned',
            ]);
    
            // Update user terkait
            if ($karyawan->user) {
                $userData = [
                    'email' => $request->email,
                    'level' => $levelMapping[$request->jabatan],
                    'aktif' => $request->aktif
                ];
                
                if ($request->password) {
                    $userData['password'] = Hash::make($request->password);
                }
                
                $karyawan->user->update($userData);
            }
            
            DB::commit();
            
            return redirect('/userm')->with('success', 'Karyawan berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/userm')->with('error', 'Gagal mengupdate karyawan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function banned(string $id)
    {
        try {
            DB::beginTransaction();
            
            $karyawan = Karyawan::with('user')->findOrFail($id);
            
            // Update status karyawan
            $karyawan->update(['status' => 'banned']);
            
            // Update status user terkait
            if ($karyawan->user) {
                $karyawan->user->update(['aktif' => 0]);
            }
            
            DB::commit();
            
            return redirect('/userm')->with('success', 'Karyawan berhasil dibanned.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/userm')->with('error', 'Gagal melakukan banned: ' . $e->getMessage());
        }
    }
}
