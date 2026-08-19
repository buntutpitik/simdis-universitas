# SIMDIS Universitas

**Sistem Informasi Manajemen Disposisi Surat**

SIMDIS Universitas adalah aplikasi berbasis web untuk membantu pengelolaan administrasi persuratan di lingkungan universitas, mulai dari pencatatan surat masuk, surat keluar, disposisi, penyimpanan dokumen, hingga pembuatan laporan.

Aplikasi dirancang menggunakan sistem **Role-Based Access Control (RBAC)** sehingga setiap pengguna memperoleh akses sesuai tugas dan kewenangannya.

---

## Status Project

| Informasi | Keterangan |
|---|---|
| Versi | 1.0 |
| Status | Production Ready / Pilot Release |
| Framework | Laravel 13 |
| PHP | 8.3 |
| Database | MariaDB / MySQL |
| Frontend | Blade + Tailwind CSS + Vite |
| Authorization | Spatie Laravel Permission |

Versi 1.0 merupakan versi awal yang telah menyelesaikan kebutuhan utama sistem persuratan dan siap digunakan untuk tahap implementasi/pilot.

Pengembangan berikutnya akan dilakukan berdasarkan evaluasi dan masukan dari pengguna.

---

# Fitur Utama

SIMDIS Universitas menyediakan fitur:

- Dashboard
- Autentikasi pengguna
- Manajemen pengguna
- Manajemen jabatan
- Role & Permission
- Surat Masuk
- Surat Keluar
- Upload dokumen PDF
- Private document storage
- Disposisi Surat
- Multi-penerima disposisi
- Proses dan penyelesaian disposisi
- Laporan persuratan
- Export PDF
- Export Excel
- Filter dan pencarian data
- Proteksi dokumen berdasarkan authentication dan permission

---

# Role Pengguna

SIMDIS menggunakan empat role utama.

## 1. Administrator

Administrator memiliki akses penuh terhadap sistem.

Akses utama:

- Dashboard
- Manajemen pengguna
- Manajemen jabatan
- Surat Masuk
- Surat Keluar
- Disposisi
- Laporan
- Pengaturan role dan permission yang tersedia melalui aplikasi

---

## 2. Admin Persuratan

Admin Persuratan bertugas mengelola administrasi surat.

Akses utama:

- Dashboard
- Surat Masuk
- Tambah Surat Masuk
- Edit Surat Masuk
- Hapus Surat Masuk
- Surat Keluar
- Tambah Surat Keluar
- Edit Surat Keluar
- Hapus Surat Keluar
- Melihat disposisi
- Membuat disposisi
- Mengedit disposisi
- Memproses disposisi
- Menyelesaikan disposisi

---

## 3. Rektor

Akses utama:

- Dashboard
- Melihat Surat Masuk
- Melihat Surat Keluar
- Melihat Disposisi
- Memproses Disposisi
- Menyelesaikan Disposisi
- Melihat Laporan

---

## 4. Staf

Akses utama:

- Dashboard
- Melihat Surat Masuk
- Membuat Surat Masuk
- Melihat Surat Keluar
- Melihat Disposisi
- Memproses Disposisi
- Menyelesaikan Disposisi

---

# Alur Penggunaan

## Login

Pengguna membuka alamat SIMDIS melalui browser dan login menggunakan akun yang telah dibuat oleh Administrator.

Menu dan tindakan yang tersedia akan menyesuaikan permission pengguna.

---

# Surat Masuk

Menu **Surat Masuk** digunakan untuk mencatat surat yang diterima universitas.

Sesuai permission yang dimiliki, pengguna dapat:

1. Menambahkan Surat Masuk.
2. Mengisi informasi surat.
3. Mengunggah dokumen PDF.
4. Melihat detail surat.
5. Membuka dokumen surat.
6. Mengedit surat.
7. Menghapus surat.
8. Membuat disposisi dari surat yang diterima.

Dokumen yang diunggah tidak diekspos secara langsung melalui public storage.

---

# Surat Keluar

Menu **Surat Keluar** digunakan untuk mengelola surat yang diterbitkan universitas.

Sesuai permission yang dimiliki, pengguna dapat:

1. Menambahkan Surat Keluar.
2. Mengisi informasi surat.
3. Mengunggah dokumen PDF.
4. Melihat detail surat.
5. Membuka dokumen surat.
6. Mengedit surat.
7. Menghapus surat.

