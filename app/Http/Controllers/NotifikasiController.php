<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function data(Request $request)
    {
        $filter = $request->validate([
            'filter' => ['nullable', 'in:all,unread,read'],
        ])['filter'] ?? 'all';

        $notifications = $this->queryForUser($request, $filter)
            ->latest()
            ->take(50)
            ->get()
            ->map(fn (Notifikasi $notifikasi) => [
                'id' => $notifikasi->id,
                'judul' => $notifikasi->judul,
                'pesan' => $notifikasi->pesan,
                'url' => $notifikasi->url ?: '#',
                'icon' => $notifikasi->icon,
                'dibaca' => (bool) $notifikasi->dibaca_at,
                'waktu' => $notifikasi->created_at?->diffForHumans(),
            ]);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notifikasi::where('user_id', $request->user()->id)->belumDibaca()->count(),
        ]);
    }

    public function markAsRead(Request $request, Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->user_id === $request->user()->id, 404);
        $notifikasi->update(['dibaca_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->user_id === $request->user()->id, 404);
        $notifikasi->delete();

        if (! $request->expectsJson()) {
            return back()->with('status', 'Notifikasi berhasil dihapus.');
        }

        return response()->json(['success' => true]);
    }

    private function queryForUser(Request $request, string $filter)
    {
        return Notifikasi::where('user_id', $request->user()->id)
            ->when($filter === 'unread', fn ($query) => $query->belumDibaca())
            ->when($filter === 'read', fn ($query) => $query->whereNotNull('dibaca_at'));
    }
}