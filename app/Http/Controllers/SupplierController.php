<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama_supplier')->get();

        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.form', ['supplier' => new Supplier()]);
    }

    public function store(Request $request)
    {
        Supplier::create($this->validasi($request));

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.form', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($this->validasi($request));

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diubah.');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Supplier tidak bisa dihapus karena sudah dipakai di stok masuk.');
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_supplier' => ['required', 'string', 'max:100'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);
    }
}