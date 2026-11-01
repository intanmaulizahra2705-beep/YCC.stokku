@extends('layouts.app')

@section('title', $supplier->exists ? 'Ubah supplier' : 'Tambah supplier')

@section('content')
    <h4 class="mb-3">{{ $supplier->exists ? 'Ubah supplier' : 'Tambah supplier' }}</h4>

    <div class="card shadow-sm border-0" style="max-width: 560px;">
        <div class="card-body">
            <form method="POST"
                  action="{{ $supplier->exists ? route('supplier.update', $supplier) : route('supplier.store') }}">
                @csrf
                @if ($supplier->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama supplier</label>
                    <input type="text" name="nama_supplier"
                           value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                           class="form-control @error('nama_supplier') is-invalid @enderror" required>
                    @error('nama_supplier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $supplier->telepon) }}"
                           class="form-control @error('telepon') is-invalid @enderror">
                    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $supplier->alamat) }}"
                           class="form-control @error('alamat') is-invalid @enderror">
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection