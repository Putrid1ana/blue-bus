<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;


    protected $fillable = [
        'nik',
        'penumpang_id',
        'telepon',
        'transportasi_id',
        'nomor_kursi',
        'sisa_kursi'
    ];

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class, 'transportasi_id');
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

    protected $table = 'transaksi';
}