---

# Disposisi

Disposisi digunakan untuk meneruskan dan menindaklanjuti Surat Masuk kepada pihak yang dituju.

Alur umum:

```text
Surat Masuk
     ↓
  Disposisi
     ↓
 Penerima
     ↓
  Diproses
     ↓
   Selesai
```

Sistem mendukung lebih dari satu penerima disposisi.

Tindakan yang dapat dilakukan pengguna bergantung pada permission masing-masing.

---

# Laporan

Menu **Laporan** digunakan untuk melihat rekap data persuratan.

Laporan dapat diekspor ke:

- PDF
- Excel

Akses laporan dibatasi menggunakan permission `reports.view`.

---

# Keamanan Dokumen

Dokumen Surat Masuk dan Surat Keluar disimpan menggunakan **private storage**.

Lokasi penyimpanan:

```text
storage/app/private/incoming_letters/
storage/app/private/outgoing_letters/
```

Dokumen tidak boleh ditempatkan pada:

```text
public/storage/
```

Akses dokumen dilakukan melalui route aplikasi yang dilindungi:

- Authentication
- Role/Permission

Contoh alur:

```text
Browser
   ↓
Authenticated Route
   ↓
Permission Check
   ↓
Controller
   ↓
Private Storage
   ↓
PDF Response
```

Akses langsung seperti:

```text
https://domain.example/storage/incoming_letters/file.pdf
```

harus ditolak.

---

# Role-Based Access Control

SIMDIS menggunakan:

**Spatie Laravel Permission**

Permission utama yang digunakan meliputi:

```text
dashboard.view

users.view
users.create
users.edit
users.delete

positions.view
positions.create
positions.edit
positions.delete

incoming.view
incoming.create
incoming.edit
incoming.delete

outgoing.view
outgoing.create
outgoing.edit
outgoing.delete

disposition.view
disposition.create
disposition.edit
disposition.delete
disposition.process
disposition.complete

reports.view
```

Permission diberikan berdasarkan role pengguna.

---

# Teknologi

Backend:

- Laravel 13
- PHP 8.3
- MariaDB / MySQL

Frontend:

- Blade
- Tailwind CSS
- Vite
- JavaScript

Authorization:

- Spatie Laravel Permission

Dokumen & Laporan:

- PDF
- Excel

---

# Struktur Project

Struktur utama:

```text
simdis-universitas/
│
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── Services/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── build/
│   ├── images/
│   └── index.php
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
├── storage/
│   └── app/
│       └── private/
│
├── tests/
├── artisan
├── composer.json
├── composer.lock
├── package.json
└── vite.config.js
```

---

# Instalasi Development / Local

## Persyaratan

Pastikan komputer memiliki:

- PHP 8.3 atau versi kompatibel
- Composer
- Node.js
- NPM
- MariaDB / MySQL
- Git

---

## 1. Clone Repository

```bash
git clone REPOSITORY_URL
cd simdis-universitas
```

Atau download repository dalam format ZIP dan ekstrak.

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Install Frontend Dependencies

```bash
npm install
```

---

## 4. Environment

Copy:

```text
.env.example
```

menjadi:

```text
.env
```

Linux/macOS:

```bash
cp .env.example .env
```

Windows CMD:

```bat
copy .env.example .env
```

Sesuaikan konfigurasi database.

Contoh:

```env
APP_NAME="SIMDIS Universitas"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simdis
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 6. Migration

```bash
php artisan migrate
```

---

## 7. Seeder Data Master

```bash
php artisan db:seed --class=PositionSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RolePermissionSeeder
```

Seeder dummy/test hanya digunakan jika memang dibutuhkan untuk development.

---

## 8. Jalankan Frontend

Development:

```bash
npm run dev
```

Production build:

```bash
npm run build
```

---

## 9. Jalankan Laravel

```bash
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000
```

---

# Production Deployment

Terdapat dua metode deployment:

1. Deployment menggunakan Git.
2. Deployment manual menggunakan ZIP dan cPanel/File Manager.

---

# Metode A — Deployment Menggunakan Git

Metode ini direkomendasikan jika hosting menyediakan SSH dan Git.

## 1. Clone Repository

Masuk ke direktori di luar `public_html`.

Contoh:

```bash
cd /home/USERNAME

