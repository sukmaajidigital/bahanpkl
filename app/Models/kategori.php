<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
