<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use Illuminate\Http\Request;

class PenumpangController extends Controller
{
    /**
     * Menampilkan daftar penumpang.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penumpang = Penumpang::all();
        return view('penumpang.index', compact('penumpang'));
    }

    /**
     * Menampilkan formulir untuk membuat penumpang baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penumpang.create');
    }

    /**
     * Menyimpan penumpang baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:penumpang',
            'password' => 'required|string|min:8',
        ]);

        Penumpang::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('penumpang.index')
                         ->with('success', 'Penumpang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail penumpang.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penumpang = Penumpang::findOrFail($id);
        return view('penumpang.show', compact('penumpang'));
    }

    // Metode lainnya seperti edit, update, dan destroy dapat ditambahkan di sini
    public function edit($id)
{
    $penumpang = Penumpang::findOrFail($id);
    return view('penumpang.edit', compact('penumpang'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:penumpang,username,'.$id,
        'password' => 'required|string|min:8',
    ]);

    $penumpang = Penumpang::findOrFail($id);

    $penumpang->update([
        'name' => $request->name,
        'username' => $request->username,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('penumpang.index')
                     ->with('success', 'Penumpang berhasil diperbarui.');
}

public function destroy($id)
{
    $penumpang = Penumpang::findOrFail($id);
    $penumpang->delete();

    return redirect()->route('penumpang.index')
                     ->with('success', 'Penumpang berhasil dihapus.');
}

}
