# Perbaikan Konfigurasi Server (Symlink Method) - Update

Dari screenshot yang Anda kirim, terlihat bahwa **`public_html` sudah berupa Symlink** (ada ikon panah kecil).
Namun, kemungkinan besar symlink tersebut mengarah ke lokasi yang salah atau kosong, sehingga menyebabkan Error 403.

Kita perlu **menimpa (force)** symlink tersebut agar mengarah ke folder project Laravel yang benar.

## Langkah Perbaikan via Terminal (SSH / CPanel Terminal)

Jalankan perintah berikut. Perhatikan penambahan opsi `-fn` (force & no-dereference) untuk menimpa link yang sudah ada.

```bash
ln -sfn /home/hcmsrt/terangbysrt/public /home/hcmsrt/public_html
```

### Penjelasan Perintah:
- `ln -s`: Membuat pemintas (symbolic link).
- `-f` (force): Memaksa menimpa jika `public_html` sudah ada.
- `-n`: Memperlakukan symlink tujuan sebagai file biasa (penting karena `public_html` sudah jadi link).
- `/home/hcmsrt/terangbysrt/public`: Sumber (folder `public` Laravel Anda).
- `/home/hcmsrt/public_html`: Tujuan (link yang akan diakses web server).

## Verifikasi
Setelah menjalankan perintah di atas, cek kembali dengan:
```bash
ls -la /home/hcmsrt
```
Pastikan hasilnya seperti ini:
`public_html -> /home/hcmsrt/terangbysrt/public`

Sekarang coba refresh website Anda.
