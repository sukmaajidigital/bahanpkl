<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahanBakuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bahan_show',['only' => ['index','show']]);
        $this->middleware('permission:bahan_create',['only' => ['create','store']]);
        $this->middleware('permission:bahan_update',['only' => ['edit','update']]);
        $this->middleware('permission:bahan_delete',['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanbaku = BahanBaku::all();
        return view('bahanbaku.index', compact('bahanbaku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kriteria::all();
        return view('bahanbaku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_bahan_baku' => 'required',
            'satuan' => 'required',
            'kategori_id' => 'required',
        ], [
            'required' => ':attribute harus diisi',
        ]);

        BahanBaku::create([
            'nama_bahan_baku' => $request->nama_bahan_baku,
            'satuan' => $request->satuan,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('bahanbaku.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
        $bahanbaku = BahanBaku::find($id);
        $kategori = Kriteria::all();
        return view('bahanbaku.edit', compact('bahanbaku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bahanbaku = BahanBaku::find($id);

        $validation = $request->validate([
            'nama_bahan_baku' => 'required',
            'satuan' => 'required',
            'kategori_id' => 'required',
        ], [
            'required' => ':attribute harus diisi',
        ]);

        $bahanbaku->update([
            'nama_bahan_baku' => $request->nama_bahan_baku,
            'satuan' => $request->satuan,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('bahanbaku.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bahanbaku = BahanBaku::find($id);
        $bahanbaku->delete();
        if ($bahanbaku) {
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
