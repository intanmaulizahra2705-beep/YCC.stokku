<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokKeluar;
use App\Models\StokMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $stokMenipis = Barang::menipis()->count();
        $masukHariIni = StokMasuk::whereDate('tanggal', today())->sum('jumlah');
        $keluarHariIni = StokKeluar::whereDate('tanggal', today())->sum('jumlah');
        $barangMenipis = Barang::with('kategori')->menipis()->orderBy('stok')->get();

        $awal = today()->subDays(6);

        $masuk = StokMasuk::whereDate('tanggal', '>=', $awal)
            ->selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $keluar = StokKeluar::whereDate('tanggal', '>=', $awal)
            ->selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $grafik = ['label' => [], 'masuk' => [], 'keluar' => []];

        for ($i = 6; $i >= 0; $i--) {
            $tgl = today()->subDays($i);
            $kunci = $tgl->format('Y-m-d');

            $grafik['label'][] = $tgl->translatedFormat('d M');
            $grafik['masuk'][] = (int) ($masuk[$kunci] ?? 0);
            $grafik['keluar'][] = (int) ($keluar[$kunci] ?? 0);
        }

        $kondisi = [
            'aman' => Barang::whereColumn('stok', '>', 'stok_minimum')->count(),
            'menipis' => Barang::whereColumn('stok', '<=', 'stok_minimum')->where('stok', '>', 0)->count(),
            'habis' => Barang::where('stok', 0)->count(),
        ];

        return view('dashboard', compact(
            'totalBarang', 'stokMenipis', 'masukHariIni', 'keluarHariIni',
            'barangMenipis', 'grafik', 'kondisi'
        ));
    }
}