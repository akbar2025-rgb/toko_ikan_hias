<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikan extends Model
{
    use HasFactory;

    protected $table = 'ikan';

    protected $fillable = [
        'kategori_id',
        'nama_ikan',
        'harga_beli',
        'harga_jual',
        'stok',
        'ukuran',
        'deskripsi',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriIkan::class, 'kategori_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'ikan_id');
    }
}