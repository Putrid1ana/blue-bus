<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penumpang_id',
        'tanggal_pemesanan',
        'tujuan',
        'armada_id',
        'bukti_pembayaran',
    ];

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class);
    }

    public function armada()
    {
        return $this->belongsTo(Transportasi::class, 'armada_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'laporan';
}