git clone REPOSITORY_URL simdis-universitas
```

Source Laravel sebaiknya berada di:

```text
/home/USERNAME/simdis-universitas
```

dan bukan langsung di `public_html`.

---

## 2. Persiapkan Dependencies

Jika Composer tersedia dan dapat berjalan:

```bash
composer install --no-dev --optimize-autoloader
```

Jika Composer tidak dapat berjalan pada shared hosting, siapkan folder `vendor` dari komputer lokal.

Pada lokal:

```bash
composer install --no-dev --optimize-autoloader
```

Kemudian upload:

```text
vendor/
```

ke:

```text
/home/USERNAME/simdis-universitas/vendor/
```

---

## 3. Build Frontend

Jika server tidak menyediakan Node.js/NPM, build di komputer lokal:

```bash
npm install
npm run build
```

Kemudian upload:

```text
public/build/
```

ke server.

---

## 4. Konfigurasi Environment

Buat:

```text
.env
```

Contoh:

```env
APP_NAME="SIMDIS Universitas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://simdis.domainkampus.ac.id

APP_LOCALE=id
APP_FALLBACK_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=USER_DATABASE
DB_PASSWORD=PASSWORD_DATABASE
```

Jangan commit `.env`.

---

## 5. Generate APP_KEY

```bash
php artisan key:generate
```

Pada CloudLinux dengan PHP alternatif, contoh:

```bash
/opt/alt/php83/usr/bin/php artisan key:generate
```

---

## 6. Database

Jalankan:

```bash
php artisan migrate --force
```

Kemudian data master:

```bash
php artisan db:seed --class=PositionSeeder --force
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=PermissionSeeder --force
php artisan db:seed --class=RolePermissionSeeder --force
```

Hindari menjalankan seeder dummy pada production.

---

## 7. Private Storage

Pastikan tersedia:

```bash
mkdir -p storage/app/private/incoming_letters
mkdir -p storage/app/private/outgoing_letters
```

---

## 8. Permission

Gunakan permission sesuai kebutuhan web server.

Contoh:

```bash
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Hindari:

```text
chmod -R 777
```

---

## 9. Document Root

Buat domain/subdomain melalui hosting.

Contoh:

```text
https://simdis.domainkampus.ac.id
```

Document root:

```text
/home/USERNAME/public_html/simdis.domainkampus.ac.id
```

Source Laravel tetap:

```text
/home/USERNAME/simdis-universitas
```

Hanya isi folder `public/` Laravel yang diekspos.

---

## 10. Public Files

Copy isi:

```text
/home/USERNAME/simdis-universitas/public/
```

ke:

```text
/home/USERNAME/public_html/simdis.domainkampus.ac.id/
```

---

## 11. index.php Production

Sesuaikan `index.php` document root agar menunjuk ke source Laravel.

Contoh:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = '/home/USERNAME/simdis-universitas/storage/framework/maintenance.php')) {
    require $maintenance;
}

require '/home/USERNAME/simdis-universitas/vendor/autoload.php';

/** @var Application $app */
$app = require_once '/home/USERNAME/simdis-universitas/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

Ganti `USERNAME` sesuai akun hosting.

---

## 12. Optimize

```bash
php artisan optimize
```

atau:

```bash
/opt/alt/php83/usr/bin/php artisan optimize
```

---

# Metode B — Deployment Manual via Download ZIP + cPanel

Metode ini digunakan jika deployment tidak dilakukan melalui Git/GitHub.

Cocok untuk:

- Shared hosting
- cPanel
- Hosting tanpa Git
- Hosting dengan akses SSH terbatas
- Deployment menggunakan File Manager

---

## 1. Download Source

Download source repository dalam format ZIP.

Jika menggunakan GitHub:

```text
Repository → Code → Download ZIP
```

Ekstrak ZIP di komputer lokal.

---

## 2. Jangan Gunakan .env Local

File `.env` development tidak boleh langsung digunakan di production.

Gunakan:

```text
.env.example
```

sebagai template dan buat `.env` production secara terpisah.

---

## 3. Persiapkan Vendor di Komputer Lokal

Shared hosting tertentu memblokir fungsi seperti `proc_open`, sehingga Composer mungkin tidak dapat berjalan.

Di komputer lokal:

