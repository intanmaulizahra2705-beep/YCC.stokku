<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        return view('stok-masuk.index', [
            'barang' => Barang::orderBy('nama_barang')->get(),
            'supplier' => Supplier::orderBy('nama_supplier')->get(),
            'terakhir' => StokMasuk::with(['barang', 'supplier', 'user'])
                ->latest('id_masuk')
                ->limit(10)
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_barang' => ['required', 'exists:barang,id_barang'],
            'id_supplier' => ['required', 'exists:supplier,id_supplier'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        // simpan catatan dan tambah stok dalam satu transaksi,
        // supaya keduanya berhasil atau gagal bersamaan
        DB::transaction(function () use ($data) {
            StokMasuk::create($data + ['id_user' => auth()->id()]);
            Barang::whereKey($data['id_barang'])->increment('stok', $data['jumlah']);
        });

        return redirect()->route('stok-masuk.index')
            ->with('success', 'Stok masuk berhasil dicatat, stok barang bertambah.');
    }
}