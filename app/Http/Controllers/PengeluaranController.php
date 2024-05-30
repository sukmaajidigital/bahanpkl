<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kriteria;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengeluaran_show',['only' => ['index','show']]);
        $this->middleware('permission:pengeluaran_create',['only' => ['store']]);
        $this->middleware('permission:pengeluaran_update',['only' => ['update']]);
    }
    public function index(Request $request)
    {
        $query = Pengeluaran::with('bahan_baku');

        if ($request->has('tanggal')) {
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $query->whereDate('tanggal', $tanggal);
        }

        if ($request->ajax()) {
            $data = $query->get();
            return datatables()->of($data)->make(true);
        }
        return view('pengeluaran.index');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tanggal' => 'required|date',
                'bahanBaku' => 'required|exists:bahan_baku,id',
                'qty' => 'required|numeric',
                'keterangan' => 'required|string',
            ]);

            // Memeriksa stok cukup atau tidak
            $bahanBaku = BahanBaku::find($validatedData['bahanBaku']);
            if ($bahanBaku->stok < $validatedData['qty']) {
                return response()->json(['status' => 'error', 'message' => 'Stok tidak mencukupi.']);
            }

            // Jika stok mencukupi, simpan pengeluaran dan kurangi stok
            $pengeluaran = new Pengeluaran([
                'tanggal' => $validatedData['tanggal'],
                'bahan_baku_id' => $validatedData['bahanBaku'],
                'qty' => $validatedData['qty'],
                'keterangan' => $validatedData['keterangan'],
            ]);

            $pengeluaran->save();

            // Kurangi stok pada model BahanBaku yang sesuai
            $bahanBaku->stok -= $validatedData['qty'];
            $bahanBaku->save();

            return response()->json(['status' => 'success']);
        } catch (ValidationException $e) {
            // Tangani error validasi
            $errors = $e->validator->errors()->toArray();

            return response()->json(['status' => 'validation_error', 'errors' => $errors], 422);
        } catch (\Exception $e) {
            // Tangani error lainnya, mungkin lempar exception atau tampilkan pesan kesalahan.
            // Misalnya:
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan pengeluaran.'], 500);
        }
    }

    public function edit($id)
    {
        // Ambil data pengeluaran berdasarkan ID
        $pengeluaran = Pengeluaran::with('bahan_baku')->find($id);

        // Kirim data dalam format JSON
        return response()->json($pengeluaran);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'qty' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Ambil data pengeluaran berdasarkan ID
        $pengeluaran = Pengeluaran::findOrFail($id);

        // Simpan qty lama
        $qtyLama = $pengeluaran->qty;

        // Update data pengeluaran
        $pengeluaran->update([
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
        ]);

        // Hitung selisih qty baru dengan qty lama
        $selisihQty = $request->qty - $qtyLama;

        // Ambil data bahan baku
        $bahanBaku = $pengeluaran->bahan_baku;

        // Sesuaikan stok bahan baku berdasarkan selisih qty
        $bahanBaku->stok -= $selisihQty;

        $bahanBaku->save();

        return response()->json(['status' => 'success']);

    }
}
