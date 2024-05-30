<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KategoriLaporanController extends Controller
{
    public function bulanan(Request $request, $id)
    {
         // Ambil tanggal awal dan akhir dari URL atau gunakan nilai default
         $startDate = $request->input('bulan_tahun', Carbon::now()->startOfMonth());

         $start = Carbon::parse($startDate)->startOfMonth();
         $end   = Carbon::parse($startDate)->endOfMonth();
         // Buat range tanggal dari tanggal awal ke tanggal akhir
         $dateRange = Carbon::parse($startDate)->daysUntil(Carbon::parse($end));

         // Ambil ID kategori dari parameter URL atau sumber lain
        $kategoriId = $id;

        // Ambil objek Kategori berdasarkan ID
        $kategori = Kriteria::find($kategoriId);

         // Query database untuk mengambil data pembelian
         $pembelianPerTanggal = Pembelian::whereHas('bahan_baku', function ($query) use ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
            })
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->tanggal)->format('Y-m-d');
            });

         // Kirim data ke view
         return view('laporan.kategori', [
             'dateRange' => $dateRange,
             'pembelianPerTanggal' => $pembelianPerTanggal,
             'startDate' => $startDate,
             'kategori' => $kategori
         ]);
    }
}
