@extends('layouts.app')

@section('title', 'Stok masuk')

@section('content')
    <h4 class="mb-3">Stok masuk</h4>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-semibold">Catat stok masuk</div>
        <div class="card-body">
            <form method="POST" action="{{ route('stok-masuk.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Barang</label>
                        <select name="id_barang" class="form-select @error('id_barang') is-invalid @enderror" required>
                            <option value="">-- Pilih barang --</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id_barang }}" data-stok="{{ $b->stok }}" data-min="{{ $b->stok_minimum }}" data-satuan="{{ $b->satuan }}" @selected(old('id_barang') == $b->id_barang)>
                                    {{ $b->kode_barang }} - {{ $b->nama_barang }} (stok: {{ $b->stok }} {{ $b->satuan }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div id="infoStok" data-mode="masuk" class="info-stok d-none mt-2"></div>                   
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Supplier</label>
                        <select name="id_supplier" class="form-select @error('id_supplier') is-invalid @enderror" required>
                            <option value="">-- Pilih supplier --</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id_supplier }}" @selected(old('id_supplier') == $s->id_supplier)>
                                    {{ $s->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_supplier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jumlah</label>
                        <input type="number" min="1" name="jumlah" value="{{ old('jumlah') }}"
                               class="form-control @error('jumlah') is-invalid @enderror" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               class="form-control @error('tanggal') is-invalid @enderror" required>
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               class="form-control @error('keterangan') is-invalid @enderror">
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">10 stok masuk terakhir</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th class="text-center">Jumlah</th>
                        <th>Dicatat oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terakhir as $t)
                        <tr>
                            <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $t->barang->nama_barang }}</td>
                            <td>{{ $t->supplier->nama_supplier }}</td>
                            <td class="text-center text-success fw-semibold">+{{ $t->jumlah }} {{ $t->barang->satuan }}</td>
                            <td>{{ $t->user->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada stok masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection