<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembelianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembelians = [
            // Kain
            ['bahan_baku_id' => 1, 'qty' => 200, 'harga_satuan' => 50000],  // Kain katun
            ['bahan_baku_id' => 2, 'qty' => 20, 'harga_satuan' => 200000],  // Kain sutra

            // Lilin malam
            ['bahan_baku_id' => 3, 'qty' => 50, 'harga_satuan' => 50000],  // Klowong
            ['bahan_baku_id' => 4, 'qty' => 50, 'harga_satuan' => 50000],  // Tembok

            // Warna napthol
            ['bahan_baku_id' => 5, 'qty' => 1000, 'harga_satuan' => 2500],  // MERAH B
            ['bahan_baku_id' => 6, 'qty' => 1000, 'harga_satuan' => 2500],  // BIRU B
            ['bahan_baku_id' => 7, 'qty' => 1000, 'harga_satuan' => 2500],  // HITAM B
            ['bahan_baku_id' => 8, 'qty' => 1000, 'harga_satuan' => 2500],  // AS BO
            ['bahan_baku_id' => 9, 'qty' => 1000, 'harga_satuan' => 2500],  // ASOL
            ['bahan_baku_id' => 10, 'qty' => 1000, 'harga_satuan' => 2500],  // ASBS
            ['bahan_baku_id' => 11, 'qty' => 1000, 'harga_satuan' => 2500],  // ASG
            ['bahan_baku_id' => 12, 'qty' => 1000, 'harga_satuan' => 2500],  // AS
            ['bahan_baku_id' => 13, 'qty' => 1000, 'harga_satuan' => 2500],  // AS BR
            ['bahan_baku_id' => 14, 'qty' => 1000, 'harga_satuan' => 2500],  // SCARLET

            // Warna indigosol
            ['bahan_baku_id' => 15, 'qty' => 1000, 'harga_satuan' => 7000],  // PINK
            ['bahan_baku_id' => 16, 'qty' => 1000, 'harga_satuan' => 7000],  // UNGU
            ['bahan_baku_id' => 17, 'qty' => 1000, 'harga_satuan' => 7000],  // BIRU
            ['bahan_baku_id' => 18, 'qty' => 1000, 'harga_satuan' => 7000],  // ABU-ABU
            ['bahan_baku_id' => 19, 'qty' => 1000, 'harga_satuan' => 7000],  // HIJAU
            ['bahan_baku_id' => 20, 'qty' => 1000, 'harga_satuan' => 7000],  // COKLAT
            ['bahan_baku_id' => 21, 'qty' => 1000, 'harga_satuan' => 7000],  // KUNING

            // Canting tulis
            ['bahan_baku_id' => 22, 'qty' => 10, 'harga_satuan' => 10000], // NO 1
            ['bahan_baku_id' => 23, 'qty' => 10, 'harga_satuan' => 10000], // NO 2
            ['bahan_baku_id' => 24, 'qty' => 10, 'harga_satuan' => 10000], // NO 3
            ['bahan_baku_id' => 25, 'qty' => 10, 'harga_satuan' => 10000], // NO 4
            ['bahan_baku_id' => 26, 'qty' => 10, 'harga_satuan' => 10000], // NO 5
            ['bahan_baku_id' => 27, 'qty' => 10, 'harga_satuan' => 10000], // NO 10
            ['bahan_baku_id' => 28, 'qty' => 10, 'harga_satuan' => 10000], // NO 11
            ['bahan_baku_id' => 29, 'qty' => 10, 'harga_satuan' => 10000], // NO 12

            // Canting cap
            ['bahan_baku_id' => 30, 'qty' => 1, 'harga_satuan' => 1000000], // k3
            ['bahan_baku_id' => 31, 'qty' => 1, 'harga_satuan' => 1000000], // cengkeh
            ['bahan_baku_id' => 32, 'qty' => 1, 'harga_satuan' => 1000000], // parijhoto
            ['bahan_baku_id' => 33, 'qty' => 1, 'harga_satuan' => 1000000], // tembakau
            ['bahan_baku_id' => 34, 'qty' => 1, 'harga_satuan' => 1000000], // kopi
            ['bahan_baku_id' => 35, 'qty' => 1, 'harga_satuan' => 1000000], // Menara
            ['bahan_baku_id' => 36, 'qty' => 1, 'harga_satuan' => 1000000], // Gading
            ['bahan_baku_id' => 37, 'qty' => 1, 'harga_satuan' => 1000000], // daun

            // Bahan campuran
            ['bahan_baku_id' => 38, 'qty' => 1, 'harga_satuan' => 130000], // Water glass
            ['bahan_baku_id' => 39, 'qty' => 1, 'harga_satuan' => 120000], // Air keras
            ['bahan_baku_id' => 40, 'qty' => 1, 'harga_satuan' => 50000],  // Nitrit
            ['bahan_baku_id' => 41, 'qty' => 1, 'harga_satuan' => 50000],  // Binder
            ['bahan_baku_id' => 42, 'qty' => 1, 'harga_satuan' => 35000],  // Gondorukem
        ];

        foreach ($pembelians as $pembelian) {
            Pembelian::create([
                'bahan_baku_id' => $pembelian['bahan_baku_id'],
                'qty' => $pembelian['qty'],
                'harga_satuan' => $pembelian['harga_satuan'],
                'total_harga' => $pembelian['harga_satuan'] * $pembelian['qty'], // total harga = harga satuan * qty
                'tanggal' => Carbon::now(), // tanggal saat ini
            ]);
        }
    }
}