```bash
composer install --no-dev --optimize-autoloader
```

Pastikan terbentuk:

```text
vendor/
```

Folder tersebut harus ikut diupload.

---

## 4. Build Frontend di Lokal

Jalankan:

```bash
npm install
npm run build
```

Pastikan tersedia:

```text
public/build/
```

Folder tersebut harus ikut diupload.

---

## 5. Siapkan Paket Upload

Source yang akan diupload minimal berisi:

```text
app/
bootstrap/
config/
database/
lang/
public/
resources/
routes/
storage/
vendor/
artisan
composer.json
composer.lock
package.json
vite.config.js
```

Jangan sertakan:

```text
.env
node_modules/
.git/
```

jika tidak diperlukan pada hosting.

---

## 6. Upload Melalui cPanel

Buka:

```text
cPanel → File Manager
```

Buat folder aplikasi di luar `public_html`.

Contoh:

```text
/home/USERNAME/simdis-universitas
```

Upload ZIP project ke folder tersebut kemudian Extract.

Pastikan struktur akhirnya langsung:

```text
/home/USERNAME/simdis-universitas/app
/home/USERNAME/simdis-universitas/bootstrap
/home/USERNAME/simdis-universitas/vendor
/home/USERNAME/simdis-universitas/public
/home/USERNAME/simdis-universitas/artisan
```

Hindari struktur ganda seperti:

```text
/home/USERNAME/simdis-universitas/simdis-universitas-main/app
```

---

## 7. Buat Database melalui cPanel

Buka:

```text
cPanel → MySQL Databases
```

atau menu database yang disediakan hosting.

Buat:

1. Database.
2. Database User.
3. Password database yang kuat.
4. Hubungkan user ke database.
5. Berikan privilege yang diperlukan.

Catat:

```text
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

Jangan menaruh credential tersebut di README atau repository.

---

## 8. Buat .env Production

Pada:

```text
/home/USERNAME/simdis-universitas/
```

buat file:

```text
.env
```

Contoh:

```env
APP_NAME="SIMDIS Universitas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://simdis.domainkampus.ac.id

APP_LOCALE=id
APP_FALLBACK_LOCALE=id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=USER_DATABASE
DB_PASSWORD=PASSWORD_DATABASE
```

Tambahkan konfigurasi lain berdasarkan `.env.example`.

---

## 9. Pilih PHP

Melalui:

```text
cPanel → Select PHP Version
```

atau:

```text
MultiPHP Manager
```

pilih PHP 8.3 atau versi yang kompatibel.

Extension PHP yang umumnya dibutuhkan:

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- GD
- Intl
- Mbstring
- OpenSSL
- PDO
- PDO MySQL
- Tokenizer
- XML
- ZIP

---

## 10. Buat Domain/Subdomain

Buat domain atau subdomain.

Contoh:

```text
simdis.domainkampus.ac.id
```

Document root:

```text
/home/USERNAME/public_html/simdis.domainkampus.ac.id
```

---

## 11. Copy Public Files

Dari:

```text
/home/USERNAME/simdis-universitas/public/
```

copy isinya ke:

```text
/home/USERNAME/public_html/simdis.domainkampus.ac.id/
```

Document root hanya boleh mengekspos file public aplikasi.

Jangan copy seluruh Laravel project ke document root jika hosting memungkinkan struktur terpisah.

---

## 12. Edit index.php

Edit:

```text
/home/USERNAME/public_html/simdis.domainkampus.ac.id/index.php
```

agar menunjuk ke source Laravel.

Contoh:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = '/home/USERNAME/simdis-universitas/storage/framework/maintenance.php')) {
    require $maintenance;
}

require '/home/USERNAME/simdis-universitas/vendor/autoload.php';

/** @var Application $app */
$app = require_once '/home/USERNAME/simdis-universitas/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

Sesuaikan:

```text
USERNAME
simdis-universitas
```

dengan environment hosting.

---

## 13. Generate APP_KEY

Jika cPanel menyediakan Terminal:

```bash
cd /home/USERNAME/simdis-universitas
php artisan key:generate
```

Jika PHP default berbeda:

```bash
/opt/alt/php83/usr/bin/php artisan key:generate
```

Pastikan `.env` memiliki:

```env
APP_KEY=base64:...
```

---

## 14. Migration

Jika Terminal tersedia:

```bash
php artisan migrate --force
```

atau:

```bash
/opt/alt/php83/usr/bin/php artisan migrate --force
```

---

## 15. Seeder Production

Jalankan hanya data master:

```bash
php artisan db:seed --class=PositionSeeder --force
php artisan db:seed --class=RoleSeeder --force
php artisan db:seed --class=PermissionSeeder --force
php artisan db:seed --class=RolePermissionSeeder --force
```

Jangan menjalankan UserSeeder atau seeder data dummy pada production kecuali memang diperlukan.

---

## 16. Hosting Tanpa Terminal / SSH

Jika hosting sama sekali tidak menyediakan Terminal atau SSH, perintah Artisan seperti:

```text
php artisan migrate
php artisan db:seed
php artisan key:generate
```

tidak dapat dijalankan melalui File Manager saja.

Solusi yang direkomendasikan:

- gunakan fitur Terminal hosting jika tersedia;
- minta bantuan administrator hosting;
- atau gunakan database SQL awal yang telah disiapkan khusus untuk deployment.

Jangan membuat endpoint web sementara yang mengeksekusi Artisan karena dapat menimbulkan risiko keamanan.

---

## 17. Permission

Jika Terminal tersedia:

```bash
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Jika hanya menggunakan File Manager, sesuaikan permission melalui menu **Change Permissions**.

