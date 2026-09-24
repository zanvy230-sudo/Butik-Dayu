<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'whatsapp',
        'tanggal_acara',
        'paket',
        'ulasan',
        'status',
        'ditampilkan',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
        'ditampilkan' => 'boolean',
    ];

    public function labelPaket(): string
    {
        return match ($this->paket) {
            'akad' => 'Paket Akad',
            'resepsi' => 'Paket Resepsi',
            'pre-wedding' => 'Pre-Wedding',
            default => '-',
        };
    }
}
