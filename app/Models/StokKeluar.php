<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    protected $table = 'stok_keluar';
    protected $primaryKey = 'id_keluar';
    public $timestamps = false;

    protected $fillable = ['id_barang', 'id_user', 'jumlah', 'tanggal', 'keterangan'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}