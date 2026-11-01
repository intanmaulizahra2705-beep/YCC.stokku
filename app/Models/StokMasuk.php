<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';
    protected $primaryKey = 'id_masuk';
    public $timestamps = false;

    protected $fillable = [
        'id_barang', 'id_supplier', 'id_user', 'jumlah', 'tanggal', 'keterangan',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}