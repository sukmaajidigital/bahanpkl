<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $kategoris = [
            'kain',
            'lilin malam', 
            'warna napthol',
            'warna indigosol',
            'warna remazol',
            'warna rapid',
            'warna direk',
            'warna indigofera',
            'canting tulis',
            'canting cap',
            'bahan campuran',
        ];

        foreach ($kategoris as $kategori) {
            Kriteria::create([
                'nama_kategori' => $kategori
            ]);
        }
    }
}
