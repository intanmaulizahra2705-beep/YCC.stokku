@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Halo, {{ auth()->user()->nama }}</h4>
        <div class="text-secondary">{{ now()->translatedFormat('l, d F Y') }}</div>
    </div>

    <div class="row g-3 mb-4 stagger">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon si-1"><i class="bi bi-boxes"></i></div>
                    <div>
                        <div class="text-secondary small">Total barang</div>
                        <div class="fs-3 fw-semibold" data-count="{{ $totalBarang }}">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon si-2"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="text-secondary small">Stok menipis</div>
                        <div class="fs-3 fw-semibold {{ $stokMenipis > 0 ? 'text-danger' : '' }}" data-count="{{ $stokMenipis }}">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon si-3"><i class="bi bi-box-arrow-in-down"></i></div>
                    <div>
                        <div class="text-secondary small">Masuk hari ini</div>
                        <div class="fs-3 fw-semibold" data-count="{{ $masukHariIni }}">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-hover h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon si-4"><i class="bi bi-box-arrow-up"></i></div>
                    <div>
                        <div class="text-secondary small">Keluar hari ini</div>
                        <div class="fs-3 fw-semibold" data-count="{{ $keluarHariIni }}">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-3">Stok masuk dan keluar, 7 hari terakhir</h6>
                    <div style="height: 270px;"><canvas id="grafikStok"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-3">Kondisi stok barang</h6>
                    <div style="height: 270px;"><canvas id="grafikKondisi"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <span class="fw-semibold">Barang hampir habis</span>
            @if (auth()->user()->role === 'staf')
                <a href="{{ url('/stok-masuk') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Catat stok masuk
                </a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama barang</th>
                        <th>Kategori</th>
                        <th style="min-width: 190px;">Sisa stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangMenipis as $b)
                        @php
                            $persen = $b->stok_minimum > 0 ? min(100, round($b->stok / $b->stok_minimum * 100)) : 0;
                        @endphp
                        <tr>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar {{ $b->stok == 0 ? 'bg-danger' : 'bg-warning' }}"
                                             style="width: {{ $persen }}%"></div>
                                    </div>
                                    <span class="small fw-semibold">{{ $b->stok }}/{{ $b->stok_minimum }}</span>
                                </div>
                            </td>
                            <td>
                                @if ($b->stok == 0)
                                    <span class="badge text-bg-danger">Habis</span>
                                @else
                                    <span class="badge text-bg-warning">Menipis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-check-circle fs-3 d-block mb-2"></i>Semua stok aman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    var data = @json($grafik);
    var kondisi = @json($kondisi);

    function css(n) { return getComputedStyle(document.documentElement).getPropertyValue(n).trim(); }
    function warna() {
        var gelap = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        return {
            teks: css('--muted'), garis: gelap ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)',
            masuk: '#5FC9A0', keluar: gelap ? '#D9A58B' : '#4B3128',
            aman: '#5FC9A0', menipis: '#F2B84B', habis: '#E5675F', tepi: css('--card')
        };
    }
    var w = warna();

    var batang = new Chart(document.getElementById('grafikStok'), {
        type: 'bar',
        data: {
            labels: data.label,
            datasets: [
                { label: 'Stok masuk', data: data.masuk, backgroundColor: w.masuk, borderRadius: 6 },
                { label: 'Stok keluar', data: data.keluar, backgroundColor: w.keluar, borderRadius: 6 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            animation: { duration: 900, easing: 'easeOutQuart' },
            plugins: { legend: { position: 'bottom', labels: { color: w.teks, usePointStyle: true } } },
            scales: {
                x: { ticks: { color: w.teks }, grid: { display: false } },
                y: { beginAtZero: true, ticks: { color: w.teks, precision: 0 }, grid: { color: w.garis } }
            }
        }
    });

    var donat = new Chart(document.getElementById('grafikKondisi'), {
        type: 'doughnut',
        data: {
            labels: ['Aman', 'Menipis', 'Habis'],
            datasets: [{
                data: [kondisi.aman, kondisi.menipis, kondisi.habis],
                backgroundColor: [w.aman, w.menipis, w.habis], borderColor: w.tepi, borderWidth: 3
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { color: w.teks, usePointStyle: true } } }
        }
    });

    window.addEventListener('themechange', function () {
        var b = warna();
        batang.data.datasets[0].backgroundColor = b.masuk;
        batang.data.datasets[1].backgroundColor = b.keluar;
        batang.options.plugins.legend.labels.color = b.teks;
        batang.options.scales.x.ticks.color = b.teks;
        batang.options.scales.y.ticks.color = b.teks;
        batang.options.scales.y.grid.color = b.garis;
        donat.data.datasets[0].borderColor = b.tepi;
        donat.options.plugins.legend.labels.color = b.teks;
        batang.update();
        donat.update();
    });
})();
</script>
@endpush