Pastikan web server dapat menulis ke:

```text
storage/
bootstrap/cache/
```

---

## 18. Private Storage

Pastikan folder berikut tersedia:

```text
storage/app/private/incoming_letters/
storage/app/private/outgoing_letters/
```

Jangan membuat symbolic link dari private storage ke public.

---

## 19. Optimize Production

Jika Terminal tersedia:

```bash
php artisan optimize
```

atau PHP khusus:

```bash
/opt/alt/php83/usr/bin/php artisan optimize
```

---

## 20. Aktifkan HTTPS

Gunakan SSL dari hosting.

Pastikan aplikasi menggunakan:

```env
APP_URL=https://simdis.domainkampus.ac.id
```

dan:

```env
APP_DEBUG=false
```

pada production.

---

# Membuat Administrator Pertama

Setelah database dan role tersedia, buat akun Administrator pertama menggunakan metode administrasi yang sesuai dengan environment deployment.

Pastikan:

- akun aktif;
- memiliki role `Administrator`;
- password kuat;
- credential tidak disimpan di repository.

Jangan menuliskan username/password production pada README.

---

# Update Production Menggunakan Git

Sebelum update, lakukan backup.

Kemudian:

```bash
cd /home/USERNAME/simdis-universitas

git pull --ff-only origin main

php artisan migrate --force

php artisan optimize
```

Jika PHP khusus diperlukan:

```bash
/opt/alt/php83/usr/bin/php artisan migrate --force
/opt/alt/php83/usr/bin/php artisan optimize
```

---

# Update Production Tanpa Git

Jika instalasi dilakukan menggunakan ZIP/File Manager:

## 1. Backup

Sebelum update, backup:

- Database
- `.env`
- `storage/app/private`
- Source code versi yang sedang berjalan

---

## 2. Download Source Terbaru

Download versi terbaru repository dan ekstrak di komputer.

---

## 3. Dependency

Jika `composer.lock` berubah:

```bash
composer install --no-dev --optimize-autoloader
```

Upload `vendor/` terbaru.

---

## 4. Frontend

Jika frontend berubah:

```bash
npm install
npm run build
```

Upload:

```text
public/build/
```

ke source dan document root production.

---

## 5. Upload Source

Upload file aplikasi terbaru.

Jangan menimpa tanpa pemeriksaan:

```text
.env
storage/app/private/
```

Untuk document root, jangan menimpa `index.php` production yang telah disesuaikan kecuali memang diperlukan.

---

## 6. Migration

Jika release memiliki migration baru:

```bash
php artisan migrate --force
```

---

## 7. Optimize

```bash
php artisan optimize
```

---

## 8. Smoke Test

Uji kembali fungsi utama aplikasi setelah update.

---

# Backup Production

Backup minimal harus mencakup empat komponen:

```text
Database
.env
storage/app/private
Source/version aplikasi
```

Backup sangat disarankan sebelum setiap update production.

Contoh database:

