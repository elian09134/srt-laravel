# Perbaikan Permission Directory (chmod 755)

Karena symlink sudah benar tapi masih 403, penyebab paling mungkin adalah **Web Server tidak bisa "masuk"** ke dalam folder `terangbysrt` karena permission-nya terlalu ketat (`drwxr-x---` atau 750). Server biasanya butuh akses `px` (traverse) atau 755.

## Solusi: Buka Akses Folder Folder Utama

Jalankan perintah berikut satu per satu di terminal:

```bash
# 1. Buka akses folder project agar bisa ditembus web server
chmod 755 /home/hcmsrt/terangbysrt

# 2. Buka akses folder public juga
chmod 755 /home/hcmsrt/terangbysrt/public

# 3. Pastikan permission file index.php benar
chmod 644 /home/hcmsrt/terangbysrt/public/index.php
```

### Penjelasan:
- Permission `755` berarti **Owner** bisa tulis/baca, **Group** dan **Others** (termasuk web server) hanya bisa baca/masuk directory. Ini aman untuk folder aplikasi.

Setelah menjalankan 3 perintah di atas, coba refresh website kembali.
