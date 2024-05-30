<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kategori_show',['only' => ['index','show']]);
        $this->middleware('permission:kategori_create',['only' => ['create','store']]);
        $this->middleware('permission:kategori_update',['only' => ['edit','update']]);
        $this->middleware('permission:kategori_delete',['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kriteria::all();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_kategori' => 'required'
        ], [
            'nama_kategori.required' => 'Kategori harus diisi'
        ]);

        Kriteria::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kriteria::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kriteria::findOrFail($id);
        $validation = $request->validate([
            'nama_kategori' => 'required'
        ], [
            'nama_kategori.required' => 'Kategori harus diisi'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kriteria::find($id);
        $kategori->delete();
        if ($kategori) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
