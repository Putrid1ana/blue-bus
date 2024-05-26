<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penumpang;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with('penumpang.user', 'armada')->orderBy('created_at', 'desc')->get();
        $penumpang = Penumpang::all();
        $transportasi = Transportasi::all();

        return view('server.laporan.index', compact('laporan', 'transportasi', 'penumpang'));
    }

    public function petugas()
    {
        return view('client.petugas');
    }

    public function kode(Request $request)
    {
        return redirect()->route('transaksi.show', $request->kode);
    }

    public function show($id)
    {
        $data = Laporan::with('penumpang', 'armada')->find($id);
        if ($data) {
            return view('server.laporan.show', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Data Laporan Tidak Ditemukan!');
        }
    }

    public function pembayaran($id)
    {
        $laporan = Laporan::find($id);
        if ($laporan) {
            $laporan->update([
                'status' => 'Sudah Bayar',
                'petugas_id' => Auth::id()
            ]);
            return redirect()->back()->with('success', 'Pembayaran Tiket Berhasil!');
        } else {
            return redirect()->back()->with('error', 'Data Laporan Tidak Ditemukan!');
        }
    }

    public function history()
    {
        $laporan = Laporan::with('armada')->where('penumpang_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('client.history', compact('laporan'));
    }

    public function store(Request $request)
{
    // Validasi data input
    $validated = $request->validate([
        'penumpang_id' => 'required|exists:penumpangs,id',
        'tujuan' => 'required|string|max:255',
        'armada_id' => 'required|exists:transportasis,id',
        'bukti_pembayaran' => 'required|file|mimes:jpeg,png,pdf,txt|max:2048',
    ]);

    // Simpan data laporan
    $bukti_pembayaran = $request->file('bukti_pembayaran');
    $bukti_pembayaran_path = $bukti_pembayaran->store('bukti_pembayaran');

    Laporan::create([
        'penumpang_id' => $validated['penumpang_id'],
        'tanggal_pemesanan' => now(),
        'tujuan' => $validated['tujuan'],
        'armada_id' => $validated['armada_id'],
        'bukti_pembayaran' => $bukti_pembayaran_path,
    ]);

    // Redirect atau berikan respon
    return redirect()->route('transaksi.index')->with('success', 'Laporan berhasil ditambahkan.');
}
}