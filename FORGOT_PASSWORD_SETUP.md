# Setup Forgot Password - TERANG By SRT

## Status Implementasi
✅ Route sudah tersedia (`/forgot-password`)  
✅ Controller sudah ada (`PasswordResetLinkController`)  
✅ View sudah ada (`resources/views/auth/forgot-password.blade.php`)  
✅ Database migration sudah ada (`password_reset_tokens` table)  
⚠️ **Konfigurasi email SMTP belum diatur**

## Langkah Setup SMTP Gmail

### 1. Buat App Password di Gmail
1. Login ke akun Gmail yang akan dipakai
2. Buka https://myaccount.google.com/security
3. Aktifkan "2-Step Verification" (wajib)
4. Setelah aktif, kembali ke Security → pilih "App passwords"
5. Pilih app: "Mail", device: "Other" → beri nama "TERANG By SRT"
6. Copy password 16 karakter yang digenerate (format: xxxx xxxx xxxx xxxx)

### 2. Update File .env

Ganti nilai placeholder di `.env` dengan:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-anda@gmail.com
MAIL_PASSWORD=app-password-16-digit-tanpa-spasi
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@terangbysrt.com
MAIL_FROM_NAME="TERANG By SRT"
```

**Contoh:**
```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=rekrutmensrt@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@terangbysrt.com
MAIL_FROM_NAME="TERANG By SRT"
```

### 3. Clear Cache (Lokal & Server)

**Lokal:**
```bash
php artisan config:clear
php artisan cache:clear
```

**Server:**
```bash
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan cache:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:cache
```

### 4. Test Forgot Password

**Via Browser:**
1. Buka https://terangbysrt.com/login
2. Klik "Lupa password?"
3. Masukkan email user yang terdaftar
4. Klik "Kirim Link Reset Password"
5. Cek inbox email → klik link reset
6. Set password baru → submit
7. Login dengan password baru

**Via Tinker (test kirim email):**
```bash
php artisan tinker
```
```php
Mail::raw('Test email dari TERANG By SRT', function($msg) {
    $msg->to('test@example.com')->subject('Test Email');
});
```

## Troubleshooting

### Error: "Failed to authenticate on SMTP server"
- Pastikan 2-Step Verification aktif di Gmail
- Gunakan App Password (bukan password Gmail biasa)
- Cek MAIL_USERNAME dan MAIL_PASSWORD tidak ada typo

### Error: "Connection could not be established"
- Cek firewall server mengizinkan port 587 keluar
- Pastikan MAIL_HOST dan MAIL_PORT benar
- Test koneksi: `telnet smtp.gmail.com 587`

### Email masuk ke Spam
- Verifikasi domain dengan SPF/DKIM records
- Gunakan email pengirim yang profesional
- Hindari kata-kata spam di subject/body

### Link reset expired
- Default expiry: 60 menit (config di `config/auth.php`)
- User harus klik link dalam 1 jam setelah request

## Alternatif SMTP Provider

Jika Gmail bermasalah, gunakan:

**1. Mailgun (recommended untuk production)**
- Free tier: 5000 email/bulan
- Setup: https://mailgun.com
- Update .env:
```dotenv
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.terangbysrt.com
MAILGUN_SECRET=your-mailgun-key
```

**2. SendGrid**
- Free tier: 100 email/hari
- Update .env:
```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
```

**3. AWS SES (untuk volume besar)**
- Sangat murah (1000 email = $0.10)
- Butuh verifikasi domain

## Checklist Deploy ke Production

- [ ] Update `.env` di server dengan kredensial SMTP yang benar
- [ ] Jalankan `php artisan config:cache` di server
- [ ] Test forgot password flow end-to-end
- [ ] Verifikasi email tidak masuk spam
- [ ] Set up monitoring untuk email failures
- [ ] Dokumentasikan kredensial SMTP di password manager tim

## Security Notes

⚠️ **JANGAN commit file `.env` ke Git**  
⚠️ Simpan App Password Gmail di password manager (LastPass/1Password)  
⚠️ Rotate password secara berkala (3-6 bulan)  
⚠️ Monitor log email untuk detect abuse
