# Auto-Delete Unverified Users

## 🔄 Sistem Otomatis

Sistem akan otomatis menghapus akun pengguna yang:
- Belum diverifikasi (`is_verified = false`)
- Belum disetujui (`is_approved = false`) 
- Terdaftar lebih dari **3 hari** yang lalu

## 📋 Cara Kerja

1. **Command**: `php artisan users:delete-unverified`
   - Bisa dijalankan manual kapan saja
   - Akan mencari user yang memenuhi kriteria di atas
   - Menghapus biodata dan file foto (KTP, KK, Profile)
   - Menghapus user dari database

2. **Scheduler**: Berjalan otomatis setiap hari tengah malam (00:00)
   - Sudah dikonfigurasi di `routes/console.php`
   - Menggunakan Laravel Task Scheduling

## 🚀 Menjalankan Scheduler

### Development (Local)
Jalankan command ini di terminal (biarkan terus berjalan):
```bash
php artisan schedule:work
```

### Production (Server)
Tambahkan cron job di server:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 🧪 Testing Manual

Untuk test manual, jalankan:
```bash
php artisan users:delete-unverified
```

Output akan menampilkan:
- Nama dan NIK user yang dihapus
- Total jumlah user yang dihapus
- "No unverified users found to delete." jika tidak ada yang perlu dihapus

## 📁 File yang Terlibat

1. `app/Console/Commands/DeleteUnverifiedUsers.php` - Command class
2. `routes/console.php` - Scheduler configuration
