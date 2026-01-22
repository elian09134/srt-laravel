# Cara Mencegah Error 403 & Deployment Checklist

Masalah ini terjadi karena perbedaan standar antara **Laravel** (root = `public/`) dan **cPanel/Hosting** (root = `public_html`). Setiap kali Anda setup di server baru, hal ini pasti akan terjadi lagi jika tidak diantisipasi.

Berikut adalah **SOP (Standard Operating Procedure)** agar deployment berikutnya mulus:

## 1. Pahami Struktur Folder Server
Jangan letakkan atau ekstrak source code *langsung* di dalam folder `public_html`.
- **Salah:** `/home/user/public_html/ (isi file laravel)` ❌ (File `.env` dsb jadi terekspos publik!)
- **Benar:** `/home/user/nama_project/` ✅ (Sejajar dengan `public_html`)

## 2. Checklist Deployment (Wajib Dilakukan Tiap Setup Awal)

Setiap kali clone project baru di server cPanel/Shared Hosting, selalu jalankan 3 langkah "Ritual" ini:

### A. Setup Symlink (Sekali Saja di Awal)
Pastikan server tahu folder mana yang harus dibuka. Hapus folder `public_html` bawaan cPanel, lalu ganti dengan symlink.

```bash
# Hapus/Backup folder asli
mv public_html public_html_bak

# Buat Symlink ke folder public Laravel
ln -s /home/username/nama_project/public /home/username/public_html
```

### B. Fix Permissions (Wajib Setelah Clone/Pull)
Git biasanya mereset permission file. Pastikan folder bisa dibaca server (755) dan file storage bisa ditulis (775).

```bash
# 1. Buka akses folder project (Agar server bisa masuk)
chmod 755 /home/username/nama_project

# 2. Buka akses folder public
chmod 755 /home/username/nama_project/public

# 3. Beri izin tulis untuk Storage (Agar tidak error 500)
chmod -R 775 /home/username/nama_project/storage
chmod -R 775 /home/username/nama_project/bootstrap/cache
```

### C. Cek Owner (Jika Login sebagai Root)
Jika Anda setup menggunakan user `root`, jangan lupa kembalikan kepemilikan file ke user asli hosting.

```bash
chown -R username:username /home/username/nama_project
chown -h username:username /home/username/public_html
```

---

**Tips Tambahan:** simpan perintah-perintah di atas dalam satu file script (misal `deploy_fix.sh`) di root project Anda, jadi kalau ada error serupa, tinggal jalankan script-nya.
