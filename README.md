# StokKu

**Sistem Informasi Inventori Toko Kelontong**
Tugas RPL Studio, Tema 7: Sistem Manajemen Toko dan Inventori

StokKu adalah aplikasi web untuk mencatat dan memantau stok barang di toko kelontong. Aplikasi ini menggantikan pencatatan manual dengan data yang tersimpan rapi di database, sehingga stok yang tersedia, barang yang hampir habis, dan riwayat keluar masuk barang bisa dilihat kapan saja.

## Pengguna Sistem

| Peran | Hak akses |
|-------|-----------|
| **Admin** | Mengelola data master (barang, kategori, supplier, user) dan melihat riwayat stok |
| **Staf gudang** | Mencatat stok masuk dan stok keluar, melihat dashboard dan riwayat stok |

Semua pengguna wajib login terlebih dahulu. Setelah login, sistem mengarahkan ke menu sesuai peran.

## Fitur Utama

- Login dan logout dengan pembagian peran (admin / staf gudang)
- Kelola data barang (kode, nama, kategori, harga beli, harga jual, stok, stok minimum, satuan)
- Kelola data kategori
- Kelola data supplier
- Kelola user (khusus admin)
- Catat stok masuk (stok barang otomatis bertambah)
- Catat stok keluar (stok barang otomatis berkurang, transaksi ditolak jika stok tidak cukup)
- Riwayat transaksi stok masuk dan keluar
- Dashboard berisi total barang, stok menipis, serta jumlah barang masuk dan keluar hari ini
- Grafik stok masuk dan keluar 7 hari terakhir
- Grafik kondisi stok (aman, menipis, habis)
- Daftar barang hampir habis lengkap dengan indikator sisa stok
- Mode gelap dan terang

## Alur Kerja

**Admin**
1. Login, lalu mengisi data kategori dan supplier
2. Menambah data barang beserta stok awal dan stok minimum
3. Membuat akun staf gudang di menu Kelola User
4. Memantau semua transaksi lewat menu Riwayat

**Staf gudang**
- *Stok masuk:* pilih barang dan supplier, isi jumlah, tanggal, dan keterangan, lalu simpan. Stok barang bertambah otomatis.
- *Stok keluar:* pilih barang dan isi jumlah. Jika stok cukup, transaksi disimpan dan stok barang berkurang. Jika stok kurang, muncul pesan peringatan.


## Cara Install

1. Clone repo
   ```bash
   git clone https://github.com/ulfamailani/StokKu.git
   cd StokKu
   ```
2. Install dependency
   ```bash
   composer install
   ```
3. Copy file env, lalu atur koneksi database di `.env`
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
4. Buat database kosong di MySQL (misal `stokku`), lalu jalankan migration
   ```bash
   php artisan migrate
   ```
5. Jalankan server
   ```bash
   php artisan serve
   ```
6. Buka `http://127.0.0.1:8000` di browser

