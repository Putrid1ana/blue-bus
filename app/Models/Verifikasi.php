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
        'verifikasi'
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

    protected $table = 'transaksi';
}
