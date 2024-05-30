<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkumulasiPembelian extends Model
{
    use HasFactory;
    protected $table = 'akumulasi_pembelian';
    protected $fillable = [
        'bahan_baku_id',
        'bulan',
        'tahun',
        'total_qty',
        'total_harga'
    ];

    public function bahan_baku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
