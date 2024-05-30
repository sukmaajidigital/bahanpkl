<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyPurchaseChart;
use App\Models\BahanBaku;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(MonthlyPurchaseChart $chart)
    {
        $tahun = date('Y');
        $bulan = date('m');
        for ($i=1; $i <= $bulan; $i++) {
            $totalPengeluaran = Pembelian::whereYear('tanggal', $tahun)->whereMonth('tanggal', $i)->sum('total_harga');
            $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataTotalPengeluaran[] = $totalPengeluaran;
        }
        // $chartBulanan = $chart->build();
        $startDate = Carbon::now()->startOfMonth();

        $startOfMonth = Carbon::parse($startDate)->startOfMonth();
        $endOfMonth   = Carbon::parse($startDate)->endOfMonth();

        $data = BahanBaku::with(['pembelian' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->selectRaw('bahan_baku_id, sum(qty) as qty, sum(total_harga) as total_harga')
                    ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                    ->groupBy('bahan_baku_id');
            }])->get();

        $stok = BahanBaku::where('stok', '>', 0)->orderBy('stok', 'asc')->get();
        return view('dashboard', compact('data','stok', 'dataBulan', 'dataTotalPengeluaran'));
    }
}