```bash
mariadb-dump -u DATABASE_USER -p DATABASE_NAME > simdis-backup.sql
```

Password sebaiknya dimasukkan melalui prompt dan tidak ditulis langsung pada command.

Backup private storage:

```bash
tar -czf simdis-private.tar.gz storage/app/private
```

Backup `.env` harus disimpan di lokasi yang tidak dapat diakses melalui web.

Contoh permission:

```bash
chmod 600 .env.production.backup
```

---

# Production Checklist

Sebelum aplikasi dinyatakan siap digunakan, periksa:

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` menggunakan domain production
- [ ] HTTPS aktif
- [ ] APP_KEY tersedia
- [ ] Database terhubung
- [ ] Semua migration berhasil
- [ ] Role tersedia
- [ ] Permission tersedia
- [ ] RolePermissionSeeder berhasil
- [ ] Administrator pertama tersedia
- [ ] `storage` writable
- [ ] `bootstrap/cache` writable
- [ ] `public/build` tersedia
- [ ] Private storage tersedia
- [ ] Dokumen private tidak dapat diakses langsung
- [ ] Login berhasil
- [ ] Logout berhasil
- [ ] Surat Masuk berhasil
- [ ] Surat Keluar berhasil
- [ ] Disposisi berhasil
- [ ] Laporan PDF berhasil
- [ ] Laporan Excel berhasil

---

# Smoke Test

Setelah deployment, lakukan pengujian:

## Authentication

- Login
- Logout
- User nonaktif tidak dapat menggunakan sistem

## Role & Permission

Uji minimal:

- Administrator
- Admin Persuratan
- Rektor
- Staf

Pastikan menu/tindakan sensitif tidak dapat digunakan tanpa permission.

## Surat Masuk

- Tambah data
- Edit
- Detail
- Upload PDF
- Buka PDF
- Hapus sesuai permission

## Surat Keluar

- Tambah data
- Edit
- Detail
- Upload PDF
- Buka PDF
- Hapus sesuai permission

## Disposisi

- Buat disposisi
- Pilih penerima
- Lihat disposisi
- Proses
- Selesaikan

## Laporan

- Tampilkan laporan
- Export PDF
- Export Excel

## Security

Coba akses langsung file:

```text
/storage/incoming_letters/FILE.pdf
/storage/outgoing_letters/FILE.pdf
```

Akses langsung harus ditolak.

---

# Shared Hosting Notes

Beberapa shared hosting menonaktifkan fungsi PHP seperti:

```text
proc_open
shell_exec
exec
system
```

Jika `proc_open` tidak tersedia, Composer atau command tertentu yang menggunakan Symfony Process dapat gagal.

Hal tersebut tidak selalu berarti aplikasi web tidak dapat berjalan.

Jika Composer tidak dapat dijalankan di server:

```text
Composer lokal
     ↓
vendor/
     ↓
Upload server
```

Jika Node.js/NPM tidak tersedia:

```text
npm install
     ↓
npm run build
     ↓
public/build/
     ↓
Upload server
```

Dengan pendekatan ini aplikasi tetap dapat dideploy pada banyak environment shared hosting.

---

# Troubleshooting

## 500 Internal Server Error

Periksa log:

```text
storage/logs/laravel.log
```

Jika Terminal tersedia:

```bash
tail -50 storage/logs/laravel.log
```

Periksa juga:

- `.env`
- APP_KEY
- database
- permission storage
- PHP version
- PHP extensions
- path `index.php`
- folder `vendor`

---

## CSS / JavaScript Tidak Muncul

Pastikan:

```text
public/build/manifest.json
```

tersedia.

Pastikan juga:

```text
public/build/assets/
```

berisi file hasil Vite.

Jika perlu:

```bash
npm run build
```

kemudian upload `public/build`.

---

## Database Connection Failed

Periksa:

```env
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

Pastikan database user telah diberikan privilege terhadap database.

---

## Composer Gagal Karena proc_open

Jika muncul error seperti:

```text
The Process class relies on proc_open
```

jalankan Composer di komputer lokal:

```bash
composer install --no-dev --optimize-autoloader
```

kemudian upload folder:

```text
vendor/
```

---

## File PDF Tidak Bisa Dibuka

Periksa:

```text
storage/app/private/incoming_letters
storage/app/private/outgoing_letters
```

