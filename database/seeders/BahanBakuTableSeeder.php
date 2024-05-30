<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahanBakuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanBakus = [
            'kain' => [
                ['nama_bahan_baku' => 'Kain katun', 'satuan' => 'yard', 'stok' => 200],
                ['nama_bahan_baku' => 'Kain sutra', 'satuan' => 'yard', 'stok' => 20],
            ],
            'lilin malam' => [
                ['nama_bahan_baku' => 'Klowong', 'satuan' => 'kg', 'stok' => 50],
                ['nama_bahan_baku' => 'Tembok', 'satuan' => 'kg', 'stok' => 50],
            ],
            'warna napthol' => [
                ['nama_bahan_baku' => 'MERAH B', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'BIRU B', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'HITAM B', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'AS BO', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'ASOL', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'ASBS', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'ASG', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'AS', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'AS BR', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'SCARLET', 'satuan' => 'g', 'stok' => 1000],
            ],
            'warna indigosol' => [
                ['nama_bahan_baku' => 'PINK', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'UNGU', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'BIRU', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'ABU-ABU', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'HIJAU', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'COKLAT', 'satuan' => 'g', 'stok' => 1000],
                ['nama_bahan_baku' => 'KUNING', 'satuan' => 'g', 'stok' => 1000],
            ],
            'canting tulis' => [
                ['nama_bahan_baku' => 'NO 1', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 2', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 3', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 4', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 5', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 10', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 11', 'satuan' => 'pcs', 'stok' => 10],
                ['nama_bahan_baku' => 'NO 12', 'satuan' => 'pcs', 'stok' => 10],
            ],
            'canting cap' => [
                ['nama_bahan_baku' => 'k3', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'cengkeh', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'parijhoto', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'tembakau', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'kopi', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'Menara', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'Gading', 'satuan' => 'pcs', 'stok' => 1],
                ['nama_bahan_baku' => 'daun', 'satuan' => 'pcs', 'stok' => 1],
            ],
            'bahan campuran' => [
                ['nama_bahan_baku' => 'Water glass', 'satuan' => 'null', 'stok' => 1],
                ['nama_bahan_baku' => 'Air keras', 'satuan' => 'null', 'stok' => 1],
                ['nama_bahan_baku' => 'Nitrit', 'satuan' => 'null', 'stok' => 1],
                ['nama_bahan_baku' => 'Binder', 'satuan' => 'null', 'stok' => 1],
                ['nama_bahan_baku' => 'Gondorukem', 'satuan' => 'null', 'stok' => 1],
            ],
        ];

        foreach ($bahanBakus as $kategori => $bahanBakuList) {
            $kategoriModel = Kriteria::where('nama_kategori', $kategori)->first();

            foreach ($bahanBakuList as $bahanBaku) {
                BahanBaku::create([
                    'nama_bahan_baku' => $bahanBaku['nama_bahan_baku'],
                    'satuan' => $bahanBaku['satuan'],
                    'kategori_id' => $kategoriModel->id,
                    'stok' => $bahanBaku['stok'],
                ]);
            }
        }
    }
}
