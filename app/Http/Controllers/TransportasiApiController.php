<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransportasiResource;
use App\Models\Transportasi;
use Illuminate\Http\Request;

class TransportasiApiController extends Controller
{
    public function index(){
        $trasnportasi = Transportasi::all();
        return TransportasiResource::collection($trasnportasi->loadMissing('trans:id'));
    }

    public function show($id){

        $trasnportasi = Transportasi::findOrFail($id);
        return new TransportasiResource($trasnportasi);
    }
}
