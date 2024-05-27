<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'penumpang_id',
        'tanggal_pemesanan',
        'waktu',
        'rute_id',
        'armada_id',
        'bukti_pembayaran',
    ];

    // Tambahkan casting
    protected $casts = [
        'tanggal_pemesanan' => 'date',
    ];

    // Hubungan dengan Penumpang
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class);
    }

    // Hubungan dengan Armada
    public function armada()
    {
        return $this->belongsTo(Transportasi::class, 'armada_id');
    }

    // Hubungan dengan Rute
    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }
}
