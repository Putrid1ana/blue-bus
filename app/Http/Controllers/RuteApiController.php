<?php

namespace App\Http\Controllers;

use App\Http\Resources\RuteResource;
use Illuminate\Http\Request;
use App\Models\Rute;
use App\Models\Transportasi;

class RuteApiController extends Controller
{
    public function index(){
        $rute = Rute::all();
        return RuteResource::collection($rute->loadMissing('trans:id,name,kode'));
    }

    public function show($id)
    {
        $rute = Rute::with('trans:id,name,kode')->findOrFail($id);
        return new RuteResource($rute);
    }
}
