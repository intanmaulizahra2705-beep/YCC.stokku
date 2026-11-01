@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Supplier</h4>
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah supplier
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama supplier</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supplier as $s)
                        <tr>
                            <td>{{ $s->nama_supplier }}</td>
                            <td>{{ $s->telepon ?? '-' }}</td>
                            <td>{{ $s->alamat ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('supplier.edit', $s) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('supplier.destroy', $s) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection