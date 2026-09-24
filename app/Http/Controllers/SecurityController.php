<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    /**
     * Tampilkan form Ubah Kata Sandi.
     */
    public function editPassword()
    {
        return view('keamanan.ubah-password');
    }

    /**
     * Proses ubah kata sandi.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini yang Anda masukkan tidak sesuai.',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        return redirect()
            ->route('profile.settings', ['tab' => 'keamanan'])
            ->with('status', 'Kata sandi berhasil diperbarui.');
    }

    /**
     * Toggle nyala/mati Verifikasi Dua Langkah.
     */
    public function toggleTwoFactor(Request $request)
    {
        $enabled = $request->boolean('enabled');

        $request->user()->update([
            'two_factor_enabled' => $enabled,
        ]);

        return redirect()
            ->route('profile.settings', ['tab' => 'keamanan'])
            ->with('status', $enabled
                ? 'Verifikasi dua langkah berhasil diaktifkan.'
                : 'Verifikasi dua langkah dinonaktifkan.');
    }
}