Pastikan:

- file tersedia;
- permission benar;
- route file aktif;
- pengguna login;
- pengguna memiliki permission yang sesuai.

Jangan memindahkan file ke public hanya untuk mengatasi error akses.

---

# Security Guidelines

Jangan pernah commit:

```text
.env
.env.production
database credentials
APP_KEY
SSH private key
deployment key
production backup
private uploaded documents
```

Pastikan `.gitignore` melindungi file sensitif.

Contoh:

```gitignore
.env
.env.backup
.env.production

/storage/app/private/*
!/storage/app/private/.gitignore

/public/storage
/vendor
/node_modules
```

---

# Hal yang Tidak Boleh Dilakukan

Jangan:

- Mengaktifkan `APP_DEBUG=true` di production.
- Menyimpan password database di repository.
- Menyimpan APP_KEY di README.
- Menaruh SSH private key di repository.
- Menyimpan dokumen surat pada public storage.
- Menggunakan `chmod -R 777` tanpa alasan yang benar.
- Menjalankan seeder dummy di database production.
- Membuat endpoint publik untuk menjalankan Artisan.
- Menghapus `storage/app/private` saat update.
- Menimpa `.env` production dengan `.env` lokal.
- Menghapus database sebelum memiliki backup.

---

# Development Workflow

Workflow pengembangan yang direkomendasikan:

```text
Development Local
       ↓
Testing
       ↓
Commit
       ↓
Push Repository
       ↓
Backup Production
       ↓
Deploy
       ↓
Migration
       ↓
Optimize
       ↓
Smoke Test
```

Untuk deployment manual:

```text
Development Local
       ↓
Testing
       ↓
composer install --no-dev
       ↓
npm run build
       ↓
Download/Prepare Release
       ↓
Backup Production
       ↓
Upload via cPanel
       ↓
Migration
       ↓
Optimize
       ↓
Smoke Test
```

---

# Versioning

## v1.0

**Status: Production Ready / Pilot Release**

Fitur utama:

- Authentication
- User Management
- Position Management
- Role & Permission
- Surat Masuk
- Surat Keluar
- Private PDF Storage
- Disposisi
- Multi-recipient Disposition
- Disposition Processing
- Reports
- PDF Export
- Excel Export

Pengembangan versi berikutnya akan ditentukan berdasarkan hasil evaluasi dan masukan pengguna.

---

# Roadmap

Pengembangan lanjutan tidak ditetapkan secara permanen pada versi 1.0.

Prioritas versi berikutnya akan ditentukan berdasarkan:

- feedback pengguna;
- kebutuhan operasional universitas;
- hasil pilot implementation;
- bug report;
- perubahan workflow administrasi.

Hal ini dilakukan agar pengembangan tetap mengikuti kebutuhan pengguna nyata dan tidak menambah kompleksitas yang tidak diperlukan.

---

# Contributing

Kontribusi pengembangan sangat terbuka, terutama untuk mahasiswa, dosen, dan developer yang ingin mengembangkan SIMDIS lebih lanjut.

Alur kontribusi yang direkomendasikan:

1. Fork repository.
2. Buat branch fitur atau perbaikan.
3. Lakukan perubahan dan testing.
4. Commit perubahan.
5. Push branch.
6. Buat Pull Request.

Contoh:

```bash
git checkout -b feature/nama-fitur
git add .
git commit -m "feat: deskripsi perubahan"
git push origin feature/nama-fitur
```

Pastikan kontribusi tidak menyertakan:

- `.env`
- credential database
- APP_KEY
- private key
- dokumen surat production
- backup production
- data pribadi pengguna

---

# License

Project ini menggunakan **MIT License**.

SIMDIS Universitas dapat digunakan, dipelajari, dimodifikasi, dan dikembangkan lebih lanjut, termasuk untuk kegiatan pembelajaran dan pengembangan oleh mahasiswa.

Lihat file [`LICENSE`](LICENSE) untuk ketentuan lengkap.

---

# SIMDIS Universitas

**Sistem Informasi Manajemen Disposisi Surat**

Dikembangkan untuk mendukung digitalisasi administrasi persuratan, disposisi, pengarsipan dokumen, dan pelaporan di lingkungan universitas.

**Version 1.0 — Production Ready / Pilot Release**