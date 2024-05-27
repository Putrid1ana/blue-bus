<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Transportasi;
use App\Models\Penumpang;
use App\Models\Rute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with('penumpang.user', 'armada')->orderBy('created_at', 'desc')->get();
        $penumpang = Penumpang::all();
        $transportasi = Transportasi::all();
        $rute = Rute::all();

        return view('server.laporan.index', compact('laporan', 'transportasi', 'penumpang', 'rute'));
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
            return view('server.transaksi.show', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Data Laporan Tidak Ditemukan!');
        }
    }

    public function edit($id)
    {
        $laporan = Laporan::find($id);
        if (!$laporan) {
            return redirect()->route('transaksi.index')->with('error', 'Data Laporan Tidak Ditemukan!');
        }

        $penumpang = Penumpang::all();
        $transportasi = Transportasi::all();
        $rute = Rute::all();

        return view('server.laporan.edit', compact('laporan', 'penumpang', 'transportasi', 'rute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penumpang_id' => 'required',
            'tanggal_pemesanan' => 'required|date',
            'waktu' => 'required',
            'rute_id' => 'required',
            'armada_id' => 'required',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $laporan = Laporan::find($id);
        if (!$laporan) {
            return redirect()->route('transaksi.index')->with('error', 'Data Laporan Tidak Ditemukan!');
        }

        $laporan->penumpang_id = $request->input('penumpang_id');
        $laporan->tanggal_pemesanan = $request->input('tanggal_pemesanan');
        $laporan->waktu = $request->input('waktu');
        $laporan->rute_id = $request->input('rute_id');
        $laporan->armada_id = $request->input('armada_id');

        if ($request->hasFile('bukti_pembayaran')) {
            $laporan->bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $laporan->save();

        return redirect()->route('transaksi.index')->with('success', 'Laporan berhasil diperbarui.');
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
        $request->validate([
            'penumpang_id' => 'required',
            'tanggal_pemesanan' => 'required|date',
            'waktu' => 'required',
            'rute_id' => 'required',
            'armada_id' => 'required',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf',
        ]);

        $tanggalPemesanan = Carbon::parse($request->input('tanggal_pemesanan'));

        $laporan = new Laporan([
            'penumpang_id' => $request->input('penumpang_id'),
            'tanggal_pemesanan' => $tanggalPemesanan,
            'waktu' => $request->input('waktu'),
            'rute_id' => $request->input('rute_id'),
            'armada_id' => $request->input('armada_id'),
            'bukti_pembayaran' => $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public'),
        ]);

        $laporan->save();

        return redirect()->route('transaksi.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function destroy($id)
{
    $laporan = Laporan::find($id);
    
    if ($laporan) {
        $laporan->delete();
        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    } else {
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }
}
}