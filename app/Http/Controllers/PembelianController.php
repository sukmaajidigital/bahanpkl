<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kriteria;
use App\Models\Pembelian;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pembelian_show',['only' => ['index','show']]);
        $this->middleware('permission:pembelian_create',['only' => ['store']]);
        $this->middleware('permission:pembelian_update',['only' => ['update']]);
    }
    public function index(Request $request)
    {
        $query = Pembelian::with('bahan_baku');

        // Filter berdasarkan tanggal jika tanggal diberikan
        if ($request->has('tanggal')) {
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $query->whereDate('tanggal', $tanggal);
        }

        if ($request->ajax()) {
            $data = $query->get();
            return datatables()->of($data)->make(true);
        }

        $kategori = Kriteria::all();
        return view('pembelian.index', compact('kategori'));
    }

    public function bahanBaku(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = BahanBaku::query();

        if ($searchTerm) {
            $query->where('nama_bahan_baku', 'like', '%' . $searchTerm . '%');
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            // Validasi request
            $validatedData = $request->validate([
                'tanggal' => 'required|date',
                'bahanBaku' => 'required|exists:bahan_baku,id', // Sesuaikan dengan model dan nama tabel Bahan Baku yang Anda gunakan
                'qty' => 'required|numeric',
                'harga_satuan' => 'required|numeric',
                'total_harga' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi
            $errors = $e->validator->errors()->toArray();

            return response()->json(['errors' => $errors], 422);
        }

        // Simpan data ke dalam database
        $pembelian = Pembelian::create([
            'tanggal' => $validatedData['tanggal'],
            'bahan_baku_id' => $validatedData['bahanBaku'],
            'qty' => $validatedData['qty'],
            'harga_satuan' => $validatedData['harga_satuan'],
            'total_harga' => $validatedData['total_harga'],
        ]);

        if (Pengaturan::where('nama', 'stok')->first()->status == 'on') {
            $bahanBaku = BahanBaku::find($validatedData['bahanBaku']);
            $bahanBaku->stok += $validatedData['qty'];
            $bahanBaku->save();
        }

        // Optional: return response success
        return response()->json(['message' => 'Pembelian berhasil disimpan', 'data' => $pembelian]);
    }

    public function bahanBakuStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_bahan_baku' => 'required',
                'satuan' => 'required',
                'kategori_id' => 'required',
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
            'kategori_id' => $request->kategori_id,
        ]);

        return response()->json(['message' => 'Bahan baku berhasil disimpan', 'data' => $bahanBaku]);
    }

    public function edit($id)
    {
        // Ambil data pembelian berdasarkan ID
        $pembelian = Pembelian::with('bahan_baku')->find($id);

        // Kirim data dalam format JSON
        return response()->json($pembelian);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'qty' => 'required|numeric|min:0',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
        ]);

        // Ambil data pembelian berdasarkan ID
        $pembelian = Pembelian::findOrFail($id);

        // Simpan qty lama
        $qtyLama = $pembelian->qty;

        // Update data pembelian
        $pembelian->update([
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->total_harga,
        ]);

        if (Pengaturan::where('nama', 'stok')->first()->status == 'on') {
            // Hitung selisih qty baru dengan qty lama
            $selisihQty = $request->qty - $qtyLama;

            // Ambil data bahan baku
            $bahanBaku = $pembelian->bahan_baku;

            // Sesuaikan stok bahan baku berdasarkan selisih qty
            $bahanBaku->stok -= $selisihQty;

            $bahanBaku->save();
        }

        return response()->json(['status' => 'success']);

    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);

        // Simpan qty lama
        $qtyLama = $pembelian->qty;


        if (Pengaturan::where('nama', 'stok')->first()->status == 'on') {

            // Hitung selisih qty baru dengan qty lama
            $selisihQty = $qtyLama;

            // Ambil data bahan baku
            $bahanBaku = $pembelian->bahan_baku;

            // Sesuaikan stok bahan baku berdasarkan selisih qty
            $bahanBaku->stok -= $selisihQty;

            $bahanBaku->save();
        }

        $pembelian->delete();
        if ($pembelian) {
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
