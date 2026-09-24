<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'whatsapp',
        'produk_slug',
        'rating',
        'komentar',
        'foto',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * URL foto ulasan yang bisa langsung dipakai di <img src="">,
     * atau null kalau ulasan ini tidak menyertakan foto.
     */
    public function fotoUrl(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}