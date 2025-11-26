## Jatilawang Adventure

Platform rental & penjualan perlengkapan outdoor yang dibangun di atas Laravel 11 + Blade + Tailwind. Proyek ini sudah mencakup checkout gabungan (sewa & beli), verifikasi stok real-time, pengiriman dengan geolokasi, Socialite Google login, serta dashboard admin untuk memantau transaksi.

## Kebutuhan Sistem

- PHP 8.2+ dengan ekstensi `mbstring`, `openssl`, `pdo_mysql`, `curl`, `fileinfo`
- Composer 2+
- Node 18+ & npm (untuk aset via Vite)
- MySQL/MariaDB (disarankan nama database `jatilawang_adventure`)

## Langkah Instalasi Cepat

1. **Clone & install**
	```bash
	git clone https://github.com/Bilabong29/Jatilawang_web.git
	cd jatilawang-adventure2
	composer install
	npm install
	```
2. **Salin konfigurasi**
	```bash
	cp .env.example .env
	php artisan key:generate
	```
	Sesuaikan kredensial MySQL & nilai `ADMIN_*` bila ingin mengganti data admin default.
3. **Migrasi & seed**
	```bash
	php artisan migrate --seed
	```
	Perintah di atas akan membuat semua tabel (rentals, buys, transactions, reviews, dll), mengisi katalog `items`, dan membuat 1 admin.
4. **Build aset & jalankan**
	```bash
	npm run build    # atau npm run dev -- --watch
	php artisan serve
	```

### Kredensial Default

- Admin: `admin@jatilawang.test` / `admin123` (ubah melalui `.env` sebelum deploy production)
- Customer akun dibuat lewat registrasi/email Google, jadi tidak ada seeding otomatis untuk user biasa sesuai permintaan.

### Import Data Penuh (Opsional)

Anda masih bisa mengimpor dump SQL yang dibagikan (`jatilawang_adventure.sql`) bila ingin replika data produksi. Setelah impor, jalankan `php artisan migrate` untuk memastikan skema terbaru tetap sinkron.

## Script Penting

- `php artisan migrate:fresh --seed` – reset database sesuai dataset standar.
- `php artisan db:seed --class=AdminUserSeeder` – regenerasi admin setelah mengganti password.
- `php artisan queue:work` – jalankan job (opsional bila mengganti `QUEUE_CONNECTION`).

## Struktur Data

- Stok sewa/beli tersimpan di tabel `items` (`rental_stock`, `sale_stock`).
- Rincian transaksi ada pada `transactions` & `transaction_items` dengan relasi polymorphic ringan.
- Review pelanggan menggunakan tabel `ratings` (per transaksi) dan `reviews` (review publik singkat) sesuai kebutuhan halaman katalog.

## Kontribusi & Saran

Silakan buat issue/PR jika menemukan bug. Untuk perubahan signifikan di schema, jalankan `php artisan schema:dump` atau dokumentasikan di `MIGRATION_MAP.md` supaya tim lain mudah mengikuti.
