<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('barang')->orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.form', ['kategori' => new Kategori()]);
    }

    public function store(Request $request)
    {
        Kategori::create($this->validasi($request));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.form', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($this->validasi($request));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $kategori->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh barang.');
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
        ]);
    }
}