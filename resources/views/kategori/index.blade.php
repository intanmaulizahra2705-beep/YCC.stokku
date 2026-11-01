@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Kategori</h4>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah kategori
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama kategori</th>
                        <th class="text-center">Jumlah barang</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kategori }}</td>
                            <td class="text-center">{{ $k->barang_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('kategori.edit', $k) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $k) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection