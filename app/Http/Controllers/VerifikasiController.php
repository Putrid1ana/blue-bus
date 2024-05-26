<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use App\Models\User;

class VerifikasiController extends Controller
{
    public function index()
    {
        $transaksi = Verifikasi::with('user', 'transportasi')->get();
        $users = User::all();
        $transportasi = Transportasi::all();

        return view('verifikasi.index', compact('transaksi', 'users', 'transportasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'transportasi_id' => 'required|exists:transportasi,id',
            'sisa_kursi' => 'required|integer',
            'pembayaran' => 'required|numeric',
        ]);

        Verifikasi::create($validated);

        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $transaksi = Verifikasi::findOrFail($id);
        $users = User::all();
        $transportasi = Transportasi::all();

        return view('verifikasi.edit', compact('transaksi', 'users', 'transportasi'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'transportasi_id' => 'required|exists:transportasi,id',
            'sisa_kursi' => 'required|integer',
            'pembayaran' => 'required|numeric',
        ]);

        $transaksi = Verifikasi::findOrFail($id);
        $transaksi->update($validated);

        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaksi = Verifikasi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}