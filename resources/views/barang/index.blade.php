@extends('layouts.app')

@section('title', 'Data barang')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data barang</h4>
        <a href="{{ route('barang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah barang
        </a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width: 360px;">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Cari kode atau nama barang">
            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama barang</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga beli</th>
                        <th class="text-end">Harga jual</th>
                        <th class="text-center">Stok</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barang as $b)
                        <tr>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori }}</td>
                            <td class="text-end">Rp {{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $b->stok <= $b->stok_minimum ? 'text-bg-danger' : 'text-bg-success' }}">
                                    {{ $b->stok }} {{ $b->satuan }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('barang.edit', $b) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $b) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection