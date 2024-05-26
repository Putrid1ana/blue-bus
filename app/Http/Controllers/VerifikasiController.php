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
            'user_id' => 'required|exists:users,id',
            'transportasi_id' => 'required|exists:transportasi,id',
            'sisa_kursi' => 'required|numeric',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPembayaran = null;
        if ($request->hasFile('bukti_pembayaran')) {
            Log::info('File uploaded: ', [$request->file('bukti_pembayaran')]);
            $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        Verifikasi::create([
            'user_id' => $validated['user_id'],
            'transportasi_id' => $validated['transportasi_id'],
            'sisa_kursi' => $validated['sisa_kursi'],
            'bukti_pembayaran' => $buktiPembayaran,
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
            'user_id' => 'required|exists:users,id',
            'transportasi_id' => 'required|exists:transportasi,id',
            'sisa_kursi' => 'required|numeric',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        $transaksi = Verifikasi::findOrFail($id);
    
        // Jika ada pembaruan pada bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus bukti pembayaran lama jika ada
            if ($transaksi->bukti_pembayaran) {
                Storage::disk('public')->delete($transaksi->bukti_pembayaran);
            }
            $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        } else {
            // Jangan mengubah nilai bukti_pembayaran jika tidak ada file yang diunggah
            unset($validated['bukti_pembayaran']);
        }
    
        $transaksi->update($validated);
    
        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pemesanan = Verifikasi::findOrFail($id);
        if ($pemesanan->bukti_pembayaran) {
            Storage::disk('public')->delete($pemesanan->bukti_pembayaran);
        }
        $pemesanan->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
