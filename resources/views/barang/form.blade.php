@extends('layouts.app')

@section('title', $barang->exists ? 'Ubah barang' : 'Tambah barang')

@section('content')
    <h4 class="mb-3">{{ $barang->exists ? 'Ubah barang' : 'Tambah barang' }}</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST"
                  action="{{ $barang->exists ? route('barang.update', $barang) : route('barang.store') }}">
                @csrf
                @if ($barang->exists)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kode barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}"
                               class="form-control @error('kode_barang') is-invalid @enderror" required>
                        @error('kode_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Nama barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}"
                               class="form-control @error('nama_barang') is-invalid @enderror" required>
                        @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih kategori --</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id_kategori }}"
                                    @selected(old('id_kategori', $barang->id_kategori) == $k->id_kategori)>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}"
                               class="form-control @error('satuan') is-invalid @enderror"
                               placeholder="contoh: pcs, botol, kg" required>
                        @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Harga beli</label>
                        <input type="number" step="any" min="0" name="harga_beli"
                               value="{{ old('harga_beli', $barang->harga_beli) }}"
                               class="form-control @error('harga_beli') is-invalid @enderror" required>
                        @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Harga jual</label>
                        <input type="number" step="any" min="0" name="harga_jual"
                               value="{{ old('harga_jual', $barang->harga_jual) }}"
                               class="form-control @error('harga_jual') is-invalid @enderror" required>
                        @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ $barang->exists ? 'Stok saat ini' : 'Stok awal' }}</label>
                        @if ($barang->exists)
                            <input type="number" class="form-control" value="{{ $barang->stok }}" readonly>
                            <div class="form-text">Stok berubah lewat menu Stok masuk dan Stok keluar.</div>
                        @else
                            <input type="number" min="0" name="stok" value="{{ old('stok', 0) }}"
                                   class="form-control @error('stok') is-invalid @enderror" required>
                            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stok minimum</label>
                        <input type="number" min="0" name="stok_minimum"
                               value="{{ old('stok_minimum', $barang->stok_minimum) }}"
                               class="form-control @error('stok_minimum') is-invalid @enderror" required>
                        @error('stok_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection