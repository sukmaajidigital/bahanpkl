<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;
    protected $table = 'bahan_baku';
    protected $fillable = [
        'nama_bahan_baku',
        'satuan',
        'kategori_id',
        'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function akumulasiPembelian()
    {
        return $this->hasMany(AkumulasiPembelian::class);
    }
}
