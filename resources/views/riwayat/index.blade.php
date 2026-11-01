@extends('layouts.app')

@section('title', 'Riwayat stok')

@section('content')
    <h4 class="mb-3">Riwayat stok</h4>

    <form method="GET" class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="semua" @selected($jenis === 'semua')>Semua</option>
                        <option value="masuk" @selected($jenis === 'masuk')>Stok masuk</option>
                        <option value="keluar" @selected($jenis === 'keluar')>Stok keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari tanggal</label>
                    <input type="date" name="dari" value="{{ $dari }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai tanggal</label>
                    <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary">Tampilkan</button>
                    <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th class="text-center">Jumlah</th>
                        <th>Supplier</th>
                        <th>Dicatat oleh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $r)
                        <tr>
                            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $r->barang }}</td>
                            <td>
                                @if ($r->jenis === 'masuk')
                                    <span class="badge text-bg-success">Masuk</span>
                                @else
                                    <span class="badge text-bg-warning">Keluar</span>
                                @endif
                            </td>
                            <td class="text-center fw-semibold {{ $r->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                {{ $r->jenis === 'masuk' ? '+' : '-' }}{{ $r->jumlah }} {{ $r->satuan }}
                            </td>
                            <td>{{ $r->supplier }}</td>
                            <td>{{ $r->user }}</td>
                            <td>{{ $r->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection