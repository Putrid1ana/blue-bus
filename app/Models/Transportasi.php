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
        'sisa_kursi',
        'category_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function pemesanan()
    {
        return $this->hasMany('App\Models\Pemesanan', 'transportasi_id');
    }

    public function hitungSisaKursi()
    {
        // Hitung jumlah total kursi yang sudah dipesan
        $jumlahDipesan = $this->pemesanan()->count();

        // Hitung sisa kursi
        $sisaKursi = $this->jumlah - $jumlahDipesan;

        return $sisaKursi;
    }

    protected $table = 'transportasi';
}
