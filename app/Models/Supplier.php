<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;

    protected $fillable = ['nama_supplier', 'telepon', 'alamat'];

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'id_supplier', 'id_supplier');
    }
}