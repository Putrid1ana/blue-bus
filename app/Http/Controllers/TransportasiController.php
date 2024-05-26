<?php

namespace App\Http\Controllers;

use App\Models\Transportasi;
use Illuminate\Http\Request;

class TransportasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transportasi = Transportasi::orderBy('kode')->orderBy('name')->get();
        return view('server.transportasi.index', compact('transportasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('server.transportasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'kode' => 'required',
            'jumlah' => 'required|integer',
            'kapasitas_bis' => 'required|integer',
            'status' => 'required|boolean'
        ]);

        Transportasi::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'kode' => strtoupper($request->kode),
                'jumlah' => $request->jumlah,
                'kapasitas_bis' => $request->kapasitas_bis,
                'status' => $request->status
            ]
        );

        return redirect()->route('transportasi.index')->with('success', 'Success Add/Update Transportasi!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transportasi = Transportasi::find($id);
        return view('server.transportasi.show', compact('transportasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transportasi = Transportasi::find($id);
        return view('server.transportasi.edit', compact('transportasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'kode' => 'required',
            'jumlah' => 'required|integer',
            'kapasitas_bis' => 'required|integer',
            'status' => 'required|boolean'
        ]);

        $transportasi = Transportasi::find($id);
        $transportasi->update([
            'name' => $request->name,
            'kode' => strtoupper($request->kode),
            'jumlah' => $request->jumlah,
            'kapasitas_bis' => $request->kapasitas_bis,
            'status' => $request->status
        ]);

        return redirect()->route('transportasi.index')->with('success', 'Success Update Transportasi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transportasi::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete Transportasi!');
    }
}
