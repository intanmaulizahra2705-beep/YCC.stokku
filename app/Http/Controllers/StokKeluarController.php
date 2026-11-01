<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        return view('stok-keluar.index', [
            'barang' => Barang::orderBy('nama_barang')->get(),
            'terakhir' => StokKeluar::with(['barang', 'user'])
                ->latest('id_keluar')
                ->limit(10)
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_barang' => ['required', 'exists:barang,id_barang'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $pesanError = DB::transaction(function () use ($data) {
            $barang = Barang::lockForUpdate()->findOrFail($data['id_barang']);

            // cek stok dulu: kalau kurang, transaksi ditolak
            if ($barang->stok < $data['jumlah']) {
                return "Stok {$barang->nama_barang} tidak cukup. Stok tersedia: {$barang->stok} {$barang->satuan}.";
            }

            StokKeluar::create($data + ['id_user' => auth()->id()]);
            $barang->decrement('stok', $data['jumlah']);

            return null;
        });

        if ($pesanError) {
            return back()->withInput()->with('error', $pesanError);
        }

        return redirect()->route('stok-keluar.index')
            ->with('success', 'Stok keluar berhasil dicatat, stok barang berkurang.');
    }
}