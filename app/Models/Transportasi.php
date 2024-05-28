<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kode',
        'jumlah',
        'kapasitas_bis',
        'sisa_kursi',
        'status'
    ];

    // Relasi ke Pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'transportasi_id');
    }

    // Menghitung sisa kursi berdasarkan jumlah kursi yang dipesan
    public function hitungSisaKursi()
    {
        // Hitung jumlah total kursi yang sudah dipesan
        $jumlahDipesan = $this->pemesanan()->sum('jumlah_kursi');

        // Hitung sisa kursi
        $sisaKursi = $this->jumlah - $jumlahDipesan;

        return $sisaKursi;
    }

    protected $table = 'transportasi';
}
