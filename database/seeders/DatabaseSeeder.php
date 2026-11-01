<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Toko',
            'username' => 'admin',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Staf Gudang',
            'username' => 'staf',
            'password' => 'staf123',
            'role' => 'staf',
        ]);

        $sembako = Kategori::create(['nama_kategori' => 'Sembako']);
        $minuman = Kategori::create(['nama_kategori' => 'Minuman']);
        $kebersihan = Kategori::create(['nama_kategori' => 'Kebersihan']);

        Supplier::create([
            'nama_supplier' => 'CV Maju Jaya',
            'telepon' => '0651-7001',
            'alamat' => 'Banda Aceh',
        ]);

        Supplier::create([
            'nama_supplier' => 'UD Rejeki Jaya',
            'telepon' => '0653-2210',
            'alamat' => 'Sigli',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-001', 'nama_barang' => 'Beras 5 kg',
            'id_kategori' => $sembako->id_kategori,
            'harga_beli' => 55000, 'harga_jual' => 60000,
            'stok' => 24, 'stok_minimum' => 10, 'satuan' => 'pcs',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-002', 'nama_barang' => 'Minyak goreng 1 L',
            'id_kategori' => $sembako->id_kategori,
            'harga_beli' => 15000, 'harga_jual' => 17000,
            'stok' => 3, 'stok_minimum' => 10, 'satuan' => 'botol',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-003', 'nama_barang' => 'Gula 1 kg',
            'id_kategori' => $sembako->id_kategori,
            'harga_beli' => 14000, 'harga_jual' => 16000,
            'stok' => 5, 'stok_minimum' => 10, 'satuan' => 'bungkus',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-004', 'nama_barang' => 'Teh botol',
            'id_kategori' => $minuman->id_kategori,
            'harga_beli' => 3500, 'harga_jual' => 5000,
            'stok' => 40, 'stok_minimum' => 12, 'satuan' => 'botol',
        ]);

        Barang::create([
            'kode_barang' => 'BRG-005', 'nama_barang' => 'Sabun mandi',
            'id_kategori' => $kebersihan->id_kategori,
            'harga_beli' => 2500, 'harga_jual' => 4000,
            'stok' => 40, 'stok_minimum' => 10, 'satuan' => 'pcs',
        ]);
    }
}