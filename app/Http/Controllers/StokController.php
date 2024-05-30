<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:stok_show',['only' => ['index','show']]);
        $this->middleware('permission:stok_update',['only' => ['update']]);
    }
    public function index()
    {
        $stok = BahanBaku::where('stok', '>', 0)->get();
        return view('stok.index', compact('stok'));
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::find($id);
        // Kirim data dalam format JSON
        return response()->json($bahanBaku);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'stok' => 'required|numeric|min:0',
        ]);

        // Ambil data pengeluaran berdasarkan ID
        $bahanBaku = BahanBaku::find($id);
        $bahanBaku->update([
            'stok' => $request->stok,
        ]);

        return response()->json(['status' => 'success']);
    }
}
