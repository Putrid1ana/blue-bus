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
        'status'
    ];

    // Relasi ke Pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'transportasi_id');
    }

    protected $table = 'transportasi';
}
