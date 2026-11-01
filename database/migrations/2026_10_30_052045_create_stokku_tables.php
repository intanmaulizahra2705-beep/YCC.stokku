<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staf']);
            $table->rememberToken();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100);
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('nama_supplier', 100);
            $table->string('telepon', 20)->nullable();
            $table->string('alamat')->nullable();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('kode_barang', 30)->unique();
            $table->string('nama_barang', 100);
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori');
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('stok_minimum')->default(0);
            $table->string('satuan', 20);
        });

        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id('id_masuk');
            $table->foreignId('id_barang')->constrained('barang', 'id_barang');
            $table->foreignId('id_supplier')->constrained('supplier', 'id_supplier');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->unsignedInteger('jumlah');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
        });

        Schema::create('stok_keluar', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->foreignId('id_barang')->constrained('barang', 'id_barang');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->unsignedInteger('jumlah');
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_keluar');
        Schema::dropIfExists('stok_masuk');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('users');
    }
};