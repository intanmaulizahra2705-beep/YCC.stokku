<?php

namespace App\Http\Controllers;

use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->query('jenis', 'semua');
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $masuk = collect();
        $keluar = collect();

        if ($jenis !== 'keluar') {
            $masuk = StokMasuk::with(['barang', 'supplier', 'user'])
                ->when($dari, fn ($q) => $q->whereDate('tanggal', '>=', $dari))
                ->when($sampai, fn ($q) => $q->whereDate('tanggal', '<=', $sampai))
                ->get()
                ->map(fn ($m) => (object) [
                    'id' => $m->id_masuk,
                    'tanggal' => $m->tanggal,
                    'barang' => $m->barang->nama_barang,
                    'satuan' => $m->barang->satuan,
                    'jenis' => 'masuk',
                    'jumlah' => $m->jumlah,
                    'supplier' => $m->supplier->nama_supplier,
                    'user' => $m->user->nama,
                    'keterangan' => $m->keterangan,
                ]);
        }

        if ($jenis !== 'masuk') {
            $keluar = StokKeluar::with(['barang', 'user'])
                ->when($dari, fn ($q) => $q->whereDate('tanggal', '>=', $dari))
                ->when($sampai, fn ($q) => $q->whereDate('tanggal', '<=', $sampai))
                ->get()
                ->map(fn ($k) => (object) [
                    'id' => $k->id_keluar,
                    'tanggal' => $k->tanggal,
                    'barang' => $k->barang->nama_barang,
                    'satuan' => $k->barang->satuan,
                    'jenis' => 'keluar',
                    'jumlah' => $k->jumlah,
                    'supplier' => '-',
                    'user' => $k->user->nama,
                    'keterangan' => $k->keterangan,
                ]);
        }

        // gabung stok masuk dan keluar, urutkan dari yang terbaru
        $riwayat = $masuk->concat($keluar)
            ->sortByDesc(fn ($r) => $r->tanggal->format('Y-m-d') . str_pad($r->id, 10, '0', STR_PAD_LEFT))
            ->values();

        return view('riwayat.index', compact('riwayat', 'jenis', 'dari', 'sampai'));
    }
}