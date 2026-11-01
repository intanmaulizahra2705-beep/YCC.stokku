<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;

    protected $fillable = [
        'kode_barang', 'nama_barang', 'id_kategori',
        'harga_beli', 'harga_jual', 'stok', 'stok_minimum', 'satuan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'id_barang', 'id_barang');
    }

    public function stokKeluar()
    {
        return $this->hasMany(StokKeluar::class, 'id_barang', 'id_barang');
    }

    public function scopeMenipis(Builder $query): Builder
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
}