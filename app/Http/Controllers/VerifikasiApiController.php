<?php

namespace App\Http\Controllers;

use App\Http\Resources\VerifikasiResource;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use App\Models\Transportasi;


class VerifikasiApiController extends Controller
{
    public function index(){
        $verifikasi = Verifikasi::all();
        return VerifikasiResource::collection($verifikasi);
    }
    
    public function store(Request  $request){
        $request->validate([
            'nik' => 'required|string|max:255',
            'penumpang_id' => 'required|exists:penumpang,id',
            'telepon' => 'required|string|max:255',
            'transportasi_id' => 'required|exists:transportasi,id',
            'nomor_kursi' => 'nullable|string',
            'sisa_kursi' => 'required|integer'
        ]);
    
        $verifikasi = Verifikasi::create([
            'nik' => $request->nik,
            'telepon' => $request->telepon,
            'penumpang_id' => $request->penumpang_id,
            'transportasi_id' => $request->transportasi_id,
            'nomor_kursi' => $request->nomor_kursi,
            'sisa_kursi' => $request->sisa_kursi
        ]);
        return new VerifikasiResource($verifikasi);
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:255',
            'penumpang_id' => 'required|exists:penumpang,id',
            'telepon' => 'required|string|max:255',
            'transportasi_id' => 'required|exists:transportasi,id',
            'nomor_kursi' => 'nullable|string',
            'sisa_kursi' => 'required|integer'
        ]);
    
        $verifikasi = Verifikasi::findOrFail($id);
        $verifikasi->nik = $validated['nik'];
        $verifikasi->telepon = $validated['telepon'];
        $verifikasi->penumpang_id = $validated['penumpang_id'];
        $verifikasi->transportasi_id = $validated['transportasi_id'];
        $verifikasi->nomor_kursi = $validated['nomor_kursi'];
        $verifikasi->sisa_kursi = $validated['sisa_kursi'];
        $verifikasi->save();
    
        return new VerifikasiResource($verifikasi);
    }
    
    public function destroy($id){ // Mengubah 'destory' menjadi 'destroy'
        $verifikasi = Verifikasi::findOrFail($id);
        $verifikasi->delete();
    
        return new VerifikasiResource($verifikasi);
    }

    public function i(Request $request){
        
        $trans = Transportasi::findOrFail($request->id_trans);
        $sisakursisekarang = $trans->sisa_kursi - 1;
    
        $trans->sisa_kursi = $sisakursisekarang;
        $trans->save();
    
        $penumpang = Verifikasi::create([
            'id_penumpang' => $request->id_penumpang

        ]);
    
    }
    
}    