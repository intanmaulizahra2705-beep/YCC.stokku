@extends('layouts.app')

@section('title', $kategori->exists ? 'Ubah kategori' : 'Tambah kategori')

@section('content')
    <h4 class="mb-3">{{ $kategori->exists ? 'Ubah kategori' : 'Tambah kategori' }}</h4>

    <div class="card shadow-sm border-0" style="max-width: 520px;">
        <div class="card-body">
            <form method="POST"
                  action="{{ $kategori->exists ? route('kategori.update', $kategori) : route('kategori.store') }}">
                @csrf
                @if ($kategori->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama kategori</label>
                    <input type="text" name="nama_kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           class="form-control @error('nama_kategori') is-invalid @enderror" required>
                    @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection