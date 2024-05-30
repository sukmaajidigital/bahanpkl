<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kriteria;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PengeluaranKasirController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kriteria::find(4); // Ambil objek Kriteria dengan ID 4

        $query = Pembelian::with('bahan_baku');

        // Filter berdasarkan tanggal jika tanggal diberikan
        if ($request->has('tanggal')) {
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $query->whereDate('tanggal', $tanggal);
        }

        if ($request->ajax()) {
            $data = $query->whereHas('bahan_baku', function ($q) use ($kategori) {
                $q->where('kategori_id', $kategori->id); // Gunakan $kategori->id untuk mendapatkan nilai ID
            })->get();
            return datatables()->of($data)->make(true);
        }

        $kategory = Kriteria::all();
        return view('pengeluaranKasir.index', compact('kategory'));
    }

    public function barangStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_bahan_baku' => 'required',
                'satuan' => 'required',
            ],[
                'required' => ':attribute harus diisi',
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi
            $errors = $e->validator->errors()->toArray();

            return response()->json(['errors' => $errors], 422);
        }

        $bahanBaku = BahanBaku::create([
            'nama_bahan_baku' => $request->nama_bahan_baku,
            'satuan' => $request->satuan,
            'kategori_id' => 4,
        ]);

        return response()->json(['message' => 'Barang berhasil disimpan', 'data' => $bahanBaku]);
    }
}
