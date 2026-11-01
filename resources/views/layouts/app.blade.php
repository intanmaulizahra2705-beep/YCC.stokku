<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'StokKu') - StokKu</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        (function () {
            var t = localStorage.getItem('stokku-tema');
            if (t) document.documentElement.setAttribute('data-bs-theme', t);
        })();
    </script>

    <style>
        :root, [data-bs-theme=light] {
            --choco: #4B3128; --choco-d: #3A2620; --mint: #9FE0C5; --mint-d: #7FCFAE; --mint-l: #E3F6EE;
            --bg: #F1FAF5; --card: #FFFFFF; --ink: #3A2620; --muted: #7A6A62; --line: #E1ECE6;
            --side: #4B3128; --link: #4B3128; --btn-o: #4B3128; --th-bg: #E8F4EE;
            --bs-body-bg: #F1FAF5; --bs-body-color: #3A2620; --bs-border-color: #E1ECE6;
            --bs-tertiary-bg: #E8F4EE; --bs-secondary-color: #7A6A62;
        }
        [data-bs-theme=dark] {
            --bg: #1C1411; --card: #2A1D18; --ink: #F3E9E2; --muted: #B7A79E; --line: #3D2C25;
            --mint-l: #24382F; --side: #2B1B15; --link: #9FE0C5; --btn-o: #9FE0C5; --th-bg: #33241E;
            --bs-body-bg: #1C1411; --bs-body-color: #F3E9E2; --bs-border-color: #3D2C25;
            --bs-tertiary-bg: #2A1D18; --bs-secondary-color: #B7A79E;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--ink); }
        a:not(.btn):not(.nav-link):not(.dropdown-item) { color: var(--link); }
        .bg-white { background-color: var(--card) !important; }

        #topLoader { position: fixed; top: 0; left: 0; height: 3px; width: 0; opacity: 0; z-index: 3000;
            background: var(--mint-d); transition: width .8s ease, opacity .3s ease; }

        .sidebar { position: fixed; inset: 0 auto 0 0; width: 250px; padding: 22px 14px; overflow-y: auto; z-index: 1040;
            background: var(--side); transition: transform .3s ease; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 10px; color: #fff; font-weight: 600; font-size: 1.3rem; padding: 0 8px; margin-bottom: 24px; text-decoration: none; }
        .brand-icon { width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; font-size: 1.2rem; background: var(--mint); color: var(--choco-d); }
        .menu-label { color: #CDB8AC; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; margin: 20px 0 8px 12px; }
        .sidebar .nav-link { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,.78); border-radius: 12px; padding: 10px 14px; margin-bottom: 4px; transition: all .2s ease; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.09); color: #fff; transform: translateX(4px); }
        .sidebar .nav-link.active { background: var(--mint); color: var(--choco-d); font-weight: 500; }
        .overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1030; display: none; }
        .overlay.show { display: block; }

        .main { margin-left: 250px; min-height: 100vh; }
        .topbar { position: sticky; top: 0; z-index: 1020; display: flex; align-items: center; gap: 12px; padding: 12px 24px;
            background: var(--card); border-bottom: 1px solid var(--line); }
        .avatar { width: 38px; height: 38px; border-radius: 50%; display: grid; place-items: center; font-weight: 600; background: var(--mint); color: var(--choco-d); }
        .icon-btn { width: 40px; height: 40px; padding: 0; display: grid; place-items: center; border-radius: 12px; border: 1px solid var(--line); background: transparent; color: var(--ink); }
        .content { padding: 24px; }

        .card { background: var(--card); color: var(--ink); border: 0; border-radius: 16px; box-shadow: 0 2px 14px rgba(58,38,32,.08); }
        .card-header { background: transparent; border-bottom: 1px solid var(--line); }
        .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 14px 30px rgba(58,38,32,.16); }

        .btn { border-radius: 10px; font-weight: 500; transition: transform .15s ease, box-shadow .2s ease, background .2s ease; }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: scale(.96); }
        .btn-primary { --bs-btn-bg: var(--mint); --bs-btn-border-color: var(--mint); --bs-btn-color: var(--choco-d);
            --bs-btn-hover-bg: var(--mint-d); --bs-btn-hover-border-color: var(--mint-d); --bs-btn-hover-color: var(--choco-d);
            --bs-btn-active-bg: var(--mint-d); --bs-btn-active-border-color: var(--mint-d); --bs-btn-active-color: var(--choco-d);
            --bs-btn-disabled-bg: var(--mint); --bs-btn-disabled-border-color: var(--mint); --bs-btn-disabled-color: var(--choco-d); }
        .btn-primary:hover { box-shadow: 0 8px 18px rgba(127,207,174,.45); }
        .btn-outline-primary { --bs-btn-color: var(--btn-o); --bs-btn-border-color: var(--btn-o); --bs-btn-hover-bg: var(--btn-o);
            --bs-btn-hover-border-color: var(--btn-o); --bs-btn-hover-color: var(--card); --bs-btn-active-bg: var(--btn-o); --bs-btn-active-color: var(--card); }
        .text-bg-primary { background-color: var(--choco) !important; color: #fff !important; }
        [data-bs-theme=dark] .text-bg-primary { background-color: var(--mint) !important; color: var(--choco-d) !important; }
        .form-control, .form-select { border-radius: 10px; background-color: var(--card); color: var(--ink); border-color: var(--line); }
        .form-control:focus, .form-select:focus { border-color: var(--mint-d); box-shadow: 0 0 0 .25rem rgba(159,224,197,.4); background-color: var(--card); color: var(--ink); }

        .table { --bs-table-bg: transparent; --bs-table-color: var(--ink); --bs-table-hover-bg: var(--mint-l); --bs-table-hover-color: var(--ink); --bs-table-border-color: var(--line); }
        .table-light { --bs-table-bg: var(--th-bg); --bs-table-color: var(--muted); --bs-table-border-color: var(--line); }
        .table > :not(caption) > * > * { padding: .85rem 1rem; }
        .table thead th { font-size: .72rem; text-transform: uppercase; letter-spacing: .05em; white-space: nowrap; }

        .stat-icon { width: 54px; height: 54px; border-radius: 16px; display: grid; place-items: center; font-size: 1.5rem; flex-shrink: 0; }
        .si-1 { background: var(--mint); color: var(--choco-d); }
        .si-2 { background: #F6D38A; color: #5A3E00; }
        .si-3 { background: #CFEFE1; color: #1F5C45; }
        .si-4 { background: var(--choco); color: #fff; }
        [data-bs-theme=dark] .si-4 { background: #6B4A3D; }

        .info-stok { font-size: .85rem; padding: 8px 12px; border-radius: 10px; }
        .info-ok { background: var(--mint-l); color: var(--ink); }
        .info-warn { background: #FFF3CD; color: #664D03; }
        .info-bad { background: #F8D7DA; color: #842029; }
        [data-bs-theme=dark] .info-warn { background: #4A3B12; color: #FFE08A; }
        [data-bs-theme=dark] .info-bad { background: #4A1F24; color: #F5B5BB; }

        .toast { background: var(--card); color: var(--ink); border: 0; border-left: 5px solid var(--mint-d); border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,.18); min-width: 300px; }
        .toast-success i { color: #2FB783; }
        .toast-danger { border-left-color: #E5675F; } .toast-danger i { color: #E5675F; }
        .toast-warning { border-left-color: #F2B84B; } .toast-warning i { color: #F2B84B; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
        .page-enter { animation: fadeUp .45s ease both; }
        .stagger > * { animation: fadeUp .55s ease both; }
        .stagger > *:nth-child(2) { animation-delay: .08s; }
        .stagger > *:nth-child(3) { animation-delay: .16s; }
        .stagger > *:nth-child(4) { animation-delay: .24s; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: none; }
            .main { margin-left: 0; }
            .topbar { padding: 12px 16px; }
            .content { padding: 16px; }
        }
    </style>
</head>
<body>
<div id="topLoader"></div>
<div class="overlay" id="overlay"></div>

<aside class="sidebar" id="sidebar">
    <a href="{{ url('/dashboard') }}" class="brand">
        <span class="brand-icon"><i class="bi bi-box-seam"></i></span>
        StokKu
    </a>

    <nav class="nav flex-column">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>

        @if (auth()->user()->role === 'admin')
            <div class="menu-label">Data master</div>
            <a class="nav-link {{ request()->is('barang*') ? 'active' : '' }}" href="{{ url('/barang') }}">
                <i class="bi bi-box"></i><span>Barang</span>
            </a>
            <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="{{ url('/kategori') }}">
                <i class="bi bi-tags"></i><span>Kategori</span>
            </a>
            <a class="nav-link {{ request()->is('supplier*') ? 'active' : '' }}" href="{{ url('/supplier') }}">
                <i class="bi bi-truck"></i><span>Supplier</span>
            </a>
            <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}" href="{{ url('/user') }}">
                <i class="bi bi-people"></i><span>User</span>
            </a>
        @endif

        @if (auth()->user()->role === 'staf')
            <div class="menu-label">Transaksi</div>
            <a class="nav-link {{ request()->is('stok-masuk*') ? 'active' : '' }}" href="{{ url('/stok-masuk') }}">
                <i class="bi bi-box-arrow-in-down"></i><span>Stok masuk</span>
            </a>
            <a class="nav-link {{ request()->is('stok-keluar*') ? 'active' : '' }}" href="{{ url('/stok-keluar') }}">
                <i class="bi bi-box-arrow-up"></i><span>Stok keluar</span>
            </a>
        @endif

        <div class="menu-label">Laporan</div>
        <a class="nav-link {{ request()->is('riwayat*') ? 'active' : '' }}" href="{{ url('/riwayat') }}">
            <i class="bi bi-clock-history"></i><span>Riwayat stok</span>
        </a>
    </nav>

    <div class="mt-auto pt-4">
        <a class="nav-link" href="#" data-logout>
            <i class="bi bi-box-arrow-left"></i><span>Keluar</span>
        </a>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <button class="icon-btn d-lg-none" id="burger" type="button" aria-label="Menu"><i class="bi bi-list fs-5"></i></button>
        <h6 class="mb-0 flex-grow-1">@yield('title', 'StokKu')</h6>

        <button class="icon-btn" id="themeToggle" type="button" aria-label="Ganti tema" title="Ganti tema"></button>

        <div class="dropdown">
            <button class="btn p-0 border-0 d-flex align-items-center gap-2" data-bs-toggle="dropdown" type="button">
                <span class="avatar">{{ strtoupper(mb_substr(auth()->user()->nama, 0, 1)) }}</span>
                <span class="text-start d-none d-sm-block lh-sm">
                    <span class="d-block fw-medium small">{{ auth()->user()->nama }}</span>
                    <span class="d-block text-secondary text-uppercase" style="font-size: .7rem;">{{ auth()->user()->role }}</span>
                </span>
                <i class="bi bi-chevron-down small"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                <li>
                    <a class="dropdown-item text-danger" href="#" data-logout>
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="content page-enter">
        @yield('content')
    </main>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" id="toastWrap" style="z-index: 3100;"></div>

<form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>

<div id="flash" class="d-none"
     data-success="{{ session('success') }}"
     data-error="{{ session('error') }}"
     data-warning="{{ $errors->any() ? 'Periksa kembali isian formulir.' : '' }}"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
    var html = document.documentElement;
    var isDark = function () { return html.getAttribute('data-bs-theme') === 'dark'; };
    var loader = document.getElementById('topLoader');

    function startLoader() { loader.style.opacity = 1; loader.style.width = '70%'; }
    function doneLoader() {
        loader.style.width = '100%';
        setTimeout(function () { loader.style.opacity = 0; loader.style.width = 0; }, 300);
    }

    function setLoading(form) {
        startLoader();
        form.querySelectorAll('button[type=submit], button:not([type])').forEach(function (b) {
            b.dataset.html = b.innerHTML;
            b.disabled = true;
            b.innerHTML = '<span class="spinner-border spinner-border-sm"></span>' +
                (b.classList.contains('btn-sm') ? '' : '<span class="ms-2">Memproses...</span>');
        });
    }
    function resetButtons() {
        document.querySelectorAll('button[data-html]').forEach(function (b) {
            b.innerHTML = b.dataset.html;
            b.disabled = false;
            delete b.dataset.html;
        });
    }
    window.addEventListener('pageshow', function () { doneLoader(); resetButtons(); });

    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a || a.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
        var href = a.getAttribute('href');
        if (!href || href.charAt(0) === '#' || href.indexOf('javascript') === 0) return;
        if (a.hasAttribute('data-bs-toggle') || a.origin !== location.origin) return;
        startLoader();
    });

    document.addEventListener('submit', function (e) {
        var f = e.target;
        if (f.method.toLowerCase() === 'get') { startLoader(); return; }
        setTimeout(function () { setLoading(f); }, 0);
    });

    function konfirmasi(o) {
        return Swal.fire({
            title: o.title, text: o.text, icon: o.danger ? 'warning' : 'question',
            showCancelButton: true, confirmButtonText: o.ok, cancelButtonText: 'Batal', reverseButtons: true,
            confirmButtonColor: o.danger ? '#C0392B' : '#4B3128', cancelButtonColor: '#8D7B72',
            background: isDark() ? '#2A1D18' : '#ffffff', color: isDark() ? '#F3E9E2' : '#3A2620',
            focusCancel: !!o.danger
        });
    }

    document.querySelectorAll('form').forEach(function (f) {
        var m = f.querySelector('input[name=_method]');
        if (!m || m.value !== 'DELETE') return;
        var teks = 'Hapus data ini?';
        var cocok = (f.getAttribute('onsubmit') || '').match(/confirm\('(.+?)'\)/);
        if (cocok) teks = cocok[1];
        f.removeAttribute('onsubmit');
        f.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            konfirmasi({ title: teks, text: 'Data yang dihapus tidak bisa dikembalikan.', ok: 'Ya, hapus', danger: true })
                .then(function (r) { if (r.isConfirmed) { setLoading(f); f.submit(); } });
        });
    });

    document.querySelectorAll('[data-logout]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            konfirmasi({ title: 'Keluar dari StokKu?', text: 'Anda perlu login lagi untuk masuk.', ok: 'Ya, keluar' })
                .then(function (r) { if (r.isConfirmed) { startLoader(); document.getElementById('logoutForm').submit(); } });
        });
    });

    function toast(pesan, tipe) {
        var ikon = { success: 'bi-check-circle-fill', danger: 'bi-x-circle-fill', warning: 'bi-exclamation-triangle-fill' }[tipe];
        var el = document.createElement('div');
        el.className = 'toast toast-' + tipe;
        el.setAttribute('role', 'alert');
        el.innerHTML = '<div class="d-flex align-items-center gap-3 p-3"><i class="bi ' + ikon + ' fs-4"></i>' +
            '<div class="flex-grow-1"></div><button type="button" class="btn-close" data-bs-dismiss="toast"></button></div>';
        el.querySelector('.flex-grow-1').textContent = pesan;
        document.getElementById('toastWrap').appendChild(el);
        el.addEventListener('hidden.bs.toast', function () { el.remove(); });
        new bootstrap.Toast(el, { delay: 4500 }).show();
    }
    var fl = document.getElementById('flash');
    if (fl.dataset.success) toast(fl.dataset.success, 'success');
    if (fl.dataset.error) toast(fl.dataset.error, 'danger');
    if (fl.dataset.warning) toast(fl.dataset.warning, 'warning');

    var tbtn = document.getElementById('themeToggle');
    function ikonTema() { tbtn.innerHTML = isDark() ? '<i class="bi bi-sun fs-5"></i>' : '<i class="bi bi-moon-stars fs-5"></i>'; }
    ikonTema();
    tbtn.addEventListener('click', function () {
        var baru = isDark() ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', baru);
        localStorage.setItem('stokku-tema', baru);
        ikonTema();
        window.dispatchEvent(new Event('themechange'));
    });

    var sb = document.getElementById('sidebar'), ov = document.getElementById('overlay');
    function toggleSb() { sb.classList.toggle('show'); ov.classList.toggle('show'); }
    document.getElementById('burger').addEventListener('click', toggleSb);
    ov.addEventListener('click', toggleSb);

    document.querySelectorAll('.btn i.bi-pencil').forEach(function (i) { i.closest('.btn').setAttribute('title', 'Ubah'); });
    document.querySelectorAll('.btn i.bi-trash').forEach(function (i) { i.closest('.btn').setAttribute('title', 'Hapus'); });
    document.querySelectorAll('[title]').forEach(function (el) { new bootstrap.Tooltip(el, { trigger: 'hover' }); });

    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseInt(el.dataset.count, 10) || 0, mulai = null;
        function langkah(ts) {
            if (!mulai) mulai = ts;
            var p = Math.min((ts - mulai) / 900, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(langkah);
        }
        requestAnimationFrame(langkah);
    });

    document.querySelectorAll('input[name=q]').forEach(function (inp) {
        var body = document.querySelector('table tbody');
        if (!body) return;
        inp.addEventListener('input', function () {
            var kata = inp.value.toLowerCase();
            body.querySelectorAll('tr').forEach(function (tr) {
                if (tr.querySelector('td[colspan]')) return;
                tr.style.display = tr.textContent.toLowerCase().indexOf(kata) > -1 ? '' : 'none';
            });
        });
    });

    var info = document.getElementById('infoStok');
    if (info) {
        var mode = info.dataset.mode;
        var sel = document.querySelector('select[name=id_barang]');
        var jml = document.querySelector('input[name=jumlah]');
        var tombol = info.closest('form').querySelector('button[type=submit], button:not([type])');
        var esc = function (s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; };
        function hitung() {
            var opt = sel.options[sel.selectedIndex];
            if (!opt || !opt.value) {
                info.className = 'info-stok d-none mt-2';
                jml.classList.remove('is-invalid');
                tombol.disabled = false;
                return;
            }
            var stok = parseInt(opt.dataset.stok, 10), min = parseInt(opt.dataset.min, 10), sat = esc(opt.dataset.satuan);
            var n = parseInt(jml.value, 10) || 0;
            var pesan = 'Stok saat ini: <b>' + stok + ' ' + sat + '</b>', kelas = 'info-ok', blok = false;
            if (mode === 'masuk') {
                if (n > 0) pesan += ' &rarr; setelah masuk: <b>' + (stok + n) + ' ' + sat + '</b>';
            } else if (n > stok) {
                pesan += ' &mdash; jumlah melebihi stok';
                kelas = 'info-bad';
                blok = true;
            } else if (n > 0) {
                var sisa = stok - n;
                pesan += ' &rarr; sisa: <b>' + sisa + ' ' + sat + '</b>';
                if (sisa <= min) { pesan += ' (di bawah stok minimum)'; kelas = 'info-warn'; }
            }
            info.className = 'info-stok mt-2 ' + kelas;
            info.innerHTML = pesan;
            jml.classList.toggle('is-invalid', blok);
            tombol.disabled = blok;
        }
        sel.addEventListener('change', hitung);
        jml.addEventListener('input', hitung);
        hitung();
    }
})();
</script>
@stack('scripts')
</body>
</html>