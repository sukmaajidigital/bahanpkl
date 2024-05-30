<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    public function bulanan(Request $request)
    {
        // Ambil tanggal awal dan akhir dari URL atau gunakan nilai default
        $startDate = $request->input('bulan_tahun', Carbon::now()->startOfMonth());

        $start = Carbon::parse($startDate)->startOfMonth();
        $end   = Carbon::parse($startDate)->endOfMonth();
        // Buat range tanggal dari tanggal awal ke tanggal akhir
        $dateRange = Carbon::parse($startDate)->daysUntil(Carbon::parse($end));

        // Query database untuk mengambil data pembelian
        $pembelianPerTanggal = Pembelian::whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->tanggal)->format('Y-m-d');
            });

        // Kirim data ke view
        return view('laporan.harian', [
            'dateRange' => $dateRange,
            'pembelianPerTanggal' => $pembelianPerTanggal,
            'startDate' => $startDate,
        ]);
    }

    public function generatePDF($startDate)
    {
        $start = Carbon::parse($startDate)->startOfMonth();
        $end   = Carbon::parse($startDate)->endOfMonth();
        // Buat range tanggal dari tanggal awal ke tanggal akhir
        $dateRange = Carbon::parse($start)->daysUntil(Carbon::parse($end));

        // Query database untuk mengambil data pembelian
        $pembelianPerTanggal = Pembelian::whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->tanggal)->format('Y-m-d');
            });

        return view('laporan.pdf', compact('dateRange', 'pembelianPerTanggal', 'startDate'));



    }

}
