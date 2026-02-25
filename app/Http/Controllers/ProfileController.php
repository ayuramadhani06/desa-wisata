<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pelanggan;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        try {
            $user = Auth::user();
            
            // Jika pelanggan belum ada, buat data default
            if (!$user->pelanggan) {
                $pelanggan = new Pelanggan([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name ?? 'Pelanggan',
                    'no_telepon' => '',
                    'alamat' => '',
                    'foto' => null
                ]);
                $pelanggan->save();
                $user->refresh(); // Refresh untuk load relasi baru
            }

            return view('profile.edit', [
                'user' => $user,
                'pelanggan' => $user->pelanggan,
                'title' => 'Edit Profile',
            ]);
            
        } catch (\Exception $e) {
            // Untuk debugging, tampilkan error
            dd('Error in ProfileController@edit: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Update user
            $user->update(['email' => $validated['email']]);

            // Data pelanggan
            $pelangganData = [
                'nama_lengkap' => $validated['nama_lengkap'],
                'no_telepon' => $validated['no_telepon'],
                'alamat' => $validated['alamat']
                
            ];

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->pelanggan->foto) {
                    Storage::delete('public/' . $user->pelanggan->foto);
                }
                
                // Simpan foto baru
                $path = $request->file('foto')->store('pelanggan', 'public');
                $pelangganData['foto'] = $path; // Simpan path relatif
            }

            $user->pelanggan->update($pelangganData);

            return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profile: ' . $e->getMessage());
        }
    }
}