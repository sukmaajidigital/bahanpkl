<?php

namespace App\Charts;

use App\Models\Pembelian;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class MonthlyPurchaseChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $tahun = date('Y');
        $bulan = date('m');
        for ($i=1; $i <= $bulan; $i++) {
            $totalPengeluaran = Pembelian::whereYear('tanggal', $tahun)->whereMonth('tanggal', $i)->sum('total_harga');
            $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataTotalPengeluaran[] = ($totalPengeluaran);
        }
        return $this->chart->lineChart()
            ->setTitle('Data Pengeluaran Bulanan')
            ->setSubtitle('Total Pengeluaran Resto Tiap Bulan.')
            ->addData('Total Pengeluaran', $dataTotalPengeluaran)
            ->setXAxis($dataBulan);
    }
}
