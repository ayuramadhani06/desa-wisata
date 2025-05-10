<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    
    public function showForm()
    {
        return view('fe.register');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image'
        ]);
    
        DB::transaction(function() use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => 'pelanggan', 
                'aktif' => 1
            ]);
            

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pelanggan', 'public');
            }

            Pelanggan::create([
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_user' => $user->id,
                'foto' => $fotoPath
            ]);
            Auth::login($user); // Login otomatis
        });
        

        return redirect('/')->with('success', 'Berhasil daftar, silakan login!');
    }


    protected function redirectTo()
    {
        if (auth()->user()->level == 'admin') {
            return '/admin';
        } elseif (auth()->user()->level == 'bendahara') {
            return '/bendahara';
        } elseif (auth()->user()->level == 'pemilik') {
            return '/pemilik';
        } elseif (auth()->user()->level == 'pelanggan') {
            return '/'; // Halaman home web desa wisata
        }

        // Fallback kalau level tidak dikenali
        return '/loginn';
    }


    function logout(){
        Auth::logout();
        return redirect('/')->with('success', 'Berhasil logout.');
    }

}

?>