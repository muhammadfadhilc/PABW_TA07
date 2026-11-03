# SmartResident RoadWatch — Praktikum Modul 7 (CRUD & Upload Foto)

**Mulai dari `PANDUAN_MODUL7_TA_ROADWATCH.md`** untuk cara instalasi, alur resource CRUD, dan bukti screenshot. Project ini melanjutkan Modul 6 dan mempertahankan login manual.

---

# SmartResident — Tugas Akhir Semester 2, Tugas Praktikum Modul 4 (Nomor 2 dan 3)

Nama: **Muhammad Fadhil Cholilullah** · NIM **707012500122** · Kelas **D4-SIKC-49-01**.

Ini merupakan kelanjutan dari **SmartResidentLaravel_Modul3** (konversi Tugas Akhir Semester 2 ke Laravel Blade), bukan aplikasi contoh baru. Sistem ini mengelola **akun warga, akun petugas/admin, dan laporan kerusakan fasilitas Desa Citeureup**. Entitas dan istilah tabel berasal dari `database/legacy/db_smartresident.sql` pada Tugas Akhir asli.

## Analisis kebutuhan data

| Tabel | Kolom penting | Tipe/keterangan |
|---|---|---|
| `warga_v2` | `id`, `nama`, `username`, `password`, timestamps | `id()` PK; string(100), string(50) unik, string; created_at & updated_at |
| `admins_v2` | `id`, `nama`, `username`, `password`, `role`, timestamps | `id()` PK; nama/username string, username unik, role string, timestamps |
| `laporan_v2` | `id`, `id_warga`, `tipe_fasilitas`, `lokasi`, `deskripsi`, `status`, `tanggal_lapor`, `id_kontraktor`, timestamps | `id()` PK; `id_warga` FK wajib ke warga; `id_kontraktor` FK nullable ke admins; text deskripsi nullable; status string; tanggal_lapor dateTime |

Relasi: satu warga bisa memiliki banyak laporan; setiap laporan punya satu pelapor. Satu kontraktor/admin dapat ditugaskan ke banyak laporan. FK melindungi integritas data.

## Cara menjalankan di Laragon

1. Ekstrak folder `SmartResident_Modul4` ke `C:\laragon\www\`. Jalankan MySQL dari Laragon.
2. Buka phpMyAdmin dan buat database **`db_smartresident`** (atau impor/jalankan `database/buat_database.sql`). Tidak perlu membuat tabel secara manual.
3. Buka terminal di folder Laravel, lalu jalankan perintah ini sesuai urutan:

```bash
composer install
php artisan key:generate
php artisan config:clear
php artisan migrate
php artisan db:seed
php artisan serve --port=8001
```

Konfigurasi `.env` telah disediakan untuk MySQL, port 3306, database `db_smartresident`, username `root`, password kosong. **Sesuaikan username/password/port jika Laragon berbeda.** Laravel project Tugas Akhir ini berbasis Laravel 12 (PHP 8.2+).

## Database seeder

Seeder sudah terdaftar di `database/seeders/DatabaseSeeder.php` melalui `$this->call([...])`:

- `WargaSeeder` → 3 akun warga lama + **12 Faker** (locale `id_ID`).
- `AdminPetugasSeeder` → 3 akun petugas lama + **4 Faker**.
- `LaporanFasilitasSeeder` → 3 laporan asli + **20 laporan Faker** (nama terkait data warga acak, kategori fasilitas acak, alamat Indonesia, status bervariasi, tanggal sebulan terakhir).

Jika ingin menghapus seluruh data dan mengisi ulang dari nol pada database latihan, boleh gunakan `php artisan migrate:fresh --seed`. **Perintah ini menghapus data lama.**

## Uji halaman Blade yang benar-benar membaca database

- Beranda: http://127.0.0.1:8001/
- Login warga: http://127.0.0.1:8001/warga/login → `fadhil` / `warga123`
- Dashboard warga: http://127.0.0.1:8001/warga/dashboard
- Login admin: http://127.0.0.1:8001/admin/login → `admin` / `admin123`
- Dashboard admin: http://127.0.0.1:8001/admin/dashboard
- Akun superadmin: `super` / `super123`

Setelah login, data laporan dibaca menggunakan model `LaporanFasilitas` melalui `SmartResidentData`. Pendaftaran, tambah laporan, ubah status, hapus laporan, dan manajemen admin juga terhubung ke MySQL. Password disimpan dalam bentuk **hash**.

## File relevan untuk penilaian

- `database/migrations/2026_10_11_000001_create_warga_v2_table.php`
- `database/migrations/2026_10_11_000002_create_admins_v2_table.php`
- `database/migrations/2026_10_11_000003_create_laporan_v2_table.php`
- `app/Models/{Warga,AdminPetugas,LaporanFasilitas}.php`
- `database/seeders/{WargaSeeder,AdminPetugasSeeder,LaporanFasilitasSeeder,DatabaseSeeder}.php`
- `app/Services/SmartResidentData.php` — adapter ke model Eloquent (menjaga kompatibilitas Blade dari Modul 3).

## Bukti screenshot di phpMyAdmin yang perlu diambil pada laptop sendiri

1. `db_smartresident` dengan tiga tabel + struktur kolom/timestamps.
2. **Relation view** `laporan_v2`: foreign key `id_warga` dan `id_kontraktor`.
3. **Browse** `warga_v2` (minimal 15 baris), `admins_v2` (minimal 7), dan `laporan_v2` (minimal 23).
4. Dashboard warga dan admin setelah seed, serta hasil input laporan baru dari form.

**Catatan:** Folder `laporbanjir` yang masih ada di project ini merupakan demo Modul 3. Untuk **Tugas Praktikum Modul 4 nomor 1**, jalankan project **LaporBanjir_Modul4** yang disertakan terpisah; untuk nomor 2–3 jalankan project ini. Dua project memakai database berbeda sesuai soal.
