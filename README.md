# Desa Wisata Serangan

Aplikasi web untuk manajemen Desa Wisata Serangan dengan fitur reservasi paket wisata, manajemen penginapan, dan dashboard admin.

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)
- XAMPP atau server lokal lainnya

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd desa-wisata
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Database
```bash
# Copy file environment
cp .env.example .env

# Generate APP_KEY
php artisan key:generate

# Setup database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=desa_wisata
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Jalankan Migrasi
```bash
php artisan migrate
php artisan db:seed --class=DummyUsersSeeder
```

### 5. Generate Assets
```bash
npm run dev
# atau untuk production
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gmail.com | 12345 |
| Bendahara | bendahara@gmail.com | 12345 |
| Pemilik | pemilik@gmail.com | 12345 |

## 📁 Struktur Folder

```
desa-wisata/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── bendahara/
│       ├── be/ (backend)
│       ├── fe/ (frontend)
│       ├── owner/
│       └── profile/
├── public/
│   ├── be/ (backend assets)
│   ├── fe/ (frontend assets)
│   └── storage/
├── routes/
└── config/
```

## 🎯 Fitur Utama

### Frontend (Pelanggan)
- ✅ Lihat paket wisata dan penginapan
- ✅ Melihat berita dan promosi/diskon
- ✅ Reservasi paket wisata
- ✅ Upload bukti transfer pembayaran
- ✅ Lihat riwayat reservasi
- ✅ Unduh nota reservasi (PDF)
- ✅ Kelola profil pelanggan

### Backend Admin
- ✅ Dashboard overview
- ✅ Kelola berita dan kategori
- ✅ Kelola user/karyawan

### Backend Bendahara
- ✅ Dashboard bendahara
- ✅ Kelola paket wisata
- ✅ Kelola penginapan (homestay)
- ✅ Kelola objek wisata
- ✅ Konfirmasi pembayaran reservasi
- ✅ Kelola diskon
- ✅ Kelola metode pembayaran

### Backend Owner/Pemilik
- ✅ Dashboard pemilik
- ✅ Lihat statistik pemasukan
- ✅ Lihat pelanggan teraktif
- ✅ Lihat reservasi terbaru
- ✅ Unduh laporan reservasi (PDF)

## 🔐 Roles & Permissions

| Role | Akses |
|------|-------|
| **Admin** | User management, News management |
| **Bendahara** | Homestay, Objek wisata, Paket wisata, Konfirmasi reservasi, Diskon, Metode pembayaran |
| **Pemilik** | Dashboard, Laporan, Statistik |
| **Pelanggan** | Reservasi, Lihat riwayat, Edit profil |

## 📦 Model & Database

### Users
```php
- id
- email
- password
- level (admin, bendahara, pemilik, pelanggan)
- aktif
```

### Pelanggan
```php
- id
- id_user
- nama_lengkap
- no_telepon
- alamat
- foto
```

### Reservasi
```php
- id
- id_pelanggan
- id_paket
- id_diskon
- id_jenis_pembayaran
- tgl_reservasi_wisata
- tgl_selesai_reservasi
- jumlah_peserta
- total_bayar
- status_reservasi (Dipesan, Dibayar, Selesai, Dibatalkan)
- bukti_tf
```

## 🎨 Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL
- **Styling**: SCSS, Tailwind CSS
- **Charts**: Chart.js
- **PDF**: Laravel PDF
- **Icons**: Font Awesome, Flaticon
- **Animation**: AOS (Animate On Scroll)

## 🔗 Routes Utama

### Frontend
```
GET  /                      - Home
GET  /register              - Form registrasi pelanggan
GET  /loginn                - Login pelanggan
POST /loginn                - Proses login pelanggan
GET  /penginapan            - Daftar penginapan
GET  /wisata                - Daftar wisata
GET  /contact               - Halaman kontak
GET  /berita                - Daftar berita
GET  /reservasi/{id}/create - Form reservasi
POST /reservasi             - Proses reservasi
GET  /reservasiriwayat      - Riwayat reservasi
GET  /profile/edit          - Edit profil pelanggan
```

### Backend Admin
```
GET  /admin                 - Dashboard admin
GET  /userm                 - User management
GET  /news                  - News management
```

### Backend Bendahara
```
GET  /bendahara             - Dashboard bendahara
GET  /homestay              - Kelola homestay
GET  /obwi                  - Kelola objek wisata
GET  /pakwis                - Kelola paket wisata
GET  /konfir                - Konfirmasi reservasi
GET  /diskon                - Kelola diskon
GET  /jenispembayaran       - Kelola metode pembayaran
```

### Backend Owner
```
GET  /owner                 - Dashboard owner
GET  /owner/reservasi/pdf   - Download laporan PDF
```

## 📝 Catatan Penting

### Penyimpanan File
- Foto profile pelanggan: `storage/app/public/pelanggan/`
- Foto berita: `storage/app/public/berita/`
- Foto paket wisata: `storage/app/public/paket-wisata/`
- Foto objek wisata: `storage/app/public/obyek-wisata/`
- Bukti transfer: `storage/app/public/bukti_tf/`

### Link Storage
```bash
php artisan storage:link
```

### Hitung Total Reservasi
Sistem otomatis menghitung:
- Subtotal = Harga Paket × Jumlah Peserta
- Nilai Diskon = Subtotal × (Persentase / 100)
- Total Bayar = Subtotal - Nilai Diskon

## 🐛 Troubleshooting

### Storage tidak bisa diakses
```bash
php artisan storage:link
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Database error
```bash
php artisan migrate:refresh --seed
```

### Assets tidak ter-compile
```bash
npm run dev
php artisan optimize:clear
```

## 📄 License

Proyek ini dilisensikan di bawah MIT License.

## 👥 Tim Pengembang

- **Backend**: Laravel Framework
- **Frontend**: Bootstrap & Custom CSS
- **Database**: MySQL

## 📞 Kontak & Support

Untuk informasi lebih lanjut tentang Desa Wisata Serangan:
- **Email**: info@dwisataserangan.com
- **Lokasi**: Jl. Pulau Serangan, Serangan, Denpasar Sel., Bali
- **Maps**: [Google Maps Link](https://maps.app.goo.gl/5srETQNRGAQGjKZC6)

---

**Selamat datang di Desa Wisata Serangan! Nikmati pengalaman wisata yang tak terlupakan.** 🌴🏝️