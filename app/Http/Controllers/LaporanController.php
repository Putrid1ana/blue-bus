<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Transportasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with('rute.transportasi', 'penumpang.user')->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $transportasi = Transportasi::all();

        return view('server.laporan.index', compact('pemesanan', 'users', 'transportasi'));
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
        $data = Pemesanan::with('rute.transportasi', 'penumpang')->where('kode', $id)->first();
        if ($data) {
            return view('server.laporan.show', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Kode Transaksi Tidak Ditemukan!');
        }
    }

    public function pembayaran($id)
    {
        Pemesanan::find($id)->update([
            'status' => 'Sudah Bayar',
            'petugas_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Pembayaran Ticket Success!');
    }

    public function history()
    {
        $pemesanan = Pemesanan::with('rute.transportasi')->where('penumpang_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('client.history', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tujuan' => 'required|string|max:255',
            'transportasi_id' => 'required|exists:transportasi,id',
            'harga' => 'required|numeric',
            'pembayaran' => 'required|string|max:255',
        ]);

        // Simpan data pemesanan
        Pemesanan::create([
            'penumpang_id' => $request->user_id,
            'rute_id' => $request->transportasi_id,
            'tujuan' => $request->tujuan,
            'harga' => $request->harga,
            'transaksi' => $request->pembayaran,
        ]);

        // Redirect atau berikan respon
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }
}
