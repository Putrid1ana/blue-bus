<?php

namespace App\Http\Controllers;

use App\Http\Resources\AkunResource;
use Illuminate\Http\Request;
use App\Models\Penumpang;
use App\Models\Transportasi;

class AkunApiController extends Controller
{
    public function index(){
        $akun = Penumpang::all();
        return AkunResource::collection($akun);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:penumpang',
            'password' => 'required|string|min:8',
        ]);

        $penumpang = Penumpang::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
        return new AkunResource($penumpang); 
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:penumpang,username,'.$id,
            'password' => 'required|string|min:8',
        ]);
    
        $akun = Penumpang::findOrFail($id);
        $akun->name = $validated['name'];
        $akun->username = $validated['username'];
        $akun->password = bcrypt($validated['password']); // Pastikan Anda telah mengimpor bcrypt() di sini
        $akun->save();
    
        return new AkunResource($akun);
    }

    public function destroy($id){
        $akun = Penumpang::findOrFail($id);
        $akun->delete();

        return new AkunResource($akun); 
    }

}
