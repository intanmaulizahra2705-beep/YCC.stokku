@extends('layouts.app')

@section('title', 'Stok keluar')

@section('content')
    <h4 class="mb-3">Stok keluar</h4>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-semibold">Catat stok keluar</div>
        <div class="card-body">
            <form method="POST" action="{{ route('stok-keluar.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Barang</label>
                        <select name="id_barang" class="form-select @error('id_barang') is-invalid @enderror" required>
                            <option value="">-- Pilih barang --</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id_barang }}" @selected(old('id_barang') == $b->id_barang)>
                                    {{ $b->kode_barang }} - {{ $b->nama_barang }} (stok: {{ $b->stok }} {{ $b->satuan }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div id="infoStok" data-mode="keluar" class="info-stok d-none mt-2"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" min="1" name="jumlah" value="{{ old('jumlah') }}"
                               class="form-control @error('jumlah') is-invalid @enderror" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               class="form-control @error('tanggal') is-invalid @enderror" required>
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                               class="form-control @error('keterangan') is-invalid @enderror"
                               placeholder="contoh: dijual, rusak, hilang">
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">10 stok keluar terakhir</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th>Keterangan</th>
                        <th>Dicatat oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terakhir as $t)
                        <tr>
                            <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $t->barang->nama_barang }}</td>
                            <td class="text-center text-danger fw-semibold">-{{ $t->jumlah }} {{ $t->barang->satuan }}</td>
                            <td>{{ $t->keterangan ?? '-' }}</td>
                            <td>{{ $t->user->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada stok keluar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection