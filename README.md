# 🌏 Sistem Informasi Geografis (WebGIS) - Desa Tegalsambi

![Laravel Version](https://img.shields.io/badge/Laravel-v12.0-red?style=flat&logo=laravel)
![PHP Version](https://img.shields.io/badge/PHP-%5E8.2-blue?style=flat&logo=php)
![Tailwind](https://img.shields.io/badge/TailwindCSS-v4.0-38bdf8?style=flat&logo=tailwindcss)
![License](https://img.shields.io/badge/license-MIT-green)

Aplikasi WebGIS interaktif yang dirancang untuk memetakan potensi wilayah, data demografi, dan fasilitas umum di Desa Tegalsambi, Kabupaten Jepara. Platform ini mengintegrasikan data spasial (peta) dengan database administratif untuk mendukung pengambilan keputusan pemerintah desa yang lebih akurat.

![Banner Preview](https://via.placeholder.com/1000x400?text=WebGIS+Desa+Tegalsambi+Dashboard+Preview)

---

## 📑 Daftar Isi

- [Fitur Unggulan](#-fitur-unggulan)
- [Teknologi](#-teknologi)
- [Struktur Project](#-struktur-project)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Konfigurasi](#-instalasi--konfigurasi)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [Deployment](#-deployment)
- [Troubleshooting](#-troubleshooting)
- [Lisensi & Kredit](#-lisensi--kredit)

---

## 🚀 Fitur Unggulan

### 🗺️ Peta Interaktif (GIS)
*   **Multi-Layer Map**: Mendukung berbagai basemap (OpenStreetMap, Satellite, Terrain).
*   **Visualisasi GeoJSON**:
    *   Layer Batas RW/RT dengan pewarnaan dinamis.
    *   Jaringan Jalan (Jalan Utama & Jalan Kecil).
    *   Sebaran Lokasi Penting (POI) seperti Masjid, Sekolah, dan UMKM.
    *   Heatmap Kepadatan Penduduk.
*   **Interactive Popups**: Menampilkan detail informasi saat objek peta diklik.

### 📊 Dashboard Administrator
*   **Statistik Real-time**: Ringkasan jumlah penduduk, total wilayah, dan fasilitas desa.
*   **Manajemen Wilayah (CRUD)**: Kelola data RW/RT, jumlah Kepala Keluarga (KK), dan populasi (L/P).
*   **Manajemen POI**: Tambah, ubah, dan hapus lokasi penting beserta koordinatnya.
*   **Manajemen Akun**: Pengaturan profil admin dan keamanan.

### 📝 Laporan & Export
*   **Cetak PDF**: Generasi laporan otomatis untuk data wilayah dan kependudukan.
*   **Rekapitulasi Data**: Tabel data yang mudah dibaca dan difilter.

---

## 🛠️ Teknologi

Project ini dibangun menggunakan *monolithic architecture* yang modern dan handal:

| Kategori | Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Framework** | [Laravel 12](https://laravel.com) | Framework PHP untuk backend robust dan aman. |
| **Database** | [SQLite](https://sqlite.org) / MySQL | Penyimpanan data relasional ringan. |
| **Frontend** | [Blade](https://laravel.com/docs/blade) & [Alpine.js](https://alpinejs.dev) | Templating engine denga interaktivitas ringan. |
| **Styling** | [Tailwind CSS](https://tailwindcss.com) | Utility-first CSS framework untuk desain modern. |
| **Mapping** | [Leaflet.js](https://leafletjs.com) | Library open-source untuk peta interaktif. |
| **PDF** | [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf) | Engine pembuat dokumen PDF. |

---

## ⚙️ Konfigurasi Peta

Pusat peta (Center Coordinates) dan level zoom default dapat diatur melalui file controller atau javascript terkait.
*   **Default Koordinat**: `-6.6xxxx, 110.6xxxx` (Desa Tegalsambi)
*   **File Konfigurasi**: `resources/js/map.js` atau `app/Http/Controllers/MapController.php` (sesuaikan dengan implementasi).

---

## 📂 Struktur Project

Berikut adalah gambaran struktur direktori penting dalam aplikasi:

```bash
webgis-tegalsambi/
├── app/
│   ├── Http/Controllers/     # Logika aplikasi (Admin, Map, Export)
│   └── Models/               # Representasi tabel database
├── database/
│   ├── migrations/           # Definisi struktur tabel
│   ├── seeders/              # Data awal (Admin, Data Dummy)
│   └── database.sqlite       # File database (Created on setup)
├── public/
│   ├── geojson/              # Aset peta spasial (.geojson)
│   └── icons/                # Ikon marker peta
├── resources/
│   ├── views/                # Tampilan HTML (Blade)
│   │   ├── admin/            # Halaman dashboard admin
│   │   └── layouts/          # Template utama
│   └── css/                  # Entry point CSS
├── routes/
│   └── web.php               # Routing URL aplikasi
└── .env                      # File konfigurasi sensitif
```

---

## 📋 Persyaratan Sistem

Sebelum melakukan instalasi, pastikan lingkungan pengembangan Anda memenuhi syarat berikut:

*   **PHP** >= 8.2 (Pastikan ekstensi `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `pdo`, `tokenizer`, `xml`, dan `sqlite3` aktif).
*   **Composer** (Terbaru).
*   **Node.js** >= 18.x & **NPM**.
*   **Web Browser** Modern (Chrome, Firefox, Safari, Edge). **Internet Explorer tidak didukung.**

---

## ⚙️ Instalasi & Konfigurasi

Ikuti panduan ini untuk menjalankan aplikasi di komputer lokal (Localhost).

### 1. Dapatkan Kode Sumber
```bash
git clone https://github.com/username/webgis-tegalsambi.git
cd webgis-tegalsambi
```

### 2. Install Dependencies
Install library PHP (Backend) dan JavaScript (Frontend):
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` ke `.env`:
```bash
# Windows
copy .env.example .env

# Mac/Linux
cp .env.example .env
```

### 4. Setup Database
Secara default, aplikasi menggunakan **SQLite** yang tidak memerlukan server database terpisah (seperti MySQL/XAMPP).

**Windows (PowerShell):**
```powershell
New-Item database/database.sqlite -ItemType File
php artisan migrate:fresh --seed
php artisan key:generate
```

**Mac/Linux:**
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan key:generate
```

> **Catatan**: Perintah `--seed` sangat penting karena akan membuat akun **Admin Default** dan mengisi data sampel ke database.

### 5. Jalankan Aplikasi
Anda perlu membuka **dua terminal** terpisah agar aplikasi berjalan lancar (Hot Reload Support).

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

**Terminal 2 (Vite Builder):**
```bash
npm run dev
```

Akses aplikasi di browser: `http://127.0.0.1:8000`

---

## 📖 Panduan Penggunaan

### Akses Peta (Publik)
Halaman depan (`/`) menampilkan peta interaktif yang dapat diakses oleh siapa saja. Pengunjung dapat:
1.  Melihat sebaran wilayah RW.
2.  Mengaktifkan/menonaktifkan layer (misal: Sembunyikan jalan).
3.  Klik pada ikon untuk melihat detail lokasi.

### Akses Dashboard Admin
Untuk mengelola data, Anda harus login terlebih dahulu.
*   **URL Login**: `http://127.0.0.1:8000/login`
*   **Email Default**: `admin@tegalsambi.id`
*   **Password Default**: `password`

> ⚠️ **PENTING**: Segera ubah password setelah login pertama kali melalui menu **Profile**.

### 🔄 Alur Data Spasial
Data visual peta dikelola melalui file **GeoJSON** di folder `public/geojson/`. Jika Anda ingin mengubah peta (misal: batas wilayah bergeser), Anda perlu:
1.  Mengedit file GeoJSON menggunakan software GIS (QGIS / ArcGIS).
2.  Menyimpan/menimpa file yang ada di folder `public/geojson/`.
3.  Data atribut (jumlah penduduk) diupdate melalui **Dashboard Admin**.

---

## ☁️ Deployment (Opsional)

Jika ingin mengonlinekan aplikasi ini ke hosting (Shared Hosting / VPS):

1.  Upload semua file ke server.
2.  Atur Document Root domain ke folder `/public`.
3.  Sesuaikan `.env`:
    *   `APP_ENV=production`
    *   `APP_DEBUG=false`
    *   Konfigurasi Database (MySQL disarankan untuk production).
4.  Jalankan `composer install --optimize-autoloader --no-dev`.
5.  Jalankan `php artisan config:cache` dan `php artisan route:cache`.
6.  Jalankan `php artisan migrate --force`.

---

## 🧪 Pengujian (Testing)

Aplikasi ini mendukung pengujian otomatis menggunakan **PHPUnit** untuk memastikan integritas dan stabilitas fitur.

### 1. Menjalankan Seluruh Test
Gunakan perintah berikut untuk memeriksa semua test case:
```bash
php artisan test
```

### 2. Menjalankan Test Spesifik
Untuk menjalankan pengujian pada fitur tertentu saja:
```bash
php artisan test tests/Feature/NamaTest.php
```

### 3. Membuat Test Case Baru
Jika Anda ingin menambahkan skenario pengujian baru:
```bash
php artisan make:test NamaFiturTest
```

### 4. Konfigurasi Environment Testing
Secara default, Laravel menggunakan konfigurasi yang ada di `phpunit.xml`. Disarankan untuk menggunakan database in-memory (SQLite) agar proses testing lebih cepat dan tidak mengganggu data asli.
Pastikan konfigurasi `phpunit.xml` mencakup:
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

---

## ❓ Troubleshooting

**Q: Tampilan web berantakan / CSS hilang?**
A: Pastikan `npm run dev` berjalan (di local) atau Anda sudah menjalankan `npm run build` (untuk production) agar file CSS terbentuk.

**Q: Database error "No such table"?**
A: Pastikan file `database/database.sqlite` ada dan Anda sudah menjalankan `php artisan migrate`.

**Q: Peta tidak tampil?**
A: Periksa koneksi internet Anda (diperlukan untuk memuat basemap OSM). Cek tab "Console" di browser (F12) untuk melihat apakah ada error memuat file GeoJSON.

---

## 📄 Lisensi & Kredit

**Dibuat oleh:**
Mahasiswa Semester 5 - Sistem Informasi Geografis (UAS)
*   **Nama**: Muhammad Ashab Ibnu Abdul Aziz
*   **NIM**: 231240001399

**Kredit Pihak Ketiga:**
*   Icons by [FontAwesome](https://fontawesome.com)
*   Maps by [OpenStreetMap](https://openstreetmap.org)
*   Leaflet JS

**Lisensi:**
[MIT License](https://opensource.org/licenses/MIT) - Bebas digunakan dan dimodifikasi untuk keperluan pendidikan dan pengembangan.
