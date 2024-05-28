<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use App\Models\Penumpang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index()
    {
        $transaksi = Verifikasi::with('user', 'transportasi')->get();
        $penumpang = Penumpang::all();
        $transportasi = Transportasi::all();

        return view('verifikasi.index', compact('transaksi', 'transportasi', 'penumpang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:255',
            'penumpang_id' => 'required|exists:penumpang,id',
            'telepon' => 'required|string|max:255',
            'transportasi_id' => 'required|exists:transportasi,id',
            'nomor_kursi' => 'nullable|string',
            'verifikasi' => 'required|boolean'
        ]);

    
        Verifikasi::create([
            'nik' => $validated['nik'],
            'telepon' => $validated['telepon'],
            'penumpang_id' => $validated['penumpang_id'],
            'transportasi_id' => $validated['transportasi_id'],
            'nomor_kursi' => $validated['nomor_kursi'],
            'verifikasi' => $validated['verifikasi'],
        ]);
    
        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = Verifikasi::findOrFail($id);
        $penumpang = Penumpang::all();
        $transportasi = Transportasi::all();

        return view('verifikasi.edit', compact('transaksi', 'penumpang', 'transportasi'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nik' => 'required|string|max:255',
        'penumpang_id' => 'required|exists:penumpang,id',
        'telepon' => 'required|string|max:255',
        'transportasi_id' => 'required|exists:transportasi,id',
        'nomor_kursi' => 'nullable|string',
        'verifikasi' => 'required|boolean'
    ]);

    $transaksi = Verifikasi::findOrFail($id);

    $transaksi->update($validated);

    return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil diperbarui');
}

    public function destroy($id)
    {
        $pemesanan = Verifikasi::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
