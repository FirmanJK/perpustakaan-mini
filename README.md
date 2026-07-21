# 📚 MSJ Perpustakaan - Sistem Manajemen Perpustakaan Mini

Aplikasi web untuk manajemen perpustakaan yang dibangun menggunakan Laravel Framework. Sistem ini menyediakan fitur-fitur lengkap untuk mengelola buku, anggota, dan transaksi peminjaman buku dengan sistem stock management otomatis.

![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Laravel Version](https://img.shields.io/badge/Laravel-10.x-red)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 🚀 Fitur Utama

### 👥 Multi-Role System

- **Pustakawan (Admin)**: Akses penuh untuk mengelola semua data
- **Pengunjung (Guest)**: Akses terbatas untuk melihat data buku

### 📊 Dashboard Interaktif

- **Admin Dashboard**:
    - 4 Info boxes (Total Buku, Total Anggota, Buku Dipinjam, Buku Dikembalikan)
    - Bar Chart: Statistik peminjaman per bulan
    - Doughnut Chart: Status peminjaman
    - Tabel buku populer
- **Guest Dashboard**:
    - Info box total buku
    - Line Chart: Trend peminjaman
    - Tabel buku populer

### 📖 Master Data

1. **Master Buku**
    - Judul, Penulis, Penerbit
    - ISBN, Tahun Terbit
    - Kategori, Stok
    - Auto-update stock saat transaksi

2. **Master Anggota**
    - Nomor Anggota (Auto-generate)
    - Nama Lengkap
    - Email, Nomor Telepon
    - Alamat

### 🔄 Transaksi Peminjaman

- **Auto-Generate Nomor Transaksi** (Format: TRX001, TRX002, dst)
- **Stock Management Otomatis**:
    - Stok berkurang saat buku dipinjam
    - Stok bertambah saat buku dikembalikan
    - Proteksi stok tidak boleh minus
- Field:
    - No. Transaksi (auto)
    - Tanggal Peminjaman
    - Tanggal Rencana Kembali
    - Tanggal Aktual Kembali
    - Member (dropdown)
    - Buku (dropdown - hanya tampil buku dengan stok > 0)
    - Status (Dipinjam/Dikembalikan)
    - Catatan

### 📈 Laporan

- **Laporan Peminjaman**
    - Filter by Status
    - Filter by Tanggal Peminjaman
    - Export Excel/PDF

---

## 🛠️ Teknologi & Requirements

### Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk assets)
- Laravel 10.x

### Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Template, Bootstrap 5, AdminLTE
- **Database**: MySQL
- **Chart**: Chart.js
- **DataTables**: jQuery DataTables
- **Icons**: Font Awesome

---

## 📥 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/msj-perpustakaan.git
cd msj-perpustakaan
```

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpus
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder

```bash
# Buat database terlebih dahulu
mysql -u root -e "CREATE DATABASE db_perpus"

# Jalankan migrasi
php artisan migrate

# Jalankan seeder
php artisan db:seed --class=role_perpustakaan
php artisan db:seed --class=user_perpustakaan
php artisan db:seed --class=menu_perpustakaan
php artisan db:seed --class=tabel_mst_books
php artisan db:seed --class=tabel_mst_members
php artisan db:seed --class=tabel_trs_loans
php artisan db:seed --class=data_perpustakaan
php artisan db:seed --class=report_perpustakaan
php artisan db:seed --class=sysid_trslnx

# Atau jalankan semua seeder sekaligus
php artisan db:seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 👤 Default User Credentials

### Admin (Pustakawan)

- **Username**: `adminlib`
- **Password**: `MSJframework123!`
- **Role**: Pustakawan (Akses penuh)

### Guest (Pengunjung)

- **Username**: `guestlib`
- **Password**: `MSJframework123!`
- **Role**: Pengunjung (Read-only)

---

## 📂 Struktur Direktori

```
msj-perpustakaan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── MasterController.php
│   │   │   └── TrslnxController.php    # Custom controller untuk transaksi
│   │   └── Middleware/
│   ├── Helpers/
│   │   ├── Format_Helper.php           # Helper untuk auto-generate ID
│   │   └── Function_Helper.php
│   └── Models/
├── database/
│   ├── migrations/
│   │   ├── 2025_01_14_000001_mst_books.php
│   │   ├── 2025_01_14_000002_mst_members.php
│   │   └── 2025_01_14_000003_trs_loans.php
│   └── seeders/
│       ├── role_perpustakaan.php
│       ├── user_perpustakaan.php
│       ├── menu_perpustakaan.php
│       ├── tabel_mst_books.php
│       ├── tabel_mst_members.php
│       ├── tabel_trs_loans.php
│       ├── data_perpustakaan.php
│       ├── report_perpustakaan.php
│       ├── sysid_trslnx.php
│       └── fix_counter_trslnx.php      # Seeder untuk fix counter
├── resources/
│   └── views/
│       ├── pages/
│       │   └── dashboard/
│       │       ├── admin.blade.php
│       │       └── guest.blade.php
│       ├── master/auto/                # Generic views
│       └── trslnx/auto/                # Custom views untuk transaksi
└── public/
```

---

## 🔧 Fitur Teknis

### Auto-Generate Nomor Transaksi

Sistem menggunakan `sys_id` dan `sys_counter` untuk generate nomor otomatis:

- Format: **TRX** + counter 3 digit
- Contoh: TRX001, TRX002, TRX003, dst
- Counter otomatis increment setiap transaksi baru

### Stock Management Logic

```php
// Saat create transaksi → stok -1
if ($attributes['book_id']) {
    DB::table('mst_books')
        ->where('id', $book_id)
        ->decrement('stok', 1);
}

// Saat update status Dipinjam → Dikembalikan → stok +1
if ($status_baru == 'Dikembalikan' && $status_lama == 'Dipinjam') {
    DB::table('mst_books')
        ->where('id', $book_id)
        ->increment('stok', 1);
}
```

### Custom Controller Pattern

Untuk menu yang membutuhkan logic khusus tanpa merusak `MasterController`:

1. Buat controller baru yang extends `MasterController`
2. Override method yang diperlukan (`add`, `store`, `update`)
3. Update `sys_dmenu.layout` ke nama controller baru
4. Copy views dari `master/auto/` ke folder baru

---

## 🐛 Troubleshooting

### Counter Tidak Sinkron

Jika nomor transaksi duplicate, jalankan fix counter:

```bash
php artisan db:seed --class=fix_counter_trslnx
```

### Menu Tidak Muncul

Pastikan seeder sudah dijalankan:

```bash
php artisan db:seed --class=menu_perpustakaan
```

### Data Tidak Tampil

Jalankan seeder data:

```bash
php artisan db:seed --class=data_perpustakaan
```

### Permission Error (Storage)

```bash
chmod -R 775 storage bootstrap/cache
```

### Autoload Error

```bash
composer dump-autoload
```

---

## 📝 Database Schema

### mst_books (Master Buku)

```sql
id (PK), judul, penulis, penerbit, isbn, tahun_terbit,
kategori, stok, isactive, created_at, updated_at,
user_create, user_update
```

### mst_members (Master Anggota)

```sql
id (PK), nomor_anggota, nama_lengkap, email, nomor_telepon,
alamat, isactive, created_at, updated_at, user_create, user_update
```

### trs_loans (Transaksi Peminjaman)

```sql
id (PK), no_transaksi (UNIQUE), tgl_pinjam, tgl_kembali,
tgl_dikembalikan, member_id (FK), book_id (FK), status,
catatan, isactive, created_at, updated_at, user_create, user_update
```

---

## 🤝 Contributing

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 License

Project ini menggunakan [MIT License](LICENSE).

---

## 👨‍💻 Author

**MSJ Framework Team**

---

## 📞 Support

Jika ada pertanyaan atau butuh bantuan:

- 📧 Email: support@msjframework.com
- 🐛 Issues: [GitHub Issues](https://github.com/username/msj-perpustakaan/issues)

---

## 🙏 Acknowledgments

- Laravel Framework
- AdminLTE Theme
- Chart.js
- DataTables
- Bootstrap
- Font Awesome

---

## 🔄 Changelog

### Version 1.0.0 (2025-01-14)

- ✨ Initial release
- ✨ Multi-role system (Pustakawan & Pengunjung)
- ✨ Dashboard dengan chart interaktif
- ✨ Master Buku, Anggota, Transaksi
- ✨ Auto-generate nomor transaksi
- ✨ Stock management otomatis
- ✨ Laporan peminjaman dengan filter

---

**Made with Firman using Laravel Framework**
