<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - StokKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; color: #3A2620; }
        .wrap { min-height: 100vh; display: flex; }
        .hero { flex: 1; background: #4B3128; color: #fff; padding: 64px; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
        .hero::before, .hero::after { content: ''; position: absolute; border-radius: 50%; background: #9FE0C5; opacity: .12; }
        .hero::before { width: 420px; height: 420px; top: -140px; right: -120px; }
        .hero::after { width: 300px; height: 300px; bottom: -100px; left: -80px; }
        .hero > * { position: relative; z-index: 1; animation: masuk .7s ease both; }
        .hero > *:nth-child(2) { animation-delay: .1s; } .hero > *:nth-child(3) { animation-delay: .2s; } .hero > *:nth-child(4) { animation-delay: .3s; }
        .logo { width: 48px; height: 48px; border-radius: 14px; background: #9FE0C5; color: #3A2620; display: grid; place-items: center; font-size: 1.5rem; }
        .fitur { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; color: #E8DDD6; }
        .fitur i { width: 36px; height: 36px; border-radius: 10px; background: rgba(159,224,197,.18); color: #9FE0C5; display: grid; place-items: center; }
        .panel { width: 480px; background: #F1FAF5; display: flex; align-items: center; justify-content: center; padding: 32px; }
        .kartu { width: 100%; max-width: 380px; background: #fff; border-radius: 20px; padding: 32px; box-shadow: 0 10px 40px rgba(58,38,32,.12); animation: masuk .6s ease both; }
        .kartu.salah { animation: getar .45s ease; }
        .form-control { border-radius: 12px; padding: .7rem .9rem; border-color: #E1ECE6; }
        .form-control:focus { border-color: #7FCFAE; box-shadow: 0 0 0 .25rem rgba(159,224,197,.4); }
        .btn-masuk { background: #9FE0C5; color: #3A2620; border: 0; border-radius: 12px; padding: .75rem; font-weight: 500; transition: transform .15s ease, box-shadow .2s ease, background .2s ease; }
        .btn-masuk:hover { background: #7FCFAE; transform: translateY(-1px); box-shadow: 0 8px 18px rgba(127,207,174,.5); }
        .btn-masuk:active { transform: scale(.97); }
        .btn-masuk:disabled { background: #9FE0C5; color: #3A2620; opacity: .85; }
        .demo { border: 1px dashed #CFE3D9; background: #F7FCF9; border-radius: 12px; padding: 10px 12px; cursor: pointer; transition: all .2s ease; width: 100%; text-align: left; }
        .demo:hover { background: #E3F6EE; border-color: #7FCFAE; transform: translateY(-2px); }
        @keyframes masuk { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
        @keyframes getar { 0%, 100% { transform: translateX(0); } 20%, 60% { transform: translateX(-9px); } 40%, 80% { transform: translateX(9px); } }
        @media (max-width: 991.98px) { .panel { width: 100%; } }
    </style>
</head>
<body>
<div class="wrap">
    <section class="hero d-none d-lg-flex">
        <div class="logo mb-4"><i class="bi bi-box-seam"></i></div>
        <h1 class="fw-semibold mb-3" style="font-size: 2.2rem; line-height: 1.3;">Kelola stok toko<br>lebih rapi dan cepat</h1>
        <p class="mb-4" style="color: #D9CBC2; max-width: 440px;">Catat barang masuk dan keluar, pantau stok yang hampir habis, dan lihat riwayat transaksi dalam satu tempat.</p>
        <div>
            <div class="fitur"><i class="bi bi-box-arrow-in-down"></i>Stok bertambah otomatis saat barang masuk</div>
            <div class="fitur"><i class="bi bi-bell"></i>Peringatan saat stok di bawah batas minimum</div>
            <div class="fitur"><i class="bi bi-clock-history"></i>Riwayat transaksi lengkap dengan pencatatnya</div>
        </div>
    </section>

    <section class="panel">
        <div class="kartu {{ $errors->has('username') ? 'salah' : '' }}">
            <h3 class="fw-semibold mb-1">Selamat datang</h3>
            <p class="text-secondary mb-4">Masuk untuk mengelola stok toko.</p>

            <form method="POST" action="{{ route('login.proses') }}" id="formLogin">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                           class="form-control @error('username') is-invalid @enderror" autofocus required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" style="border-radius: 12px 0 0 12px;" required>
                        <button class="btn btn-outline-secondary" type="button" id="lihat" style="border-radius: 0 12px 12px 0;" aria-label="Lihat password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-masuk w-100" id="btnMasuk">Masuk</button>
            </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var pw = document.getElementById('password'), us = document.getElementById('username');

    document.getElementById('lihat').addEventListener('click', function () {
        var tampil = pw.type === 'password';
        pw.type = tampil ? 'text' : 'password';
        this.innerHTML = tampil ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });

    document.querySelectorAll('.demo').forEach(function (b) {
        b.addEventListener('click', function () { us.value = b.dataset.u; pw.value = b.dataset.p; pw.focus(); });
    });

    document.getElementById('formLogin').addEventListener('submit', function () {
        var t = document.getElementById('btnMasuk');
        setTimeout(function () {
            t.disabled = true;
            t.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
        }, 0);
    });

    window.addEventListener('pageshow', function () {
        var t = document.getElementById('btnMasuk');
        t.disabled = false;
        t.textContent = 'Masuk';
    });
</script>
</body>
</html>