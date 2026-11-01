<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::with('kategori')
            ->when($request->q, function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_barang', 'like', "%{$q}%")
                      ->orWhere('kode_barang', 'like', "%{$q}%");
                });
            })
            ->orderBy('nama_barang')
            ->get();

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.form', [
            'barang' => new Barang(),
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Barang::create($request->validate($this->aturan()));

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barang.form', [
            'barang' => $barang,
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
        ]);
    }

    public function update(Request $request, Barang $barang)
    {
        $barang->update($request->validate($this->aturan($barang)));

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diubah.');
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Barang tidak bisa dihapus karena sudah dipakai di transaksi stok.');
        }

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    private function aturan(?Barang $barang = null): array
    {
        $aturan = [
            'kode_barang' => [
                'required', 'string', 'max:30',
                Rule::unique('barang', 'kode_barang')->ignore($barang?->id_barang, 'id_barang'),
            ],
            'nama_barang' => ['required', 'string', 'max:100'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ];

        // stok hanya diisi saat barang baru dibuat (stok awal).
        // Setelah itu stok berubah lewat transaksi stok masuk/keluar.
        if (! $barang) {
            $aturan['stok'] = ['required', 'integer', 'min:0'];
        }

        return $aturan;
    }
}