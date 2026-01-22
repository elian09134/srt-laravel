# Mengatasi Error 403 Forbidden pada Laravel

Error "403 Forbidden" yang Anda alami biasanya terjadi karena konfigurasi Web Server (Apache/Nginx) tidak diarahkan dengan benar ke folder yang seharusnya.

## Penyebab Utama
Dalam framework Laravel, **titik masuk (entry point)** aplikasi berada di folder `public/`, bukan di folder root project.
Saat ini, server Anda kemungkinan besar diarahkan ke folder root project (`/path/to/srt-laravel`), di mana tidak ada file `index.php` atau `index.html` yang bisa dieksekusi secara langsung. Karena fitur "Directory Listing" dimatikan (standar keamanan), server menolak akses (Forbidden).

## Cara Antisipasi & Solusi

### 1. Ubah Document Root (Direkomendasikan)
Anda perlu mengubah konfigurasi Web Server agar mengarah ke folder `public`.

**Jika menggunakan XAMPP/Apache (Virtual Host):**
Buka file konfigurasi Virtual Host (`httpd-vhosts.conf` atau konfigurasi site terkait) dan ubah `DocumentRoot` serta `Directory`:

```apache
<VirtualHost *:80>
    ServerName www.terangbysrt.com
    # UBAH BARIS INI: Tambahkan /public di akhir path
    DocumentRoot "/path/to/your/project/srt-laravel/public"
    
    <Directory "/path/to/your/project/srt-laravel/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
*Ganti `/path/to/your/project/` dengan path asli di komputer/server Anda.*

**Setelah mengubah konfigurasi, jangan lupa RESTART layanan Apache.**

### 2. Cek Permissions (Izin Akses)
Pastikan folder-folder berikut memiliki izin akses yang benar agar aplikasi bisa berjalan:

Jalankan perintah ini di terminal (jika server berbasis Linux/Mac):
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
Jika `storage` tidak bisa ditulisi, biasanya akan muncul Error 500, bukan 403, tapi ini langkah antisipasi standar setelah clone.

### 3. Pastikan File `.htaccess` Ada
Anda sudah memiliki file `.htaccess` yang benar di dalam folder `public/`. Pastikan konfigurasi Apache Anda mengizinkan `AllowOverride All` agar file ini terbaca (seperti pada contoh di poin 1).

---

**Ringkasan:** Masalah ini adalah masalah konfigurasi server, bukan kode program. Kunci utamanya adalah mengarahkan domain `www.terangbysrt.com` langsung ke folder `public` di dalam project Laravel Anda.
