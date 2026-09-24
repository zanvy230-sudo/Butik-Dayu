<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    /**
     * Tampilkan form tambah alamat baru.
     */
    public function create()
    {
        return view('alamat.create');
    }

    public function edit(Request $request, Alamat $alamat)
    {
        abort_if($alamat->user_id !== $request->user()->id, 403);

        return view('alamat.edit', [
            'alamat' => $alamat,
        ]);
    }

    public function update(Request $request, Alamat $alamat)
    {
        abort_if($alamat->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'nama_penerima'  => ['required', 'string', 'max:255'],
            'telepon'        => ['required', 'string', 'max:20'],
            'alamat_lengkap' => ['required', 'string', 'max:1000'],
            'jadikan_utama'  => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('jadikan_utama')) {
            Alamat::where('user_id', $request->user()->id)->update(['is_utama' => false]);
        }

        $alamat->update([
            'nama_penerima'  => $validated['nama_penerima'],
            'telepon'        => $validated['telepon'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'is_utama'       => $request->boolean('jadikan_utama') || $alamat->is_utama,
        ]);

        return redirect()->route('profile.settings', ['tab' => 'alamat'])
            ->with('status', 'Alamat berhasil diperbarui.');
    }

    /**
     * Simpan alamat baru milik user yang sedang login.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima'  => ['required', 'string', 'max:255'],
            'telepon'        => ['required', 'string', 'max:20'],
            'alamat_lengkap' => ['required', 'string', 'max:1000'],
            'jadikan_utama'  => ['nullable', 'boolean'],
        ]);

        $user = $request->user();
        $jadikanUtama = $request->boolean('jadikan_utama');

        // Kalau ini alamat PERTAMA user, otomatis jadi alamat utama,
        // walau checkbox tidak dicentang.
        $sudahPunyaAlamat = Alamat::where('user_id', $user->id)->exists();
        if (! $sudahPunyaAlamat) {
            $jadikanUtama = true;
        }

        // Kalau alamat baru ini dijadikan utama, lepas status utama dari alamat lain.
        if ($jadikanUtama) {
            Alamat::where('user_id', $user->id)->update(['is_utama' => false]);
        }

        Alamat::create([
            'user_id'        => $user->id,
            'nama_penerima'  => $validated['nama_penerima'],
            'telepon'        => $validated['telepon'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'is_utama'       => $jadikanUtama,
        ]);

        return redirect()->route('profile.settings')
            ->with('status', 'Alamat baru berhasil ditambahkan.')
            ->with('active_tab', 'alamat');
    }

    /**
     * Jadikan salah satu alamat sebagai alamat utama.
     */
    public function setUtama(Request $request, Alamat $alamat)
    {
        abort_if($alamat->user_id !== $request->user()->id, 403);

        Alamat::where('user_id', $request->user()->id)->update(['is_utama' => false]);
        $alamat->update(['is_utama' => true]);

        return back()->with('status', 'Alamat utama berhasil diperbarui.');
    }
}
